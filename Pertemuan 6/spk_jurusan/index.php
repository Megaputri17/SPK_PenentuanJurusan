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
            display: block;
            margin: 20px auto;
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

        ol {
            padding-left: 20px;
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

    <button onclick="hitungSAW()">Hitung SAW & Ranking</button>

    <div id="hasil"></div>

    <script>
        function hitungSAW() {
            fetch('hitung_saw.php')
                .then(res => res.json())
                .then(data => {

                    let html = '<h2>Hasil Rekomendasi Jurusan</h2>';

                    for (let id_siswa in data.data) {

                        html += `<div class="card">`;
                        html += '<h3>Siswa ID: ' + id_siswa + '</h3>';
                        html += '<ol>';

                        data.data[id_siswa].forEach(item => {
                            html += `<li>
                                Alternatif ID: ${item.id_alternatif} 
                                — Skor: <b>${item.skor}</b>
                            </li>`;
                        });

                        html += '</ol>';
                        html += `</div>`;
                    }

                    document.getElementById('hasil').innerHTML = html;
                });
        }
    </script>

</body>

</html>

