<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

<div id="map" class="rounded-lg" style="height: 400px; min-height: 320px;"></div>

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var lat = <?= floatval($lat) ?>;
    var lng = <?= floatval($lng) ?>;
    var map = L.map('map').setView([lat, lng], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.de/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);
    L.marker([lat, lng]).addTo(map)
      .bindPopup('<strong><?= Str::esc($popup) ?></strong>')
      .openPopup();
  });
</script>
