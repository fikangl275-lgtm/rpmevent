<?php

session_start();
include '../config/koneksi.php';

if($_SESSION['role'] != 'pic'){
    header("Location: ../auth/login.php");
    exit;
}

$id_pic = $_SESSION['id_pic'];

# ==================================
# TAMBAH PROGRESS
# ==================================

if(isset($_POST['tambah_progress'])){

    $id_event = $_POST['id_event'];
    $nama_progress = mysqli_real_escape_string(
        $conn,
        $_POST['nama_progress']
    );

    mysqli_query($conn,"
    INSERT INTO progress_detail(
    id_event,
    nama_progress,
    status_progress
    )
    VALUES(
    '$id_event',
    '$nama_progress',
    'Belum'
    )
    ");

    header("Location: progress_event.php");
    exit;
}

# ==================================
# UBAH STATUS
# ==================================

if(isset($_GET['selesai'])){

    $id_progress = $_GET['selesai'];

    mysqli_query($conn,"
    UPDATE progress_detail
    SET status_progress='Selesai'
    WHERE id_progress='$id_progress'
    ");

    header("Location: progress_event.php");
    exit;
}

if(isset($_GET['belum'])){

    $id_progress = $_GET['belum'];

    mysqli_query($conn,"
    UPDATE progress_detail
    SET status_progress='Belum'
    WHERE id_progress='$id_progress'
    ");

    header("Location: progress_event.php");
    exit;
}

# ==================================
# HAPUS PROGRESS
# ==================================

if(isset($_GET['hapus'])){

    $id_progress = $_GET['hapus'];

    mysqli_query($conn,"
    DELETE FROM progress_detail
    WHERE id_progress='$id_progress'
    ");

    header("Location: progress_event.php");
    exit;
}

# ==================================
# UPDATE PERSENTASE
# ==================================

$event_update = mysqli_query($conn,"
SELECT id_event
FROM event_request
WHERE id_pic='$id_pic'
");

while($e = mysqli_fetch_array($event_update)){

    $id_event = $e['id_event'];

    $total = mysqli_num_rows(mysqli_query($conn,"
    SELECT *
    FROM progress_detail
    WHERE id_event='$id_event'
    "));

    $selesai = mysqli_num_rows(mysqli_query($conn,"
    SELECT *
    FROM progress_detail
    WHERE id_event='$id_event'
    AND status_progress='Selesai'
    "));

    if($total > 0){

        $persen = round(($selesai/$total)*100);

    }else{

        $persen = 0;
    }

    mysqli_query($conn,"
    UPDATE event_request
    SET progress_event='$persen%'
    WHERE id_event='$id_event'
    ");
}

$data = mysqli_query($conn,"
SELECT *
FROM event_request
WHERE id_pic='$id_pic'
AND status='disetujui'
ORDER BY id_event DESC
");

?>

<!DOCTYPE html>
<html>
<head>

<title>Kelola Progress Event</title>

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

.logo p{
color:#94a3b8;
}

.menu a{
display:block;
padding:15px;
margin-bottom:10px;
text-decoration:none;
color:#cbd5e1;
border-radius:12px;
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
box-shadow:0 5px 15px rgba(0,0,0,.05);
margin-bottom:30px;
}

.card{
background:white;
padding:25px;
border-radius:20px;
margin-bottom:30px;
box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.card h3{
margin-bottom:10px;
color:#0f172a;
}

.progress-bar{
width:100%;
height:20px;
background:#e2e8f0;
border-radius:20px;
overflow:hidden;
margin-top:10px;
}

.progress-fill{
height:100%;
background:#10b981;
}

.form-progress{
margin-top:20px;
display:flex;
gap:10px;
}

.form-progress input{
flex:1;
padding:12px;
border:1px solid #cbd5e1;
border-radius:10px;
}

.form-progress button{
padding:12px 20px;
border:none;
background:#2563eb;
color:white;
border-radius:10px;
cursor:pointer;
}

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

th,td{
padding:12px;
border-bottom:1px solid #e2e8f0;
text-align:left;
}

.status-belum{
color:#ef4444;
font-weight:bold;
}

.status-selesai{
color:#10b981;
font-weight:bold;
}

.btn{
padding:8px 12px;
border-radius:8px;
text-decoration:none;
color:white;
font-size:13px;
margin-right:5px;
}

.btn-selesai{
background:#10b981;
}

.btn-belum{
background:#f59e0b;
}

.btn-hapus{
background:#ef4444;
}

</style>

</head>
<body>

<div class="sidebar">
    <div class="logo">
        <h2>RPM</h2>
        <p>PIC Dashboard</p>
    </div>
    <div class="menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="tugas_event.php">Tugas Event</a>
        <a href="progress_event.php">Kelola Progress</a>
        <a href="../auth/logout.php">Logout</a>
    </div>
</div>

</div>

<div class="main">

<div class="topbar">
<h1>Kelola Progress Event</h1>
</div>

<?php while($event = mysqli_fetch_array($data)){ ?>

<?php

$total = mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM progress_detail
WHERE id_event='".$event['id_event']."'
"));

$selesai = mysqli_num_rows(mysqli_query($conn,"
SELECT *
FROM progress_detail
WHERE id_event='".$event['id_event']."'
AND status_progress='Selesai'
"));

$persen = ($total > 0)
? round(($selesai/$total)*100)
: 0;

?>

<div class="card">

<h3><?= $event['nama_event'] ?></h3>

<p>
Kategori :
<?= $event['kategori_event'] ?>
</p>

<p>
Progress :
<b><?= $persen ?>%</b>
</p>

<div class="progress-bar">

<div
class="progress-fill"
style="width:<?= $persen ?>%">
</div>

</div>

<form method="POST" class="form-progress">

<input
type="hidden"
name="id_event"
value="<?= $event['id_event'] ?>">

<input
type="text"
name="nama_progress"
placeholder="Contoh: Booking Venue"
required>

<button
type="submit"
name="tambah_progress">

Tambah

</button>

</form>

<table>

<tr>

<th>Nama Progress</th>

<th>Status</th>

<th>Aksi</th>

</tr>

<?php

$list = mysqli_query($conn,"
SELECT *
FROM progress_detail
WHERE id_event='".$event['id_event']."'
ORDER BY id_progress DESC
");

while($p = mysqli_fetch_array($list)){

?>

<tr>

<td><?= $p['nama_progress'] ?></td>

<td>

<?php

if($p['status_progress']=='Selesai'){

echo "<span class='status-selesai'>Selesai</span>";

}else{

echo "<span class='status-belum'>Belum</span>";

}

?>

</td>

<td>

<?php if($p['status_progress']=='Belum'){ ?>

<a
href="?selesai=<?= $p['id_progress'] ?>"
class="btn btn-selesai"
onclick="return confirm('Tandai tugas ini sudah selesai?')">

Selesai

</a>

<?php }else{ ?>

<span
style="
display:inline-block;
padding:8px 12px;
background:#d1fae5;
color:#065f46;
border-radius:8px;
font-size:13px;
font-weight:bold;
">

✓ Sudah Selesai

</span>

<?php } ?>

<a
href="?hapus=<?= $p['id_progress'] ?>"
class="btn btn-hapus"
onclick="return confirm('Hapus progress ini?')">

Hapus

</a>

</td>

</tr>

<?php } ?>

</table>

</div>

<?php } ?>

</div>

</body>
</html>