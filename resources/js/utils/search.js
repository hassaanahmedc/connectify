import { CACHE } from './storage';
import { debounce } from './performance';
import { generateSearchDropdownHtml } from "./templete";
import { QUERY_MIN_LENGTH, CACHE_LIMIT } from '../config/constants';

const cache = new CACHE(CACHE_LIMIT);

/** getSearchResults is used to fetch search results from the server.
 * @param {String} query 
 * @param {object} options
 * @returns {Promise<Array>} 
 */

export async function getSearchResults(query, searchRoute, { signal } = {}) {
  console.log("in getSearchResults")
  if (!query || query.length < QUERY_MIN_LENGTH) return [];
  if (query && searchRoute) console.log("query:", query, "route:", searchRoute);
  const cached = cache.get(query);
  if (cached) return cached;

  const res = await fetch(`${searchRoute}?q=${encodeURIComponent(query)}`, {
    signal,
  });
  if (!res.ok) throw new Error("Network error");

  let data;
  try {
    data = await res.json();
  } catch (error) {
    throw new Error("invalid json response");
  }
  
  console.log("data returned:", data.results)
  cache.store(query, data.results);
  return data.results;
}

/** appendSearchResults is used to append data into search dropdown 
 * @param {Array} results 
 * @param {HTMLElement} dropdownElement 
 */

export function appendSearchResults(results, dropdownElement) {
  const list = dropdownElement.querySelector("ul");

  if (!results || results.length === 0) {
    list.innerHTML = `<li class="p-2 text-gray-500">No results found</li>`;
    dropdownElement.classList.remove("hidden");
    return;
  }
  list.innerHTML = `<li class="p-2 text-gray-500">Loading…</li>`;
  dropdownElement.classList.remove("hidden");
  const html = results
  .map((r) => {
      return generateSearchDropdownHtml(r)
    }).join("");

  list.innerHTML = html;
  dropdownElement.classList.remove("hidden");
}

/** setupSearch sets up search funcitonality for both input and output 
  by combining getSearchREsults and appendSearchResult functions together
 * @param {HTMLElement} InputElement  - The search input element
 * @param {string} searchRoute - The API route for search
 * @param {HTMLElement} dropdownElement - The dropdown element to append search results
 */

export function setupSearch(InputElement, searchRoute, dropdownElement) {
  if (!InputElement || !dropdownElement) return;

  let lastQuery = "";
  let controller = null;

  InputElement.addEventListener(
    "input",
    debounce(async function (e) {
      const query = e.target.value.trim();

      if (query.length < QUERY_MIN_LENGTH) {
        dropdownElement.classList.add("hidden");
        return;
      }

      if (controller) controller.abort();
      controller = new AbortController();
      const { signal } = controller;

      lastQuery = query;
      // calling functions to get search data from API and insert it in the DOM
      try { 
        const results = await getSearchResults(query, searchRoute, { signal });
        console.log('[search] got results; lastQuery=', lastQuery, 'query=', query);
          if (query !== lastQuery) {
            console.log('[search] stale result ignored for', query);
            return;
          } 

        try {
          appendSearchResults(results, dropdownElement);
        } catch (renderError) {
          console.log("error in appendSearchResults", renderError)
        }

      } catch (error) {
        if (error.name === "AbortError") return;
      }
    }, 500),
  );
}