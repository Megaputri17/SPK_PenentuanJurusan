id="juhwca"
<?php

include 'koneksi.php';


// ======================================
// AMBIL DATA DARI DATABASE
// ======================================
$query = mysqli_query($conn, "SELECT * FROM dataset_jurusan");

$data = mysqli_fetch_all($query, MYSQLI_ASSOC);


// ======================================
// SIAPKAN PAYLOAD KE FASTAPI
// ======================================
$payload = array_map(function($d){

    return [

        "nama_siswa"      => $d['nama_siswa'],
        "kompetensi"      => (float)$d['kompetensi'],
        "nilai_akademik"  => (float)$d['nilai_akademik'],
        "jurusan_1"       => $d['jurusan_1'],
        "jurusan_2"       => $d['jurusan_2']

    ];

}, $data);


// ======================================
// KIRIM KE FASTAPI
// ======================================
$ch = curl_init("http://127.0.0.1:8000/prediksi-semua");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);


// ======================================
// VALIDASI API
// ======================================
if($http_code != 200){

    die("API ERROR");

}


// ======================================
// DECODE JSON
// ======================================
$hasil_api = json_decode($response, true);

$hasil = $hasil_api['hasil'];


// ======================================
// TAMPILAN HTML
// ======================================
?>

<!DOCTYPE html>
<html>

<head>

    <title>Integrasi ML API</title>

    <style>

        body{
            font-family: Arial;
            background: #f4f6f9;
            margin: 0;
        }

        .navbar{
            background: #007bff;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
        }

        .container{
            width: 95%;
            margin: 30px auto;
        }

        .card{
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td{
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th{
            background: #007bff;
            color: white;
        }

        tr:nth-child(even){
            background: #f2f2f2;
        }

        .rekom{
            color: green;
            font-weight: bold;
        }

    </style>

</head>

<body>

    <div class="navbar">
        Integrasi PHP + FastAPI + Random Forest
    </div>

    <div class="container">

        <div class="card">

            <h2>Hasil Prediksi Jurusan</h2>

            <table>

                <tr>
                    <th>No</th>
                    <th>Nama Siswa</th>
                    <th>Kompetensi</th>
                    <th>Nilai Akademik</th>
                    <th>Jurusan 1</th>
                    <th>% Jurusan 1</th>
                    <th>Jurusan 2</th>
                    <th>% Jurusan 2</th>
                    <th>Prediksi Jurusan</th>
                </tr>

                <?php

                $no = 1;

                foreach($hasil as $h){

                ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td><?= $h['nama_siswa'] ?></td>

                    <td><?= $h['kompetensi'] ?></td>

                    <td><?= $h['nilai_akademik'] ?></td>

                    <td><?= $h['jurusan_1'] ?></td>

                    <td><?= $h['persentase_jurusan_1'] ?>%</td>

                    <td><?= $h['jurusan_2'] ?></td>

                    <td><?= $h['persentase_jurusan_2'] ?>%</td>

                    <td class="rekom">
                        <?= $h['prediksi_jurusan'] ?>
                    </td>

                </tr>

                <?php } ?>

            </table>

        </div>

    </div>

</body>
</html>