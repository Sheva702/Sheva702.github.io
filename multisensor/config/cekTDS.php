<?php  
    // Koneksi ke database
    $konek = mysqli_connect("localhost", "root", "", "sensor_data");

    // Pengecekan koneksi database
    if (mysqli_connect_errno()) {
        echo "Koneksi database gagal: " . mysqli_connect_error();
        exit();
    }

    // Ambil semua data dari tabel sensor_readings, urutkan berdasarkan ID terlama
    $sql = mysqli_query($konek, "SELECT * FROM sensor_readings ORDER BY id ASC");

    // Pengecekan query
    if (!$sql) {
        echo "Error: " . mysqli_error($konek);
        exit();
    }

    // Ambil data dari query
    $data = mysqli_fetch_array($sql);

    // Ambil nilai TDS dari data
    $TDS = $data['TDS'];

    // Jika nilai TDS kosong atau NULL, set nilai default menjadi 0
    if (empty($TDS)) {
        $TDS = 0;
    }

    // Format nilai TDS untuk menggunakan koma sebagai pemisah desimal
    $formattedTDS = number_format($TDS, 2, ',', '');  // Menggunakan dua digit setelah koma

    // Tampilkan nilai TDS yang sudah diformat
    echo $formattedTDS;
?>
