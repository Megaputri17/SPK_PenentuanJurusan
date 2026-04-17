<!DOCTYPE html>
<html>

<head>
    <title>SPK Rekomendasi Jurusan</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        h2 {
            color: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        th {
            background: #4CAF50;
            color: white;
            padding: 10px;
        }

        td {
            padding: 8px;
            text-align: center;
        }

        tr:nth-child(even) {
            background: #f2f2f2;
        }

        tr:hover {
            background: #e6f7ff;
        }

        button {
            display: inline-block;
            margin: 10px;
            padding: 12px 25px;
            font-size: 16px;
            background: #007BFF;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        #hasil {
            margin-top: 30px;
        }

        .card {
            background: white;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .highlight {
            background: #d4edda !important;
            font-weight: bold;
        }
    </style>
</head>

<body>

<h1>Sistem Pendukung Keputusan - Rekomendasi Jurusan</h1>

<?php
include 'koneksi.php';
$res = mysqli_query($conn, "SELECT * FROM siswa");
$rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
?>

<h2>Data Siswa</h2>
<table>
<tr>
<th>Nama</th>
<th>NISN</th>
<th>Kelas</th>
<th>Jurusan SMK</th>
<th>Rata TKJ</th>
<th>Rata Akhir</th>
<th>Pilihan 1</th>
<th>Pilihan 2</th>
</tr>

<?php foreach ($rows as $r): ?>
<tr>
<td><?= $r['nama'] ?></td>
<td><?= $r['nisn'] ?></td>
<td><?= $r['kelas'] ?></td>
<td><?= $r['jurusan_smk'] ?></td>
<td><?= $r['rata_tkj'] ?></td>
<td><?= $r['rata_akhir'] ?></td>
<td><?= $r['jurusan_1'] ?></td>
<td><?= $r['jurusan_2'] ?></td>
</tr>
<?php endforeach; ?>
</table>

<center>
<button onclick="hitungSAW()">Hitung SAW</button>
<button onclick="evaluasi()">Evaluasi</button>
</center>

<div id="hasil"></div>

<script>

// ============================
// HITUNG SAW
// ============================
function hitungSAW() {
    fetch('hitung_saw.php')
    .then(res => res.json())
    .then(data => {

        let html = '<h2>Hasil Ranking SAW</h2>';

        for (let id_siswa in data.data) {

            html += `<div class="card">`;
            html += `<h3>Siswa ID: ${id_siswa}</h3>`;
            html += '<ol>';

            data.data[id_siswa].forEach(item => {
                html += `<li>
                    Alternatif ID: ${item.id_alternatif} 
                    — Skor: <b>${item.skor}</b>
                </li>`;
            });

            html += '</ol></div>';
        }

        document.getElementById('hasil').innerHTML = html;
    });
}

// ============================
// EVALUASI
// ============================
function evaluasi() {
    fetch('evaluasi.php')
    .then(res => res.json())
    .then(data => {

        let html = '<h2>Evaluasi Sistem</h2>';

        html += `
        <div class="card">
            <p><b>Spearman Correlation:</b> ${data.spearman}</p>
            <p><b>Akurasi Top-1:</b> ${data.akurasi_top1}%</p>
            <p><b>Akurasi Top-2:</b> ${data.akurasi_top2}%</p>
            <p><b>Akurasi Top-3:</b> ${data.akurasi_top3}%</p>
            <p><b>Total Data:</b> ${data.total_data}</p>
        </div>
        `;

        html += '<h2>Detail Ranking per Siswa</h2>';

        for (let id in data.detail) {

            html += `<div class="card">`;
            html += `<h3>Siswa ID: ${id}</h3>`;

            html += `
            <table>
                <tr>
                    <th>Jurusan</th>
                    <th>Ranking</th>
                </tr>
            `;

            data.detail[id].forEach(item => {
                html += `
                <tr ${item.ranking == 1 ? 'class="highlight"' : ''}>
                    <td>${item.nama_alternatif}</td>
                    <td>${item.ranking}</td>
                </tr>
                `;
            });

            html += `</table></div>`;
        }

        document.getElementById('hasil').innerHTML = html;
    });
}

</script>

</body>
</html>