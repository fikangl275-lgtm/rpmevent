<?php

session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'admin'){

    header("Location: ../auth/login.php");

    exit;
}

# =========================================
# TAMBAH PIC
# =========================================

if(isset($_POST['tambah_pic'])){

    $nama     = mysqli_real_escape_string($conn,$_POST['nama']);

    $email    = mysqli_real_escape_string($conn,$_POST['email']);

    $username = mysqli_real_escape_string($conn,$_POST['username']);

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if(

        empty($nama) ||

        empty($email) ||

        empty($username) ||

        empty($_POST['password'])

    ){

        echo "

        <script>

        alert('Semua form wajib diisi');

        window.location='data_pic.php';

        </script>

        ";

        exit;
    }

    $cek = mysqli_query($conn,"
    SELECT * FROM pic
    WHERE username='$username'
    ");

    if(mysqli_num_rows($cek) > 0){

        echo "

        <script>

        alert('Username sudah digunakan');

        window.location='data_pic.php';

        </script>

        ";

        exit;
    }

    mysqli_query($conn,"
    INSERT INTO pic(

    nama_pic,
    email,
    username,
    password

    )

    VALUES(

    '$nama',

    '$email',

    '$username',

    '$password'

    )
    ");

    echo "

    <script>

    alert('PIC berhasil ditambahkan');

    window.location='data_pic.php';

    </script>

    ";

}

# =========================================
# UPDATE PIC
# =========================================

if(isset($_POST['update_pic'])){

    $id       = $_POST['id_pic'];

    $nama     = mysqli_real_escape_string($conn,$_POST['nama']);

    $email    = mysqli_real_escape_string($conn,$_POST['email']);

    $username = mysqli_real_escape_string($conn,$_POST['username']);

    $password = $_POST['password'];

    if(empty($password)){

        mysqli_query($conn,"
        UPDATE pic SET

        nama_pic='$nama',
        email='$email',
        username='$username'

        WHERE id_pic='$id'
        ");

    }

    else{

        $password_hash = password_hash(
        $password,
        PASSWORD_DEFAULT
        );

        mysqli_query($conn,"
        UPDATE pic SET

        nama_pic='$nama',
        email='$email',
        username='$username',
        password='$password_hash'

        WHERE id_pic='$id'
        ");

    }

    echo "

    <script>

    alert('Data PIC berhasil diupdate');

    window.location='data_pic.php';

    </script>

    ";

}

# =========================================
# AMBIL DATA EDIT
# =========================================

$edit_mode = false;

$edit_data = null;

if(isset($_GET['edit'])){

    $edit_mode = true;

    $id_edit = $_GET['edit'];

    $ambil = mysqli_query($conn,"
    SELECT * FROM pic
    WHERE id_pic='$id_edit'
    ");

    $edit_data = mysqli_fetch_array($ambil);

}

# =========================================
# DATA PIC
# =========================================

$data = mysqli_query($conn,"
SELECT * FROM pic
ORDER BY id_pic DESC
");

?>

<!DOCTYPE html>
<html>
<head>

<title>Data PIC</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI';
}

body{
    background:#edf2f7;
}

.sidebar{
    width:260px;
    height:100vh;
    background:linear-gradient(180deg,#0f172a,#1e293b);
    position:fixed;
    left:0;
    top:0;
    padding:30px 20px;
    overflow:auto;
}

.logo{
    color:white;
    text-align:center;
    margin-bottom:50px;
}

.logo h2{
    font-size:28px;
}

.logo p{
    color:#94a3b8;
}

.menu a{
    display:block;
    padding:15px;
    margin-bottom:15px;
    text-decoration:none;
    color:#cbd5e1;
    border-radius:12px;
    transition:0.3s;
}

.menu a:hover{
    background:#2563eb;
    color:white;
}

.main{
    margin-left:260px;
    padding:40px;
}

.topbar{
    background:white;
    padding:20px 30px;
    border-radius:20px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
    margin-bottom:30px;
}

.container{
    display:grid;
    grid-template-columns:1fr 1.5fr;
    gap:30px;
}

.form-box{
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
    height:max-content;
}

.form-box h2{
    margin-bottom:25px;
    color:#0f172a;
}

.input-group{
    margin-bottom:20px;
}

.input-group label{
    display:block;
    margin-bottom:10px;
    color:#334155;
    font-weight:600;
}

.input-group input{
    width:100%;
    padding:14px;
    border:1px solid #cbd5e1;
    border-radius:12px;
    outline:none;
    font-size:14px;
}

.input-group input:focus{
    border-color:#2563eb;
}

.info{
    background:#eff6ff;
    color:#1e40af;
    padding:14px;
    border-radius:12px;
    margin-bottom:20px;
    line-height:1.7;
}

.btn-submit{
    width:100%;
    padding:15px;
    border:none;
    background:#2563eb;
    color:white;
    border-radius:12px;
    font-size:15px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.btn-submit:hover{
    background:#1d4ed8;
}

.table-box{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 8px 20px rgba(0,0,0,0.08);
}

.table-box h2{
    margin-bottom:20px;
    color:#0f172a;
}

table{
    width:100%;
    border-collapse:collapse;
}

table th{
    background:#f8fafc;
    padding:15px;
    text-align:left;
}

table td{
    padding:15px;
    border-bottom:1px solid #e2e8f0;
}

.action-btn{
    width:38px;
    height:38px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    border-radius:10px;
    text-decoration:none;
    color:white;
    margin-right:5px;
    transition:0.3s;
}

.edit-btn{
    background:#f59e0b;
}

.edit-btn:hover{
    background:#d97706;
    transform:scale(1.05);
}

.delete-btn{
    background:#ef4444;
}

.delete-btn:hover{
    background:#dc2626;
    transform:scale(1.05);
}

@media(max-width:1000px){

    .container{
        grid-template-columns:1fr;
    }

}

</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>
<body>

<div class="sidebar">
    <div class="logo">
        <h2>RPM</h2>
        <p>Admin Dashboard</p>
    </div>
    <div class="menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="data_pic.php">Data PIC</a>
        <a href="approval_event.php">Approval Event</a>
        <a href="rekap_event.php">Rekap Event</a>
        <a href="progress_event.php">Progress Event</a>
        <a href="data_mom.php">Minutes Of Meeting</a>
        <a href="data_laporan.php">Laporan Event</a>
        <a href="../auth/logout.php">Logout</a>
    </div>
</div>

<div class="main">

    <div class="topbar">

        <h1>Data PIC Event</h1>

    </div>

    <div class="container">

        <div class="form-box">

            <?php if($edit_mode){ ?>

            <h2>Edit PIC</h2>

            <div class="info">

                Kosongkan password jika tidak ingin mengganti password.

            </div>

            <form method="POST">

                <input 
                type="hidden"
                name="id_pic"
                value="<?= $edit_data['id_pic'] ?>">

                <div class="input-group">

                    <label>Nama PIC</label>

                    <input 
                    type="text"
                    name="nama"
                    value="<?= $edit_data['nama_pic'] ?>">

                </div>

                <div class="input-group">

                    <label>Email</label>

                    <input 
                    type="email"
                    name="email"
                    value="<?= $edit_data['email'] ?>">

                </div>

                <div class="input-group">

                    <label>Username</label>

                    <input 
                    type="text"
                    name="username"
                    value="<?= $edit_data['username'] ?>">

                </div>

                <div class="input-group">

                    <label>Password Baru</label>

                    <input 
                    type="password"
                    name="password"
                    placeholder="Kosongkan jika tidak diganti">

                </div>

                <button 
                type="submit"
                name="update_pic"
                class="btn-submit">

                    UPDATE DATA PIC

                </button>

            </form>

            <?php } else { ?>

            <h2>Tambah PIC</h2>

            <form method="POST">

                <div class="input-group">

                    <label>Nama PIC</label>

                    <input 
                    type="text"
                    name="nama"
                    placeholder="Masukkan nama PIC">

                </div>

                <div class="input-group">

                    <label>Email</label>

                    <input 
                    type="email"
                    name="email"
                    placeholder="Masukkan email PIC">

                </div>

                <div class="input-group">

                    <label>Username</label>

                    <input 
                    type="text"
                    name="username"
                    placeholder="Masukkan username">

                </div>

                <div class="input-group">

                    <label>Password</label>

                    <input 
                    type="password"
                    name="password"
                    placeholder="Masukkan password">

                </div>

                <button 
                type="submit"
                name="tambah_pic"
                class="btn-submit">

                    SIMPAN DATA PIC

                </button>

            </form>

            <?php } ?>

        </div>

        <div class="table-box">

            <h2>List PIC Event</h2>

            <table>

                <tr>

                    <th>No</th>

                    <th>Nama PIC</th>

                    <th>Email</th>

                    <th>Username</th>

                    <th>Aksi</th>

                </tr>

                <?php

                $no = 1;

                while($d = mysqli_fetch_array($data)){

                ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td><?= $d['nama_pic'] ?></td>

                    <td><?= $d['email'] ?></td>

                    <td><?= $d['username'] ?></td>

<td>

    <a
    href="data_pic.php?edit=<?= $d['id_pic'] ?>"
    class="action-btn edit-btn"
    title="Edit PIC">

        <i class="fas fa-pen"></i>

    </a>

    <a
    href="hapus_pic.php?id=<?= $d['id_pic'] ?>"
    class="action-btn delete-btn"
    onclick="return confirm('Yakin ingin menghapus PIC ini?')"
    title="Hapus PIC">

        <i class="fas fa-trash"></i>

    </a>

</td>

                </tr>

                <?php } ?>

            </table>

        </div>

    </div>

</div>

</body>
</html>