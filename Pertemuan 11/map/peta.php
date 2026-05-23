<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html>

<head>

    <title>Web GIS Zonasi Sekolah</title>

    <link rel="stylesheet"
    href="https://unpkg.com/leaflet/dist/leaflet.css"/>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>

        #map{
            height: 100vh;
        }

    </style>

</head>

<body>

<div id="map"></div>

<script>

// INISIALISASI MAP
var map = L.map('map').setView([-8.1, 112.2], 10);

// BASEMAP
L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
{
    attribution: 'OpenStreetMap'
}).addTo(map);

<?php

$query = mysqli_query($conn,
"SELECT * FROM zonasi_sekolah");

while($d = mysqli_fetch_assoc($query)){

    // WARNA BERDASARKAN RANKING
    $warna = 'red';

    if($d['ranking_saw'] == 1){

        $warna = 'green';

    }
    elseif($d['ranking_saw'] <= 3){

        $warna = 'orange';

    }

    echo "

    L.circleMarker([
        {$d['latitude']},
        {$d['longitude']}
    ], {

        color: '$warna',
        radius: 8

    })

    .addTo(map)

    .bindPopup(

        '<b>ID Lokasi:</b> {$d['id_lokasi']}<br>' +

        '<b>Ranking:</b> {$d['ranking_saw']}<br>' +

        '<b>Nilai SAW:</b> {$d['nilai_saw']}<br>' +

        '<b>Skor ML:</b> {$d['skor_ml']}'

    );

    ";
}

?>

</script>

</body>
</html>