<?php

include '../config/koneksi.php';

$nama       = htmlspecialchars($_POST['nama']);

$email      = htmlspecialchars($_POST['email']);

$no_hp      = htmlspecialchars($_POST['no_hp']);

$username   = htmlspecialchars($_POST['username']);

$password   = $_POST['password'];

# =========================
# VALIDASI FORM KOSONG
# =========================

if(

    empty($nama) ||

    empty($email) ||

    empty($no_hp) ||

    empty($username) ||

    empty($password)

){

    echo "

    <script>

    alert('Semua form wajib diisi');

    window.location='register.php';

    </script>

    ";

    exit;
}

# =========================
# CEK USERNAME
# =========================

$cek = mysqli_query($conn,"
SELECT * FROM klien
WHERE username='$username'
");

if(mysqli_num_rows($cek) > 0){

    echo "

    <script>

    alert('Username sudah digunakan');

    window.location='register.php';

    </script>

    ";

    exit;
}

# =========================
# HASH PASSWORD
# =========================

$password_hash = password_hash($password, PASSWORD_DEFAULT);

# =========================
# INSERT DATA
# =========================

mysqli_query($conn,"
INSERT INTO klien VALUES(

'',

'$nama',

'$email',

'$no_hp',

'$username',

'$password_hash'

)
");

echo "

<script>

alert('Register berhasil');

window.location='login.php';

</script>

";

?>