import { setupSearchDropdown } from '../../utils/search';
import { setupSearchPage } from '../../utils/search';
import { SEARCH_ROUTE } from '../../config/constants';

// Search input and dropdown elements for both views
const searchInputDesktop = document.getElementById('search-nav-desktop');
const searchDropdownDesktop = document.getElementById('search-results-desktop');
const searchInputMobile = document.getElementById('search-nav-mobile');
const searchDropdownMobile = document.getElementById('search-results-mobile');

// Container used to display results on full search page
const searchResultsContainer = document.getElementById('searchResults');

// Read filters from checkboxes
function readfilters(container) {
    const filters = document.querySelector(container)
    if (!filters) return []
    return Array.from(filters.querySelectorAll('input[type="checkbox"]:checked')).map(
        cb => cb.value
    );
}

// Initialize dropdown-based live search for Desktop navbar
setupSearchDropdown({
    searchInput: searchInputDesktop,
    searchRoute: SEARCH_ROUTE,
    dropdownContainer: searchDropdownDesktop,
});

// Initialize dropdown-based live search for Mobile navbar
setupSearchDropdown({
    searchInput: searchInputMobile,
    searchRoute: SEARCH_ROUTE,
    dropdownContainer: searchDropdownMobile,
});

// Initialize search page behavior for Desktop
setupSearchPage({
    searchInput: searchInputDesktop,
    searchRoute: SEARCH_ROUTE,
    resultsContainer: searchResultsContainer,
    filterGetter: () => readfilters('#filter-container-desktop'),
    filterContainer: '#filter-container-desktop',
});

// Initialize search page behavior for Mobile
setupSearchPage({
    searchInput: searchInputMobile,
    searchRoute: SEARCH_ROUTE,
    resultsContainer: searchResultsContainer,
    filterGetter: () => readfilters('#filter-container-mobile'),
    filterContainer: '#filter-container-mobile',
});
