<?php
include 'koneksi.php';

// 1. Ambil data kriteria
$q_kriteria = mysqli_query($conn, "SELECT * FROM kriteria");
$kriteria = [];
while ($k = mysqli_fetch_assoc($q_kriteria)) {
    $kriteria[$k['id_kriteria']] = $k;
}

// 2. Ambil semua siswa
$q_siswa = mysqli_query($conn, "SELECT * FROM siswa");

$hasil_all = [];

while ($siswa = mysqli_fetch_assoc($q_siswa)) {

    $id_siswa = $siswa['id_siswa'];

    // 3. Ambil nilai + nama alternatif
    $q_nilai = mysqli_query($conn, "
        SELECT n.*, a.nama_alternatif
        FROM nilai n
        JOIN alternatif a ON n.id_alternatif = a.id_alternatif
        WHERE n.id_siswa = $id_siswa
    ");

    $data = [];
    $nama_alt = [];

    while ($row = mysqli_fetch_assoc($q_nilai)) {
        $data[$row['id_alternatif']][$row['id_kriteria']] = $row['nilai'];
        $nama_alt[$row['id_alternatif']] = $row['nama_alternatif'];
    }

    // ❗ skip kalau tidak ada data
    if (empty($data))
        continue;

    // 4. Cari MAX & MIN
    $max = [];
    $min = [];

    foreach ($kriteria as $id_k => $k) {
        $kolom = [];

        foreach ($data as $alt) {
            if (isset($alt[$id_k])) {
                $kolom[] = $alt[$id_k];
            }
        }

        if (!empty($kolom)) {
            $max[$id_k] = max($kolom);
            $min[$id_k] = min($kolom);
        }
    }

    // 5. Hitung SAW
    $hasil = [];

    foreach ($data as $id_alt => $nilai_kriteria) {

        $skor = 0;

        foreach ($kriteria as $id_k => $k) {

            // ❗ kalau tidak ada nilai → skip
            if (!isset($nilai_kriteria[$id_k]))
                continue;

            $nilai = $nilai_kriteria[$id_k];
            $bobot = $k['bobot'];
            $jenis = $k['jenis'];

            // ❗ hindari pembagian nol
            if ($jenis == 'benefit') {
                $r = ($max[$id_k] != 0) ? $nilai / $max[$id_k] : 0;
            } else {
                $r = ($nilai != 0) ? $min[$id_k] / $nilai : 0;
            }

            $skor += $bobot * $r;
        }

        $hasil[] = [
            'id_siswa' => $id_siswa,
            'id_alternatif' => $id_alt,
            'nama_alternatif' => $nama_alt[$id_alt],
            'skor' => round($skor, 4)
        ];
    }

    // 6. Ranking
    usort($hasil, fn($a, $b) => $b['skor'] <=> $a['skor']);

    // ❗ Hapus hasil lama biar tidak duplicate
    mysqli_query($conn, "DELETE FROM hasil WHERE id_siswa = $id_siswa");

    // 7. Simpan hasil
    foreach ($hasil as $rank => $h) {

        $ranking = $rank + 1;
        $skor = $h['skor'];
        $id_alt = $h['id_alternatif'];

        mysqli_query($conn, "
            INSERT INTO hasil (id_siswa, id_alternatif, skor, ranking)
            VALUES ($id_siswa, $id_alt, $skor, $ranking)
        ");
    }

    $hasil_all[$id_siswa] = $hasil;
}

// 8. Output JSON
header('Content-Type: application/json');
echo json_encode([
    'status' => 'ok',
    'data' => $hasil_all
]);
?>