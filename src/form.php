<?php
// Konfigurasi koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pemesanan_kamar";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menangani submit form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo $_POST['tanggalPesan'];
    echo "<br>";
    // Validasi dan sanitasi input dari form
    $nama = htmlspecialchars($conn->real_escape_string($_POST['nama']));
    $gender = htmlspecialchars($conn->real_escape_string($_POST['gender']));
    $idnumber = htmlspecialchars($conn->real_escape_string($_POST['idnumber']));
    $noHp = htmlspecialchars($_POST['noHp']);
    $roomtype = htmlspecialchars($conn->real_escape_string($_POST['roomtype']));
    $harga = intval(str_replace(["Rp ", ".", ","], "", $_POST['harga']));
    $tanggalPesan = $_POST['tanggalPesan'];
    $durasiMenginap = intval($_POST['durasiMenginap']);
    $termasukBreakfast = isset($_POST['termasukBreakfast']) ? 1 : 0;
    $totalBayar = intval(str_replace(["Rp ", ".", ","], "", $_POST['totalBayar']));

    // Debug: Cek nilai-nilai yang akan diinsert
    error_log("Nama: $nama");
    error_log("Gender: $gender");
    error_log("ID Number: $idnumber");
    error_log("Room Type: $roomtype");
    error_log("Harga: $harga");
    error_log("Tanggal Pesan: $tanggalPesan");
    error_log("Durasi Menginap: $durasiMenginap");
    error_log("Termasuk Breakfast: $termasukBreakfast");
    error_log("Total Bayar: $totalBayar");

    // Menggunakan prepared statement untuk menghindari SQL Injection
    $stmt = $conn->prepare("INSERT INTO pemesanan (nama, gender, idnumber, roomtype, harga, tanggalPesan, durasiMenginap, termasukBreakfast, totalBayar, noHp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssississ", $nama, $gender, $idnumber, $roomtype, $harga, $tanggalPesan, $durasiMenginap, $termasukBreakfast, $totalBayar, $noHp);

    if ($stmt->execute()) {
        header("Location: success.php?idnumber=".$idnumber."");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan Kamar - Hotel XYZ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../img/png-transparent-hotel-motel-gratis-hotel-text-presentation-logo-thumbnail.png" alt="Hotel Logo" width="40" height="40">
                <!-- <span class="ms-2">Hotel</span> -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-black" href="form.php">Room Order</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="bg-light py-5 text-center">
        <div class="container">
            <h1 class="display-4">Welcome to Hotel XYZ</h1>
            <p class="lead">Experience luxury and comfort at an affordable price</p>
        </div>
    </div>

    <!-- Form Section -->
    <div class="container my-5">
        <div class="card shadow-lg">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Form Pemesanan Kamar</h2>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pemesan</label>
                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Luthfi Aditya" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="gender1" value="Laki-Laki" checked>
                            <label class="form-check-label" for="gender1">
                                Laki-Laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" id="gender2" value="Perempuan">
                            <label class="form-check-label" for="gender2">
                                Perempuan
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="idnumber" class="form-label">Nomor Identitas</label>
                        <input type="text" id="idnumber" name="idnumber" class="form-control" placeholder="36XXXXXXXXXXXXXX" required />
                    </div>
                    <div class="mb-3">
                        <label for="noHp" class="form-label">Nomor Handphone</label>
                        <input type="text" id="noHp" name="noHp" class="form-control" placeholder="08" max="13" required />
                    </div>
                    <div class="mb-3">
                        <label for="roomtype" class="form-label">Tipe Kamar</label>
                        <select id="roomtype" name="roomtype" class="form-select">
                            <option value="Standard">Standard</option>
                            <option value="Deluxe">Deluxe</option>
                            <option value="Family">Family</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="text" id="harga" name="harga" value="Rp 500.000,00" readonly class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="tanggalPesan" class="form-label">Tanggal Pemesanan</label>
                        <input type="date" id="tanggalPesan" name="tanggalPesan" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="durasiMenginap" class="form-label">Durasi Menginap</label>
                        <input type="number" id="durasiMenginap" name="durasiMenginap" value="1" class="form-control" required />
                    </div>
                    <div class="mb-3">
                        <label for="totalBayar" class="form-label">Harga Total</label>
                        <input type="text" id="totalBayar" name="totalBayar" readonly class="form-control" placeholder="Total bayar akan muncul di sini" required />
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="termasukBreakfast" name="termasukBreakfast" value="1" checked>
                        <label class="form-check-label" for="termasukBreakfast">
                            Termasuk <a href="#" class="text-primary">Sarapan</a>.
                        </label>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" onclick="hitungTotalBayar()" class="btn btn-primary">Hitung Total</button>
                        <button type="submit" id="submitBtn" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">Hotel &copy; 2024. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateHarga() {
            const roomType = document.getElementById("roomtype").value;
            let hargaKamar = 0;

            switch (roomType) {
                case "Standard":
                    hargaKamar = 500000;
                    break;
                case "Deluxe":
                    hargaKamar = 750000;
                    break;
                case "Family":
                    hargaKamar = 1000000;
                    break;
            }

            // Update harga input field with plain number
            document.getElementById("harga").value = hargaKamar;
        }

        function hitungTotalBayar() {
            // Update room price
            updateHarga();

            const harga = parseInt(document.getElementById("harga").value);
            const durasiMenginap = parseInt(document.getElementById("durasiMenginap").value);
            const termasukBreakfast = document.getElementById("termasukBreakfast").checked;
            const tambahanBreakfast = termasukBreakfast ? 50000 * durasiMenginap : 0;

            // Calculate total payment
            let totalBayar = (durasiMenginap > 3) ? (harga * durasiMenginap + tambahanBreakfast) * 0.9 : harga * durasiMenginap + tambahanBreakfast;

            // Update total payment input field without formatting
            document.getElementById("totalBayar").value = totalBayar;
        }
        
        // Initialize harga and total bayar on page load
        updateHarga();
    </script>
</body>

</html>
