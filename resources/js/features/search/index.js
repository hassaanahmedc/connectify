import { setupSearchDropdown } from '../../utils/search';
import { setupSearchPage } from '../../utils/search';
import { SEARCH_ROUTE } from '../../config/constants';

const searchInputDesktop = document.getElementById('search-nav-desktop');
const searchDropdownDesktop = document.getElementById('search-results-desktop');
const searchInputMobile = document.getElementById('search-nav-mobile');
const searchDropdownMobile = document.getElementById('search-results-mobile');
const searchResultsContainer = document.getElementById('searchResults');

function readfilters() {
    return Array.from(document.querySelectorAll('input[type="checkbox"]:checked')).map(
        cb => cb.value
    );
}

setupSearchDropdown({
    searchInput: searchInputDesktop,
    searchRoute: SEARCH_ROUTE,
    dropdownContainer: searchDropdownDesktop,
});

setupSearchDropdown({
    searchInput: searchInputMobile,
    searchRoute: SEARCH_ROUTE,
    dropdownContainer: searchDropdownMobile,
});

setupSearchPage({
    searchInput: searchInputDesktop,
    searchRoute: SEARCH_ROUTE,
    resultsContainer: searchResultsContainer,
    filterGetter: readfilters,
    filterContainer: '#search-filters',
});
