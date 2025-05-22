
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const lat = urlParams.get('lat');
    const lng = urlParams.get('lng');

    if (lat && lng) {
        // Fokuskan ke marker atau tambahkan marker
        map.setView([lat, lng], 100);

        L.circle([lat, lng], {
            radius: 10,
            color: 'red'
        }).addTo(map).bindPopup("Lokasi yang dicari").openPopup();
    }
});