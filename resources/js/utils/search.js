import { CACHE } from './storage';
import { debounce } from './performance';
import { generateSearchDropdownHtml } from './templete';
import { generateLocationDropdownHtml } from './templete';
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

export async function getSearchResults(url, { signal, headers } = {}) {
    const normalizeUrl = url.toLowerCase();
    const cached = cache.get(normalizeUrl);
    if (cached) return cached;

    const res = await fetchData(url, { signal, headers });
    const data = res;

    cache.store(normalizeUrl, data);
    return data;
}

/** appendSearchResults is used to append data into search dropdown
 * @param {Array} resultsPayload
 * @param {HTMLElement} dropdownElement
 */

export function appendSearchResults(resultsPayload, searchResultsContainer) {

    if (!resultsPayload) {
        console.error('appendSearchResults: resultsPayload is undefined or null', resultsPayload);
        if (searchResultsContainer) searchResultsContainer.classList.add('hidden');
        return;
    }

    if (!searchResultsContainer) {
        console.warn("appendSearchResults: container not found");
        return;
    }

    if (typeof resultsPayload.html === "string") {
        searchResultsContainer.innerHTML = resultsPayload.html;
        container.classList.remove("hidden");
        return;
    }

    if (Array.isArray(resultsPayload) && typeof resultsPayload[0] === "string") {
        const html = resultsPayload.map(r => generateLocationDropdownHtml(r)).join('');
        searchResultsContainer.innerHTML = html;
        searchResultsContainer.classList.remove('hidden');
        return;
    }

    if (Array.isArray(resultsPayload.results)) {
        const html = resultsPayload.results.map(r => generateSearchDropdownHtml(r)).join('');
        searchResultsContainer.innerHTML = html;
        searchResultsContainer.classList.remove('hidden');
        return;
    }
    
    console.error("appendSearchResults: unexpected payload format", resultsPayload);
}

/** setupSearch sets up search funcitonality for both input and output 
  by combining getSearchREsults and appendSearchResult functions together
 * @param {HTMLElement} SearchInputElement  - The search input element
 * @param {string} searchRoute - The API route for search
 * @param {HTMLElement} dropdownElement - The dropdown element to append search results
 */
let lastQuery = '';
let controller = null;

async function performSearch({ query, route, filters = [], container, headers = {} } = {}) {
    console.log('performSearch called with', query, filters);
    if (query.length < QUERY_MIN_LENGTH) {
        container.classList.add('hidden'); 
        return;
    }

    if (container.querySelector('ul')) {
        const listEl = container.querySelector('ul');
        listEl.innerHTML = generateLoadingHtml();
        container.classList.remove('hidden');
    }

    lastQuery = query;

    if (controller) controller.abort();
    controller = new AbortController();
    const { signal } = controller;

    const params = new URLSearchParams();
    params.set('q', query);

    const valid = filters.filter(f => searchFilters.includes(f));
    valid.forEach(f => params.set(f, '1'));

    const paramString = params.toString();
    const url = `${route}?${paramString}`;

    // calling functions to get search data from API and insert it in the DOM
    try {
        console.log('performSearch: fetching', url);
        const results = await getSearchResults(url, { signal, headers });
        
        if (query !== lastQuery) {
          console.log('performSearch: result stale, ignoring', query)
          return
        }

        try {
            appendSearchResults(results, container);
        } catch (renderError) {
            console.error('performSearch -> appendSearchResults error', renderError);
        }
    } catch (error) {
        if (error.name === 'AbortError') return;
        console.error('performSearch: unexpected fetch error', error);
    }
}
export function setupSearchDropdown({ searchInput, searchRoute, dropdownContainer } = {}) {
    if (!searchInput || !searchInput) return;
    
    const onInput = debounce(function (e) {
        const query = e.target.value.trim();
        performSearch({ 
            query: query, 
            route: searchRoute, 
            container: dropdownContainer, 
            headers: { 'X-Search-Context': 'dropdown' } });
    }, 500);

    searchInput.addEventListener('input', onInput);
}

export function setupSearchPage({ searchInput, searchRoute, resultsContainer, filterGetter, filterContainer } ={}) {
    if (filterContainer) {
        const container = document.querySelector(filterContainer);
        if (container) {
            container.addEventListener('change', (e) => {
                const query = searchInput.value.trim();
                const filterArray = typeof filterGetter === 'function' ? filterGetter() : [];
                console.log('Filters changed:', filterArray);
                performSearch({ 
                    query: query, 
                    route: searchRoute, 
                    filters: filterArray, 
                    container: resultsContainer, 
                    headers: { 'X-Search-Context': 'results' } });
            });
        };
    };
}