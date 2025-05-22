
document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("formBox").style.display = 'none';
});
const ispoligon = false;
function closeForm() {
    document.getElementById("formBox").style.display = 'none';
}
    

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
    const marker = L.marker([loc.lat, loc.lng]).addTo(map);

const popupContent = `
  <div class="bg-lime-100 p-4 rounded-lg text-sm font-sans text-black w-[270px]">
    <table class="w-full text-left border-collapse">
      <tbody>
        <tr class="border-b border-black">
          <td class="font-medium w-28 py-1">Nama Petani</td>
          <td class="py-1">:</td>
          <td class="py-1">${loc.namaPetani}</td>
        </tr>
        <tr class="border-b border-black">
          <td class="font-medium py-1">Nama Tanaman</td>
          <td class="py-1">:</td>
          <td class="py-1">${loc.nama_tanaman}</td>
        </tr>
        <tr class="border-b border-black">
          <td class="font-medium py-1">Alamat</td>
          <td class="py-1">:</td>
          <td class="py-1">${loc.alamat}</td>
        </tr>
        <tr class="border-b border-black">
          <td class="font-medium py-1">Luas Lahan</td>
          <td class="py-1">:</td>
          <td class="py-1">${loc.luas_lahan}</td>
        </tr>
        <tr class="border-b border-black">
          <td class="font-medium py-1">Latitude</td>
          <td class="py-1">:</td>
          <td class="py-1">${loc.lat}</td>
        </tr>
        <tr class="border-b border-black">
          <td class="font-medium py-1">Longitude</td>
          <td class="py-1">:</td>
          <td class="py-1">${loc.lng}</td>
        </tr>
        <tr class="border-b border-black">
          <td class="font-medium py-1">Status Lahan</td>
          <td class="py-1">:</td>
          <td class="py-1">${loc.jenis_lahan}</td>
        </tr>
        <tr class="border-b border-black">
          <td class="font-medium py-1">Status Panen</td>
          <td class="py-1">:</td>
          <td class="py-1">${loc.status_tanam}</td>
        </tr>
      </tbody>
    </table>

    ${
      userStatus === 'Staf'
  ? `
  <div class="flex">
    <button id="editBtn-${loc.id}" class="flex-1 mt-2 mr-1 bg-green-900 text-white px-4 py-2 rounded hover:bg-green-800 w-full">
      Edit Data
    </button>
    <button id="polygonBtn-${loc.id}" class="flex-1 ml-1  mt-2 bg-green-700 text-white px-4 py-2 rounded hover:bg-green-600 w-full">
      Buat Poligon
    </button>
  </div>
  `
  : ''

    }
  </div>
`;
    marker.bindPopup(popupContent);
    marker.on('popupopen', function () {
        const editButton = document.getElementById(`editBtn-${loc.id}`);
        if (editButton) {
          editButton.onclick = () => editData(loc);
        }
        const poligon= document.getElementById(`polygonBtn-${loc.id}`);
        if(poligon){
          poligon.onclick = () => poligon(loc);
        }
    });
    loc.marker = marker;
}
function poligon(loc) {
  ispoligon = true;
  const el = document.getElementById('controlDraw');
  
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
console.log(window.userStatus)

map.on('click', function(e) {
if(ispoligon){
  return
}
if (window.userStatus !== 'Staf') {
    alert("Hanya staf yang dapat menambahkan data.");
    return;
  }
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


const drawnItems = new L.FeatureGroup();
map.addLayer(drawnItems);
const drawControl = new L.Control.Draw({
    edit: {
      featureGroup: drawnItems,
      edit: false,
      remove: false
    },
    draw: {
      polygon: {
        allowIntersection: false,
        showArea: true,
        color: 'green'
      },
      polyline: false,
      circle: false,
      rectangle: false,
      marker: false,
      circlemarker: false
    }
});

map.addControl(drawControl);

 
  let drawControlEdit = new L.EditToolbar.Edit(map, {
    featureGroup: drawnItems
  });

  // Aktifkan mode buat poligon
  document.getElementById('createPolygonBtn').addEventListener('click', () => {
    const drawer = new L.Draw.Polygon(map, drawControl.options.draw.polygon);
    drawer.enable();
  });

  // Aktifkan mode edit
  document.getElementById('editPolygonBtn').addEventListener('click', () => {
    drawControlEdit.enable();
  });

  // Simpan polygon (dalam kasus ini, cetak ke console)
  document.getElementById('savePolygonBtn').addEventListener('click', () => {
    drawControlEdit.disable();
    drawnItems.eachLayer(layer => {
      // itu bagian nyimpan koordinatnya
      const coords = layer.getLatLngs();
      // ------------------------------
      
    });
  });

  map.on(L.Draw.Event.CREATED, function (event) {
    drawnItems.addLayer(event.layer);
});