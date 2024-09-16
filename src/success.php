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

// Pastikan 'idnumber' tersedia di GET
if (!isset($_GET['idnumber'])) {
    die("ID Number tidak ditemukan.");
}

$idnumber = intval($_GET['idnumber']);

// Menggunakan prepared statement untuk menghindari SQL Injection
$stmt = $conn->prepare("SELECT * FROM pemesanan WHERE idnumber = ? ORDER BY id DESC LIMIT 1");

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $idnumber);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="../img/png-transparent-hotel-motel-gratis-hotel-text-presentation-logo-thumbnail.png" alt="Hotel Logo" width="40" height="40">
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

<div class="container my-5">
    <?php
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo "<p>Nama Pemesan : " . htmlspecialchars($row['nama']) . "<br>";
        echo "Nomor Identitas : " . htmlspecialchars($row['idnumber']) . "<br>";
        echo "Nomor Handphone : " . htmlspecialchars($row['noHp']) . "<br>";
        echo "Jenis Kelamin : " . htmlspecialchars($row['gender']) . "<br>";
        echo "Tipe Kamar : " . htmlspecialchars($row['roomtype']) . "<br>";
        echo "Durasi Penginapan : " . htmlspecialchars($row['durasiMenginap']) . "<br>";
        if ($row['durasiMenginap'] > 3) {
            echo "Discount : 10%<br>";
        } else {
            echo "Discount : 0%<br>";
        }
        echo "Total Bayar : Rp " . htmlspecialchars(number_format($row['totalBayar'], 2, ',', '.')) . "</p><br>";
        if ($row['roomtype'] == "Standard"){
            echo "<img src='../img/Muji Hotel Shenzhen, China - Hotel Review _ Condé Nast Traveler.jpeg' class='card' >";
        }
        elseif ($row['roomtype'] == "Deluxe"){
            echo "<img src='../img/Gallery of KC Grande Resort & Spa-Hillside _ Foundry of Space  - 12.jpeg' class='card'>";
        }
        else {
            echo "<img src='../img/★★★★★ The Royal Park Hotel Iconic Osaka Midosuji, Осака, Япония.jpeg' class='card'>";
        }
    } else {
        echo "<p>Tidak ada data yang ditemukan untuk ID Number ini.</p>";
    }
    $stmt->close();
    $conn->close();
    ?>
</div>

<footer class="bg-dark text-white py-4 mt-5">
    <div class="container text-center">
        <p class="mb-0">Hotel &copy; 2024. All Rights Reserved.</p>
    </div>
</footer>
</body>
</html>
