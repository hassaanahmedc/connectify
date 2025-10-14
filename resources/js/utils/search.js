import { CACHE } from './storage';
import { debounce } from './performance';
import { generateSearchDropdownHtml } from './templete';
import { generateNoResultsHtml } from './templete';
import { generateLoadingHtml } from './templete';
import { fetchData } from './api';
import { QUERY_MIN_LENGTH, CACHE_LIMIT } from '../config/constants';
import { searchFilters } from '../config/constants';

const cache = new CACHE(CACHE_LIMIT);

/** getSearchResults is used to fetch search results from the server.
 * @param {String} query
 * @param {object} options
 * @returns {Promise<Array>}
 */

export async function getSearchResults(url, { signal } = {}) {
    const normalizeUrl = url.toLowerCase();
    const cached = cache.get(normalizeUrl);
    if (cached) return cached;

    let data;
    const res = await fetchData(url, { signal });
    data = res

    cache.store(normalizeUrl, data.results ?? data);
    return data.results;
}

/** appendSearchResults is used to append data into search dropdown
 * @param {Array} results
 * @param {HTMLElement} dropdownElement
 */

export function appendSearchResults(results, dropdownElement) {
    console.log("inside appendSearch")
    const list = dropdownElement.querySelector('ul');
    if (!list) {
        console.error("appendSearchResults: <ul> not found in dropdownElement", dropdownElement);
        return
    } else {
        console.log("<ul> found")
    }

    if (!results || results.length === 0) {
        list.innerHTML = generateNoResultsHtml();
        dropdownElement.classList.remove('hidden');
        return;
    }

    const html = results.map(r => generateSearchDropdownHtml(r)).join('');
    console.log('appendSearchResults html:', html);
    list.innerHTML = html;
    dropdownElement.classList.remove('hidden');
}

/** setupSearch sets up search funcitonality for both input and output 
  by combining getSearchREsults and appendSearchResult functions together
 * @param {HTMLElement} SearchInputElement  - The search input element
 * @param {string} searchRoute - The API route for search
 * @param {HTMLElement} dropdownElement - The dropdown element to append search results
 */
let lastQuery = '';
let controller = null;

async function performSearch(query, fitlersArray = [], searchRoute, dropdownElement) {
    console.log('performSearch called with', query, fitlersArray);
    if (query.length < QUERY_MIN_LENGTH) {
        dropdownElement.classList.add('hidden');
        return;
    }

    lastQuery = query;

    const listEl = dropdownElement.querySelector('ul');
    if (!listEl) {
      console.log("performSearch: <ul not fopund inside dropdownElement>")
      return  
    } 

    listEl.innerHTML = generateLoadingHtml();
    dropdownElement.classList.remove('hidden');

    if (controller) controller.abort();
    controller = new AbortController();
    const { signal } = controller;

    const params = new URLSearchParams();
    params.set('q', query);

    const valid = fitlersArray.filter(f => searchFilters.includes(f));
    valid.forEach(f => params.set(f, '1'));

    const paramString = params.toString();
    const url = `${searchRoute}?${paramString}`;


    // calling functions to get search data from API and insert it in the DOM
    try {
        console.log('performSearch: fetching', url);
        const results = await getSearchResults(url, { signal });
        
        if (query !== lastQuery) {
          console.log('performSearch: result stale, ignoring', query)
          return
        }

        try {
            appendSearchResults(results, dropdownElement);
        } catch (renderError) {
            console.error('performSearch -> appendSearchResults error', renderError);
        }
    } catch (error) {
        if (error.name === 'AbortError') return;
        console.error('performSearch: unexpected fetch error', error);
    }
}
export function setupSearch(SearchInputElement, searchRoute, filterGetter, dropdownElement, filterContainer = null) {
    if (!SearchInputElement || !dropdownElement) return;

    const onInput = debounce(function (e) {
        const query = e.target.value.trim();
        const filterArray = typeof filterGetter === 'function' ? filterGetter() : [];
        performSearch(query, filterArray, searchRoute, dropdownElement);
    }, 500);

    SearchInputElement.addEventListener('input', onInput);

    if (filterContainer) {
        const container = document.querySelector(filterContainer);
        if (container) {
            container.addEventListener('change', (e) => {
                const query = SearchInputElement.value.trim();
                const filterArray = typeof filterGetter === 'function' ? filterGetter() : [];
                console.log('Filters changed:', filterArray);
                performSearch(query, filterArray, searchRoute, dropdownElement);
            });
        };
    };
}