import './bootstrap';
import 'leaflet/dist/leaflet.css';
import Alpine from 'alpinejs';
import loadMap , { showPlaceMap } from './mapa.js';

window.Alpine = Alpine;
Alpine.start();

// Ejecutar el mapa automáticamente cuando cargue el DOM
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('map')) {
        loadMap();
    }
});
window.showPlaceMap = showPlaceMap;
