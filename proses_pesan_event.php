<?php

session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'klien'){

    header("Location: ../auth/login.php");

    exit;
}

$id_klien = $_SESSION['id_klien'];

$nama_event      = mysqli_real_escape_string($conn, $_POST['nama_event']);
$jenis_event     = mysqli_real_escape_string($conn, $_POST['jenis_event']);
$kategori_event  = mysqli_real_escape_string($conn, $_POST['kategori_event']);
$tanggal_event   = $_POST['tanggal_event'];
$lokasi_event    = mysqli_real_escape_string($conn, $_POST['lokasi_event']);
$jumlah_peserta  = $_POST['jumlah_peserta'];
$budget_event    = mysqli_real_escape_string($conn, $_POST['budget_event']);
$kebutuhan_event = mysqli_real_escape_string($conn, $_POST['kebutuhan_event']);
$deskripsi       = mysqli_real_escape_string($conn, $_POST['deskripsi']);

$status = "pending";
if($tanggal_event < date('Y-m-d')){

    echo "

    <script>

    alert('Tanggal event tidak boleh lebih kecil dari tanggal hari ini');

    window.location='pesan_event.php';

    </script>

    ";

    exit;
}

if(

    empty($nama_event) ||
    empty($jenis_event) ||
    empty($kategori_event) ||
    empty($tanggal_event) ||
    empty($lokasi_event) ||
    empty($jumlah_peserta) ||
    empty($budget_event) ||
    empty($kebutuhan_event) ||
    empty($deskripsi)

){

    echo "

    <script>

    alert('Semua data wajib diisi');

    window.location='pesan_event.php';

    </script>

    ";

    exit;
}

if(!file_exists("../uploads")){

    mkdir("../uploads", 0777, true);

}

$file_name_baru = "";

if(isset($_FILES['proposal']) && $_FILES['proposal']['error'] == 0){

    $namaFile   = $_FILES['proposal']['name'];
    $tmpFile    = $_FILES['proposal']['tmp_name'];
    $ukuranFile = $_FILES['proposal']['size'];

    // Validasi ekstensi file
    $ext = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

    $ekstensiDiizinkan = array("pdf");

    if(!in_array($ext, $ekstensiDiizinkan)){

        echo "

        <script>

        alert('Proposal hanya boleh berformat PDF!');

        window.location='pesan_event.php';

        </script>

        ";

        exit;
    }

    // Validasi ukuran file (5 MB)
    $maxSize = 5 * 1024 * 1024;

    if($ukuranFile > $maxSize){

        echo "

        <script>

        alert('Ukuran file maksimal 5 MB!');

        window.location='pesan_event.php';

        </script>

        ";

        exit;
    }

    // Membuat nama file baru
    $file_name_baru = time().'_'.$namaFile;

    // Upload file
    if(!move_uploaded_file($tmpFile,"../uploads/".$file_name_baru)){

        echo "

        <script>

        alert('Upload proposal gagal!');

        window.location='pesan_event.php';

        </script>

        ";

        exit;
    }

}

$query = mysqli_query($conn, "

INSERT INTO event_request(

id_klien,
id_pic,
nama_event,
jenis_event,
kategori_event,
tanggal_event,
lokasi_event,
jumlah_peserta,
budget_event,
kebutuhan_event,
deskripsi,
status,
file_proposal,
progress_event

)

VALUES(

'$id_klien',
NULL,
'$nama_event',
'$jenis_event',
'$kategori_event',
'$tanggal_event',
'$lokasi_event',
'$jumlah_peserta',
'$budget_event',
'$kebutuhan_event',
'$deskripsi',
'$status',
'$file_name_baru',
'Belum Diproses'

)

");

if($query){

    echo "

    <script>

    alert('Permintaan event berhasil dikirim');

    window.location='status_event.php';

    </script>

    ";

}else{

    echo "

    <script>

    alert('Gagal mengirim permintaan event');

    window.location='pesan_event.php';

    </script>

    ";

}

?>