<?php
$hargaKamar = $_POST["hargaKamar"];
$durasiMenginap = $_POST["durasiMenginap"];
$termasukSarapan = $_POST["termasukSarapan"];

$biayaSarapan = $termasukSarapan ? 50000 * $durasiMenginap : 0;
$totalBayar = ($hargaKamar * $durasiMenginap) + $biayaSarapan;

echo $totalBayar;
?>