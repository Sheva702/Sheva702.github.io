<?php  
    // Koneksi ke database
    $konek = mysqli_connect("localhost", "root", "", "sensor_data");

    // Pengecekan koneksi database
    if (mysqli_connect_errno()) {
        echo "Koneksi database gagal: " . mysqli_connect_error();
        exit();
    }

    // Ambil data terakhir dari tabel sensor_readings
    $sql = mysqli_query($konek, "SELECT * FROM sensor_readings ORDER BY id DESC LIMIT 5");

    // Pengecekan query
    if (!$sql) {
        echo "Error: " . mysqli_error($konek);
        exit();
    }

    // Ambil data dari query
    $data = mysqli_fetch_array($sql);

    // Ambil nilai PH dari data
    $PH = $data['PH'];

    // Jika nilai PH kosong atau NULL, set nilai default menjadi 0
    if (empty($PH)) {
        $PH = 0;
    }

    // Format nilai PH untuk menggunakan koma sebagai pemisah desimal
    $formattedPH = number_format($PH, 2, ',', '');  // Menggunakan dua digit setelah koma

    // Tampilkan nilai PH yang sudah diformat
    echo $formattedPH;
?>
