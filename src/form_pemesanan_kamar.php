<?php
// Create a PHP file named "form_pemesanan_kamar.php" and paste the following code:

// Connect to the database
$conn = mysqli_connect("localhost", "root", "", "pemesanan_kamar");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Process the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST["nama"];
    $gender = $_POST["gender"];
    $idnumber = $_POST["idnumber"];
    $roomtype = $_POST["roomtype"];
    $harga = $_POST["harga"];
    $tanggalPesan = $_POST["tanggalPesan"];
    $durasiMenginap = $_POST["durasiMenginap"];
    $termasukBreakfast = $_POST["termasukBreakfast"];
    $totalBayar = $_POST["totalBayar"];

    // Insert data into the database
    $query = "INSERT INTO pemesanan_kamar (nama, gender, idnumber, roomtype, harga, tanggal_pesan, durasi_menginap, termasuk_breakfast, total_bayar) VALUES ('$nama', '$gender', '$idnumber', '$roomtype', '$harga', '$tanggalPesan', '$durasiMenginap', '$termasukBreakfast', '$totalBayar')";
    mysqli_query($conn, $query);

    // Close the database connection
    mysqli_close($conn);

    // Redirect to a success page
    header("Location: success.php");
    exit;
}

// Create a PHP file named "success.php" and paste the following code:
// <?php
// echo "Pemesanan kamar berhasil!";
?>