<?php

include '../config/koneksi.php';

$nama_pic  = htmlspecialchars($_POST['nama_pic']);

$email     = htmlspecialchars($_POST['email']);

$username  = htmlspecialchars($_POST['username']);

$password  = $_POST['password'];

# =========================
# VALIDASI
# =========================

if(

    empty($nama_pic) ||

    empty($email) ||

    empty($username) ||

    empty($password)

){

    echo "

    <script>

    alert('Semua form wajib diisi');

    window.location='tambah_pic.php';

    </script>

    ";

    exit;
}

# =========================
# CEK USERNAME
# =========================

$cek = mysqli_query($conn,"
SELECT * FROM pic
WHERE username='$username'
");

if(mysqli_num_rows($cek) > 0){

    echo "

    <script>

    alert('Username sudah digunakan');

    window.location='tambah_pic.php';

    </script>

    ";

    exit;
}

# =========================
# HASH PASSWORD
# =========================

$password_hash = password_hash($password, PASSWORD_DEFAULT);

# =========================
# INSERT
# =========================

mysqli_query($conn,"
INSERT INTO pic VALUES(

'',

'$nama_pic',

'$email',

'$username',

'$password_hash'

)
");

echo "

<script>

alert('PIC berhasil ditambahkan');

window.location='data_pic.php';

</script>

";

?>