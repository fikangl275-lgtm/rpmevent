<?php

session_start();

include '../config/koneksi.php';

$username = $_POST['username'];

$password = $_POST['password'];

# ======================
# LOGIN ADMIN
# ======================

$admin = mysqli_query($conn,"
SELECT * FROM admin
WHERE username='$username'
");

if(mysqli_num_rows($admin) > 0){

    $data = mysqli_fetch_array($admin);

    if(password_verify($password, $data['password'])){

        $_SESSION['login'] = true;

        $_SESSION['role'] = 'admin';

        $_SESSION['nama'] = $data['nama_admin'];

        $_SESSION['username'] = $data['username'];

        header("Location: ../admin/dashboard.php");

        exit;
    }
}

# ======================
# LOGIN PIC
# ======================

$pic = mysqli_query($conn,"
SELECT * FROM pic
WHERE username='$username'
");

if(mysqli_num_rows($pic) > 0){

    $data = mysqli_fetch_array($pic);

    if(password_verify($password, $data['password'])){

        $_SESSION['login'] = true;

        $_SESSION['role'] = 'pic';

        $_SESSION['nama'] = $data['nama_pic'];

        $_SESSION['username'] = $data['username'];

        $_SESSION['id_pic'] = $data['id_pic'];

        header("Location: ../pic/dashboard.php");

        exit;
    }
}

# ======================
# LOGIN KLIEN
# ======================

$klien = mysqli_query($conn,"
SELECT * FROM klien
WHERE username='$username'
");

if(mysqli_num_rows($klien) > 0){

    $data = mysqli_fetch_array($klien);

    if(password_verify($password, $data['password'])){

        $_SESSION['login'] = true;

        $_SESSION['role'] = 'klien';

        $_SESSION['nama'] = $data['nama'];

        $_SESSION['username'] = $data['username'];

        $_SESSION['id_klien'] = $data['id_klien'];

        header("Location: ../klient/dashboard.php");

        exit;
    }
}

echo "

<script>

alert('Username atau Password Salah');

window.location='login.php';

</script>

";

?>