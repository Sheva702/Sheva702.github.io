<?php
// Koneksi ke database
$konek = mysqli_connect("localhost", "root", "", "sensor_data");

// Cek koneksi
if (mysqli_connect_errno()) {
    echo "Koneksi gagal: " . mysqli_connect_error();
    exit();
}

// Ambil semua data dari tabel sensor_readings, urutkan berdasarkan ID terlama
$sql = mysqli_query($konek, "SELECT * FROM sensor_readings ORDER BY id ASC");

// Cek apakah query berhasil
if (!$sql) {
    echo "Error: " . mysqli_error($konek);
    exit();
}

// Ambil data sebagai array
$data = [];
while ($row = mysqli_fetch_assoc($sql)) {
    $data[] = $row;
}

// Kembalikan data dalam format JSON
echo json_encode($data);
?>
