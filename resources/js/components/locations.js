import { debounce } from '../utils/performance';
import { appendSearchResults } from '../utils/search';
import { QUERY_MIN_LENGTH } from '../config/constants';

const locationsDropdown = document.getElementById('location-dropdown')
const locationsInput = document.getElementById('location-input')

let locations = [];

await fetch('/data/locations.json')
    .then(response => response.json())
    .then(data => locations = data)
    .catch(error => console.error('Error fetching locations:', error));



    function filterlocations(query) {
        if (!query.trim()) return [];
    
        query = query.toLowerCase();
    
        return locations.flatMap(location => {
            const matchedCities = location.cities.filter(
                city => city.toLowerCase().includes(query)
            );
            return matchedCities.map(city => `${city}, ${location.name}`);
        }).slice(0, 10);
    }

    const onInput = debounce(function (e) {
        const NoResults = ['No Cities Found'];
        const query = e.target.value.trim()
        if (query.length > QUERY_MIN_LENGTH ) {
            const results = filterlocations(query);
            if (results.length === 0) appendSearchResults(NoResults, locationsDropdown);
            appendSearchResults(results, locationsDropdown)
        }
    }, 500)
    
    locationsInput.addEventListener('input', onInput);

const updateLocationImput = () => {
    locationsDropdown.addEventListener('click', (e) => {
        let currrentIndex = e.target.dataset.location;
        locationsInput.value = currrentIndex;
        locationsDropdown.classList.add('hidden');
    })
}

updateLocationImput()





