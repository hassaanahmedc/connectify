import './bootstrap';
import { fetchData } from './utils/api.js';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.fetchData = fetchData;

Alpine.start();
