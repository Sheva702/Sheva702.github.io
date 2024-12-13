<!doctype html>
<html lang="en">
  <head>
    <!-- Meta tags yang diperlukan -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Nutrisi Hidroponik</title>

    <script type="text/javascript" src="jquery/jquery.min.js"></script>
    <!-- Load otomatis / real-time -->
    <script type="text/javascript">
     $(document).ready(function() {
    // Memperbarui data setiap detik
    setInterval(function() {
        // Memperbarui data TDS, PH, dan TIME dari server
        $.ajax({
            url: "ambilDataTerbaru.php",  // URL PHP untuk mengambil data terbaru
            method: "GET",
            success: function(data) {
                const rows = JSON.parse(data);  // Mengubah data JSON menjadi array
                
                // Hapus baris lama sebelum menambahkan yang baru
                $("#dataRows").empty();

                // Menambahkan baris baru untuk setiap data terbaru yang diterima
                rows.forEach(function(item, index) {
                    const rowNum = index + 1; // Nomor urut baris
                    const newRow = `
                        <tr id="row${rowNum}">
                            <th scope="row">${rowNum}</th>
                            <td><span id="cekTDS${rowNum}">${item.TDS}</span></td>
                            <td><span id="cekPH${rowNum}">${item.PH}</span></td>
                            <td><span id="cekTIME${rowNum}">${item.TIME}</span></td>
                        </tr>
                    `;
                    $("#dataRows").append(newRow);
                });
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error: ", status, error);  // Menampilkan error jika AJAX gagal
            }
        });
    }, 1000);  // Update setiap detik
});


    </script>
  </head>
  <body>

    <div class="container">
      <h2 class="text-center">Nutrisi Hidroponik</h2>

      <!-- Tabel untuk menampilkan nilai TDS, PH, dan TIME -->
      <table class="table table-bordered">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">TDS</th>
            <th scope="col">PH</th>
            <th scope="col">TIME</th>
          </tr>
        </thead>
        <tbody id="dataRows">
          <!-- Baris pertama sebagai placeholder -->
          <tr id="row1">
            <th scope="row">1</th>
            <td><span id="cekTDS1">0</span></td>
            <td><span id="cekPH1">0</span></td>
            <td><span id="cekTIME1">0</span></td>
          </tr>
        </tbody>
      </table>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
