<?php

// koneksi ke database
$koneksi = mysqli_connect("localhost", "root", "", "latihan");

// berikan pesan jika gagal terhubung
if (mysqli_connect_error()) {
    echo "Gagal Terhubung Dengan" . mysqli_connect_error();
}

//query ke database SELECT tabel anime urut berdasarkan id yang paling besar
$sql = mysqli_query($koneksi, "SELECT * FROM anime ORDER BY id DESC") or die(mysqli_error($koneksi));
