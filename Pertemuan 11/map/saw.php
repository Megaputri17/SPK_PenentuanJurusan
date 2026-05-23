<?php

include 'koneksi.php';

// AMBIL NILAI MAX & MIN
$queryMax = mysqli_query($conn, "

SELECT
MAX(skor_ml) as max_ml,
MAX(kepadatan) as max_kepadatan,
MIN(distance) as min_distance
FROM zonasi_sekolah

");

$dataMax = mysqli_fetch_assoc($queryMax);

$max_ml = $dataMax['max_ml'];
$max_kepadatan = $dataMax['max_kepadatan'];
$min_distance = $dataMax['min_distance'];


// AMBIL SEMUA DATA
$query = mysqli_query($conn, "
SELECT * FROM zonasi_sekolah
");

$data = [];

while($d = mysqli_fetch_assoc($query)){

    // NORMALISASI

    // BENEFIT
    $r_ml = $d['skor_ml'] / $max_ml;

    $r_kepadatan = $d['kepadatan'] / $max_kepadatan;

    // COST
    $r_distance = $min_distance / $d['distance'];

    // HITUNG SAW
    $nilai = (
        (0.5 * $r_ml) +
        (0.3 * $r_kepadatan) +
        (0.2 * $r_distance)
    );

    // SIMPAN ARRAY
    $data[] = [
        'id' => $d['id'],
        'nilai' => $nilai
    ];

    // UPDATE NILAI SAW
    mysqli_query($conn, "

    UPDATE zonasi_sekolah
    SET nilai_saw = '$nilai'
    WHERE id = '".$d['id']."'

    ");
}


// SORTING RANKING
usort($data, function($a, $b){

    return $b['nilai'] <=> $a['nilai'];

});


// UPDATE RANKING
$ranking = 1;

foreach($data as $d){

    mysqli_query($conn, "

    UPDATE zonasi_sekolah
    SET ranking_saw = '$ranking'
    WHERE id = '".$d['id']."'

    ");

    $ranking++;
}

echo "Perhitungan SAW berhasil!";
?>