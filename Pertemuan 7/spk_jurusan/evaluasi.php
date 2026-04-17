<?php
include 'koneksi.php';

// ==============================
// 1. AMBIL HASIL SAW
// ==============================
$sql = "SELECT h.id_siswa, a.nama_alternatif, h.ranking
        FROM hasil h
        JOIN alternatif a ON h.id_alternatif = a.id_alternatif
        ORDER BY h.id_siswa, h.ranking ASC";

$res = mysqli_query($conn, $sql);
$data = mysqli_fetch_all($res, MYSQLI_ASSOC);

// ==============================
// 2. KELOMPOKKAN PER SISWA
// ==============================
$group = [];
foreach ($data as $row) {
    $group[$row['id_siswa']][] = $row;
}

// ==============================
// 3. GROUND TRUTH (DARI SISWA)
// ==============================
$ground_truth_all = [];

$q_siswa = mysqli_query($conn, "SELECT id_siswa, jurusan_1, jurusan_2 FROM siswa");

while ($s = mysqli_fetch_assoc($q_siswa)) {

    $gt = [];

    if (!empty($s['jurusan_1'])) {
        $gt[$s['jurusan_1']] = 1;
    }

    if (!empty($s['jurusan_2'])) {
        $gt[$s['jurusan_2']] = 2;
    }

    $ground_truth_all[$s['id_siswa']] = $gt;
}

// ==============================
// 4. HITUNG METRIK
// ==============================
$total_siswa = count($group);

$total_rs = 0;
$total_top1 = 0;
$total_top2 = 0;
$total_top3 = 0;

foreach ($group as $id => $items) {

    $ground_truth = $ground_truth_all[$id];

    // ======================
    // SPEARMAN
    // ======================
    $n = count($items);
    $sum_d2 = 0;
    $valid = 0;

    foreach ($items as $item) {

        $nama = $item['nama_alternatif'];
        $rank_spk = $item['ranking'];

        if (isset($ground_truth[$nama])) {

            $rank_pakar = $ground_truth[$nama];

            $d = $rank_spk - $rank_pakar;
            $sum_d2 += $d * $d;
            $valid++;
        }
    }

    if ($valid > 1) {
        $rs = 1 - (6 * $sum_d2) / ($valid * ($valid * $valid - 1));
        $total_rs += $rs;
    }

    // ======================
    // TOP-1
    // ======================
    $top1_spk = $items[0]['nama_alternatif'] ?? '';
    $top1_gt  = array_search(1, $ground_truth);

    if ($top1_spk == $top1_gt) {
        $total_top1++;
    }

    // ======================
    // TOP-2 (FIX BARU)
    // ======================
    $top2_spk = array_slice(array_column($items, 'nama_alternatif'), 0, 2);
    $top2_gt  = array_keys($ground_truth); // jurusan_1 & jurusan_2

    $cocok2 = count(array_intersect($top2_spk, $top2_gt));

    if ($cocok2 > 0) {
        $total_top2++;
    }

    // ======================
    // TOP-3
    // ======================
    $top3_spk = array_slice(array_column($items, 'nama_alternatif'), 0, 3);
    $top3_gt  = array_keys($ground_truth);

    $cocok3 = count(array_intersect($top3_spk, $top3_gt));

    if ($cocok3 > 0) {
        $total_top3++;
    }
}

// ==============================
// 5. HASIL AKHIR
// ==============================
$avg_rs = ($total_siswa > 0) ? $total_rs / $total_siswa : 0;
$akurasi_top1 = ($total_siswa > 0) ? ($total_top1 / $total_siswa) * 100 : 0;
$akurasi_top2 = ($total_siswa > 0) ? ($total_top2 / $total_siswa) * 100 : 0;
$akurasi_top3 = ($total_siswa > 0) ? ($total_top3 / $total_siswa) * 100 : 0;

// ==============================
// 6. OUTPUT JSON
// ==============================
header('Content-Type: application/json');

echo json_encode([
    'status' => 'ok',
    'spearman' => round($avg_rs, 4),
    'akurasi_top1' => round($akurasi_top1, 2),
    'akurasi_top2' => round($akurasi_top2, 2),
    'akurasi_top3' => round($akurasi_top3, 2),
    'total_data' => $total_siswa,
    'detail' => $group
]);
?>