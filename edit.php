<?php include('Lib/config.php'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latihan CRUD PHP mysql</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
</head>

<body>
    <?php
    //membuat variabel $id untuk menyimpan id dari GET id di URL
    $id = $_GET['id'];
    //jika sudah mendapatkan parameter GET id dari URL
    if (isset($_GET['id'])) {

        //query ke database SELECT tabel mahasiswa berdasarkan id = $id
        $select = mysqli_query($koneksi, "SELECT * FROM anime WHERE id='$id'") or die(mysqli_error($koneksi));

        //jika hasil query = 0 maka muncul pesan error
        if (mysqli_num_rows($select) == 0) {
            echo '<div class="alert alert-warning">ID tidak ada dalam database.</div>';
            exit();
            //jika hasil query > 0
        } else {
            //membuat variabel $data dan menyimpan data row dari query
            $data = mysqli_fetch_assoc($select);
        }
    }
    ?>

    <?php
    //jika tombol simpan di tekan/klik
    if (isset($_POST['submit'])) {
        $judul            = $_POST['judul'];
        $rilis    = $_POST['rilis'];
        $studio        = $_POST['studio'];

        $sql = mysqli_query($koneksi, "UPDATE anime SET judul='$judul', rilis='$rilis', studio='$studio' WHERE id='$id'") or die(mysqli_error($koneksi));

        if ($sql) {
            echo '<script>alert("Berhasil menyimpan data."); document.location="index.php";</script>';
        } else {
            echo '<div class="alert alert-warning">Gagal melakukan proses edit data.</div>';
        }
    }
    ?>

    <div class="container box test" style="width: 400px; margin: 9.5rem auto;">
        <h2 class="has-text-centered">Tambah Data Film</h2>
        <hr>
        <form action="edit.php?id=<?php echo $id; ?>" method="post">
            <!-- Input Judul Film -->
            <label for="judul">Judul Animie</label>
            <input class="input is-link" type="text" value="<?php echo $data['judul']; ?>" name="judul" id="judul" required>
            <!-- Input Tahun Rilis -->
            <label for="rilis">Tahun Rilis</label>
            <input class="input is-link" type="text" value="<?php echo $data['rilis']; ?>" name="rilis" id="rilis" required>
            <!-- Input Studio Pembuat -->
            <label for="studio">Link</label>
            <input class="input is-link" type="text" value="<?php echo $data['studio']; ?>" name="studio" id="studio">

            <div class="has-text-centered">
                <label>&nbsp;</label>
                <button type="submit" name="submit" class="button is-link is-light mt-5">SIMPAN</button>
            </div>
        </form>
    </div>

</body>

</html>