<?php

include 'koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM zonasi_sekolah");

while($d = mysqli_fetch_assoc($query)){

    // DATA YANG DIKIRIM KE FASTAPI
    $payload = json_encode([

        "kepadatan" => $d['kepadatan'],
        "jarak_jalan" => $d['distance'],
        "sekolah_eksisting" => $d['sekolah_eksisting']

    ]);

    // CURL
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8000/predict_zonasi");

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

    curl_setopt($ch, CURLOPT_HTTPHEADER, [

        'Content-Type: application/json'

    ]);

    $response = curl_exec($ch);

    curl_close($ch);

    // HASIL DARI FASTAPI
    $hasil = json_decode($response, true);

    $skor = $hasil['skor_kelayakan'];

    // UPDATE DATABASE
    mysqli_query($conn, "

        UPDATE zonasi_sekolah
        SET skor_ml = '$skor'
        WHERE id = '".$d['id']."'

    ");
}

echo "Prediksi Machine Learning berhasil disimpan!";

?>