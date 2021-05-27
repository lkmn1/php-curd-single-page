<?php
require_once('Lib/config.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>latihan crud</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css">
    <style>
        body {
            height: 100vh;
            overflow: hidden;
        }

        .data-tabel::-webkit-scrollbar {
            overflow: hidden;
        }
    </style>
</head>

<body>
    <nav class="navbar container mb-5" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <h2 class="is-size-4">List Anime Yang Mau Di Tonton</h2>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
    </nav>

    <!-- Delete File -->
    <div class="container d-block m-auto" style="max-width: 400px;">

        <?php if (isset($_GET['id'])) : //jika benar mendapatkan GET id dari URL

            $id = $_GET['id']; //membuat variabel $id yang menyimpan nilai dari $_GET['id']

            //melakukan query ke database, dengan cara SELECT data yang memiliki id yang sama dengan variabel $id
            $cek = mysqli_query($koneksi, "SELECT * FROM anime WHERE id='$id'") or die(mysqli_error($koneksi)); ?>

            <?php if (mysqli_num_rows($cek) > 0) { //jika query menghasilkan nilai > 0 maka eksekusi script di bawah

                //query ke database DELETE untuk menghapus data dengan kondisi id=$id
                $del = mysqli_query($koneksi, "DELETE FROM anime WHERE id='$id'") or die(mysqli_error($koneksi)); ?>

                <?php if ($del) { ?>
                    <article class="message is-success">
                        <div class="message-header">
                            <p>Berhasil</p>
                            <button class="delete" aria-label="delete"></button>
                        </div>
                        <div class="message-body">
                            Berhasil Dihapus <a href="index.php" class="button is-success is-small">OK</a>
                        </div>
                    </article>
                <?php } ?>
            <?php } ?>
        <?php endif; ?>
        <!-- jika query menghasilkan nilai 0 -->
        <?php if (mysqli_num_rows($sql) == 0) { ?>
            <div class="notification is-danger">
                <button class="delete"></button>
                Tidak Ada Data Yang Ditemukan
            </div>
        <?php } ?>
    </div>

    <!-- Main section -->
    <main class="mr-6 mt-6 columns">
        <!-- Tabel -->
        <div class="column is-two-thirds data-tabel" id="table" style="height: 85vh; overflow-y: scroll;">
            <table class="table container">
                <thead class="has-text-centered">
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Rilis</th>
                        <th>Studio</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($sql) > 0) :  //jika query diatas menghasilkan nilai > 0 maka menjalankan script di bawah if
                        //membuat variabel $no untuk menyimpan nomor urut
                        $no = 1; ?>
                        <?php while ($data = mysqli_fetch_assoc($sql)) : //melakukan perulangan while dengan dari dari query $sql
                            // variable untuk menampung isi data dari database
                            $judul = $data['judul'];
                            $rilis = $data['rilis'];
                            $studio = $data['studio']; ?>
                            <tr>
                                <!-- menampilkan data dari hasil perulangan -->
                                <td><?= $no; ?></td>
                                <td><?= htmlspecialchars(strtoupper($judul)); ?></td>
                                <td><?= htmlspecialchars(strtoupper($rilis)); ?></td>
                                <td><?= htmlspecialchars(strtoupper($studio)); ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $data['id']; ?>" class="button is-link is-small  mx-3">Edit</a>
                                    <a href="index.php?id=<?= $data['id']; ?>" class="button is-danger is-small is-outlined">Delete</a>
                                </td>
                                <?php $no++ ?>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Add Data Form -->
        <div class="mt-6 mr-6 column box" style="height: 385px;" id="tambahData">
            <h2 class="has-text-centered">Tambah Data Film</h2>
            <hr>
            <?php if (isset($_POST['submit'])) :
                $judul            = $_POST['judul'];
                $rilis    = $_POST['rilis'];
                $studio        = $_POST['studio'];

                $cek = mysqli_query($koneksi, "SELECT * FROM anime WHERE judul='$judul'") or die(mysqli_error($koneksi)); ?>

                <?php if (mysqli_num_rows($cek) == 0) :
                    $sql = mysqli_query($koneksi, "INSERT INTO anime(judul, rilis, studio) VALUES('$judul', '$rilis', '$studio')") or die(mysqli_error($koneksi)); ?>
                    <?php if ($sql) : ?>
                        <article class="message is-info">
                            <div class="message-header">
                                <p>Info</p>
                                <button class="delete" aria-label="delete"></button>
                            </div>
                            <div class="message-body">
                                Data Baru Berhasil Ditambahkan
                                <a href="index.php" class="button is-link is-outlined is-small mx-4"> OK</a>
                            </div>
                        </article>
                    <?php else : ?>
                        <article class="message is-warning">
                            <div class="message-header">
                                <p>Warning</p>
                                <button class="delete" aria-label="delete"></button>
                            </div>
                            <div class="message-body">
                                Gagal Melakukan Proses Tambah Data
                            </div>
                        </article>
                        }
                    <?php endif; ?>

                <?php else : ?>
                    <article class="message is-danger">
                        <div class="message-header">
                            <p>Warning</p>
                            <button class="delete" aria-label="delete"></button>
                        </div>
                        <div class="message-body">
                            Gagal, Data Sudah Ada
                        </div>
                    </article>
                <?php endif; ?>

            <?php endif; ?>

            <form action="index.php" method="post">
                <!-- Input Judul Film -->
                <label for="judul">Judul Animie</label>
                <input class="input is-link" type=" text" placeholder="Masukan Judul" name="judul" id="judul" required>
                <!-- Input Tahun Rilis -->
                <label for="rilis">Tahun Rilis</label>
                <input class="input is-info" type=" text" placeholder="Info input" name="rilis" id="rilis" required>
                <!-- Input Studio Pembuat -->
                <label for="studio">Link</label>
                <input class="input is-primary" type=" text" placeholder="Info input" name="studio" id="studio">

                <div class="has-text-centered">
                    <label>&nbsp;</label>
                    <button type="submit" name="submit" class="button is-link is-light mt-5">SIMPAN</button>
                </div>
            </form>
        </div>

    </main>

</body>

</html>