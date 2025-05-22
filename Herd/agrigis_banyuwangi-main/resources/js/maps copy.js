

let map = L.map('map').setView([-2.5, 118], 5);
let markerPreview = null;

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '© OpenStreetMap'
}).addTo(map);

document.getElementById("addBtn").onclick = () => {
  document.getElementById("formBox").style.display = "block";
    
};

if (navigator.geolocation) {
  navigator.geolocation.getCurrentPosition(function(position) {
    const lat = position.coords.latitude;
    const lng = position.coords.longitude;

    document.getElementById("lat").value = lat;
    document.getElementById("lng").value = lng;

    L.marker([lat, lng]).addTo(map)
      .bindPopup("Lokasi Anda Sekarang")
      .openPopup();

    map.setView([lat, lng], 13);
  }, function(error) {
    console.error("Geolocation Error: ", error);
    alert("Tidak dapat mengakses lokasi Anda. Pastikan Anda memberikan izin lokasi pada browser.");
  });
}
document.getElementById("submitButton").addEventListener("click", function() {
    simpan();
});
function simpan() {
    //------------- Nama Petani ------------------- 
    const namaPetani = document.getElementById("namaPetani").value;

    //------------- Nama Tanaman ------------------- 
    const namaTanaman = document.getElementById("nama_tanaman").value;

    //------------- Alamat ------------------- 
    const alamat = document.getElementById("alamat").value;

    //------------- Luas Lahan ------------------- 
    const luasLahan = document.getElementById("luasLahan").value;

    //------------- latitude ------------------- 
    const lat = parseFloat(document.getElementById("lat").value);

    //------------- longitude ------------------- 
    const lng = parseFloat(document.getElementById("lng").value);

    //------------- Status Lahan ------------------- 
    const statusLahan = document.getElementById("statusLahan").value;

    //------------- Status Panen ------------------- 
    const statusPanen = document.getElementById("statusPanen").value;

    //------------- Nomor Telepon ------------------- 
    const nmr_telpon = document.getElementById("nmr_telpon").value;

    //------------- NIK ------------------- 
    const nik = document.getElementById("nik").value;

    // Validasi input
    if (!namaPetani || !namaTanaman || !alamat || !luasLahan || isNaN(lat) || isNaN(lng) || !nmr_telpon || !nik) {
        alert("Lengkapi data!");
        return;
    }

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('/mapping', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            namaPetani, 
            namaTanaman, 
            luasLahan, 
            statusLahan, 
            alamat, 
            lat, 
            lng, 
            statusPanen, 
            nmr_telpon, 
            nik 
        })
    })
    .then(response => response.json()) 
    .then(data => {
        if (data.success) {
            alert('Data berhasil disimpan');
        } else {
           
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan dalam pengiriman data');
    });
}

function tampilkanMarkerBaru(loc) {
    const marker = L.marker([loc.lat, loc.lng]).addTo(map)
      .bindPopup(`
        <b>${loc.namaPetani}</b><br>
        Jenis Tanaman: ${loc.nama_tanaman}<br>
        Status Lahan: ${loc.jenis_lahan}<br>
        Status Panen: ${loc.status_tanam}<br>
        Luas Lahan: ${loc.luas_lahan} m²<br>
        Alamat: ${loc.alamat}<br>
        Nomor Telepon: ${loc.telpon}<br>
        NIK: ${loc.nik}<br>
      `);

    marker.on('popupopen', function () {
        const popupElement = document.createElement('div');
        popupElement.innerHTML = marker.getPopup().getContent();

        if (userStatus === 'Staf') {
            const editBtn = document.createElement('button');
            editBtn.textContent = 'Edit';
            editBtn.classList.add(
                'bg-yellow-500', 'text-white', 'p-2', 'rounded-lg', 'hover:bg-yellow-600', 'mt-2'
            );
            editBtn.onclick = () => editData(loc);
            popupElement.appendChild(editBtn);
        }

        marker.setPopupContent(popupElement);
    });
}

