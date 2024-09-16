<?php
$roomtype = $_POST["roomtype"];

if ($roomtype === "Standard") {
    $hargaKamar = 500000;
} elseif ($roomtype === "Deluxe") {
    $hargaKamar = 550000;
} elseif ($roomtype === "Family") {
    $hargaKamar = 600000;
}

echo $hargaKamar;
?>