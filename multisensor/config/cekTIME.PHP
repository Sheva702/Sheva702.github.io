<?php  
    // Koneksi ke database
    $konek = mysqli_connect("localhost", "root", "", "sensor_data");

    // Pengecekan koneksi
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
    if ($data = mysqli_fetch_array($sql)) {
        $TIME = $data['TIME'];
    } else {
        $TIME = 0; // Jika tidak ada data, set TIME ke 0
    }

    // Jika TIME kosong atau NULL, set TIME menjadi 0
    if (empty($TIME)) {
        $TIME = 0;
    }

    // Tampilkan nilai TIME
    echo $TIME;
?>