function editData(loc) {
    document.getElementById("formBox").style.display = "block";
    document.getElementById("namaPetani").value = loc.namaPetani;
    document.getElementById("nama_tanaman").value = loc.nama_tanaman;
    document.getElementById("alamat").value = loc.alamat;
    document.getElementById("lat").value = loc.lat;
    document.getElementById("lng").value = loc.lng;
    document.getElementById("luas_lahan").value = loc.luas_lahan;
    document.getElementById("status_tanam").value = loc.status_tanam;
    document.getElementById("nmr_telpon").value = loc.telpon;
    document.getElementById("nik").value = loc.nik; 

    const select = document.getElementById("jenis_lahan_id");
    const targetText = loc.jenis_lahan;
    for (let i = 0; i < select.options.length; i++) {
        if (select.options[i].text === targetText) {
            select.selectedIndex = i;
            break;
        }
    }

    document.getElementById("submitButton").onclick = () => simpanEdit(loc.id);
}


  
function simpanEdit(loc) {
  const nama = document.getElementById("nama").value;
  const jenis = document.getElementById("jenis").value;
  const waktu = document.getElementById("waktu").value;
  const alamat = document.getElementById("alamat").value;
  const lat = parseFloat(document.getElementById("lat").value);
  const lng = parseFloat(document.getElementById("lng").value);

  if (!nama || isNaN(lat) || isNaN(lng)) {
    alert("Lengkapi data!");
    return;
  }

  const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  fetch(`/mapping/${loc.id}`, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': token
    },
    body: JSON.stringify({ nama, jenis, waktu, alamat, lat, lng })
  })
  .then(res => res.json())
  .then(data => {
    console.log("Berhasil edit:", data);
    batal(); 
    updateMarker(loc, data);
  })
  .catch(err => {
    console.error("Gagal simpan perubahan:", err);
    alert("Gagal menyimpan perubahan.");
  });
}
function updateMarker(loc, updatedData) {
    // Hapus marker lama
    if (loc.marker) {
        map.removeLayer(loc.marker);
    }

    // Buat marker baru
    const marker = L.marker([updatedData.lat, updatedData.lng]).addTo(map)
        .bindPopup(`
            <b>${updatedData.namaPetani}</b><br>
            Jenis Tanaman: ${updatedData.namaTanaman}<br>
            Status Lahan: ${updatedData.statusLahan}<br>
            Status Panen: ${updatedData.statusPanen}<br>
            Luas Lahan: ${updatedData.luasLahan} m²<br>
            Alamat: ${updatedData.alamat}<br>
            Nomor Telepon: ${updatedData.nmr_telpon}<br>
            NIK: ${updatedData.nik}<br>
            Waktu: ${updatedData.waktu || '-'}<br>
            <button class="bg-yellow-500 text-white p-2 rounded-lg hover:bg-yellow-600 mt-2" onclick='editData(${JSON.stringify(updatedData)})'>Edit</button>
        `);

    loc.marker = marker;
}

map.on('click', function(e) {
  const { lat, lng } = e.latlng;
  document.getElementById("lat").value = lat;
  document.getElementById("lng").value = lng;
  tampilkanMarkerPreview(lat, lng);
  document.getElementById("formBox").style.display = "block";
});

function tampilkanMarkerPreview(lat, lng) {
  if (markerPreview) map.removeLayer(markerPreview);
  markerPreview = L.marker([lat, lng], { draggable: true }).addTo(map);
  map.setView([lat, lng], 13);
  markerPreview.on('dragend', function(e) {
    const pos = e.target.getLatLng();
    document.getElementById("lat").value = pos.lat;
    document.getElementById("lng").value = pos.lng;
  });
}
function closeForm() {
    console.log('Form is closing');
    document.getElementById("formBox").classList.add("hidden");
}
fetch('/mapping/data')
  .then(res => res.json())
  .then(data => {
    data.forEach(loc => {
      tampilkanMarkerBaru(loc);
    });
  })
  .catch(err => {
    console.error("Gagal mengambil data:", err);
    alert("Gagal memuat data.");
  });

  
  document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const lat = parseFloat(urlParams.get('lat'));
    const lng = parseFloat(urlParams.get('lng'));

    if (lat && lng) {
        map.setView([lat, lng], 15); 

        L.marker([lat, lng]).addTo(map)
            .bindPopup("Lokasi yang dicari")
            .openPopup();
    } 
});