
document.addEventListener('DOMContentLoaded', function () {
    // Coordenada inicial: si editando, usa las del registro; sino centro por defecto
    const latInput = document.getElementById('lat');
    const lngInput = document.getElementById('lng');

    const initialLat = parseFloat(latInput.value) || 4.81333;   // ejemplo Pereira
    const initialLng = parseFloat(lngInput.value) || -75.69456;
    const initialZoom = (latInput.value && lngInput.value) ? 15 : 12;

    // Crear mapa
    const map = L.map('map').setView([initialLat, initialLng], initialZoom);

    // Capa de tiles (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Icono opcional (usa el icono por defecto o uno personalizado)
    const markerIcon = L.icon({
        iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
    });

    // Agregar marcador, en modo draggable
    let marker = L.marker([initialLat, initialLng], { draggable: true, icon: markerIcon }).addTo(map);

    // Si no había coords iniciales, ocultar marcador hasta que el usuario haga clic (opcional)
    // marker.remove(); // si quieres ocultar inicialmente

    // Función para actualizar inputs cuando cambia la posición
    function updateInputs(latlng) {
        latInput.value = latlng.lat.toFixed(7);
        lngInput.value = latlng.lng.toFixed(7);
    }

    // Evento: arrastrar marcador
    marker.on('moveend', function (e) {
        updateInputs(e.target.getLatLng());
    });

    // Evento: clic en el mapa coloca el marcador allí
    map.on('click', function (e) {
        const { lat, lng } = e.latlng;
        marker.setLatLng([lat, lng]);
        updateInputs(e.latlng);
    });

    // Botón: usar geolocalización del navegador
    const btnGeo = document.getElementById('btn-geolocate');
    if (btnGeo) {
        btnGeo.addEventListener('click', function () {
            if (!navigator.geolocation) {
                alert('Geolocalización no soportada por tu navegador');
                return;
            }
            navigator.geolocation.getCurrentPosition(function (pos) {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                map.setView([lat, lng], 15);
                marker.setLatLng([lat, lng]);
                updateInputs({ lat, lng });
            }, function (err) {
                alert('No se pudo obtener la ubicación: ' + err.message);
            }, { enableHighAccuracy: true });
        });
    }

    // Si estás en modo "crear" y no quieres marcador hasta que el usuario haga clic:
    // if (!latInput.value) marker.remove();
});
