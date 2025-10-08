import { setupSearch } from "../../utils/search";
import { SEARCH_ROUTE } from "../../config/constants";

const searchInputDesktop = document.getElementById("search-nav-desktop");
const searchDropdownDesktop = document.getElementById("search-results-desktop");
const searchInputMobile = document.getElementById("search-nav-mobile");
const searchDropdownMobile = document.getElementById("search-results-mobile");

function readfilters() {
    return Array.from(document.querySelectorAll('input[type="checkbox"]:checked')).map(cb => cb.value);
}

setupSearch(searchInputDesktop, SEARCH_ROUTE, readfilters, searchDropdownDesktop, '#search-filters');
setupSearch(searchInputMobile, SEARCH_ROUTE, readfilters, searchDropdownMobile, '#search-filters')