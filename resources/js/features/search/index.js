import { setupSearch } from "../../utils/search";
import { SEARCH_ROUTE } from "../../config/constants";

const searchInputDesktop = document.getElementById("search-nav-desktop");
const searchDropdownDesktop = document.getElementById("search-results-desktop");
const searchInputMobile = document.getElementById("search-nav-mobile");
const searchDropdownMobile = document.getElementById("search-results-mobile");

setupSearch(searchInputDesktop, SEARCH_ROUTE, searchDropdownDesktop);
setupSearch(searchInputMobile, SEARCH_ROUTE, searchDropdownMobile);