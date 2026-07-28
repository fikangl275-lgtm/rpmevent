<?php

session_start();

include '../config/koneksi.php';

if($_SESSION['role'] != 'admin'){

    header("Location: ../auth/login.php");

    exit;
}

# =========================================
# TAMBAH MOM
# =========================================

if(isset($_POST['tambah_mom'])){

    $id_event = $_POST['id_event'];

    $tanggal_meeting = $_POST['tanggal_meeting'];

    $hasil_meeting = mysqli_real_escape_string(
    $conn,
    $_POST['hasil_meeting']
    );

    if(

        empty($id_event) ||

        empty($tanggal_meeting) ||

        empty($hasil_meeting)

    ){

        echo "

        <script>

        alert('Semua form wajib diisi');

        window.location='data_mom.php';

        </script>

        ";

        exit;
    }

    mysqli_query($conn,"
    INSERT INTO mom_event(

    id_event,
    tanggal_meeting,
    hasil_meeting

    )

    VALUES(

    '$id_event',

    '$tanggal_meeting',

    '$hasil_meeting'

    )
    ");

    echo "

    <script>

    alert('Minutes Of Meeting berhasil ditambahkan');

    window.location='data_mom.php';

    </script>

    ";

}

# =========================================
# UPDATE MOM
# =========================================

if(isset($_POST['update_mom'])){

    $id_mom = $_POST['id_mom'];

    $id_event = $_POST['id_event'];

    $tanggal_meeting = $_POST['tanggal_meeting'];

    $hasil_meeting = mysqli_real_escape_string(
    $conn,
    $_POST['hasil_meeting']
    );

    mysqli_query($conn,"
    UPDATE mom_event SET

    id_event='$id_event',
    tanggal_meeting='$tanggal_meeting',
    hasil_meeting='$hasil_meeting'

    WHERE id_mom='$id_mom'
    ");

    echo "

    <script>

    alert('Minutes Of Meeting berhasil diupdate');

    window.location='data_mom.php';

    </script>

    ";

}

# =========================================
# MODE EDIT
# =========================================

$edit_mode = false;

$edit_data = null;

if(isset($_GET['edit'])){

    $edit_mode = true;

    $id_edit = $_GET['edit'];

    $ambil = mysqli_query($conn,"
    SELECT * FROM mom_event
    WHERE id_mom='$id_edit'
    ");

    $edit_data = mysqli_fetch_array($ambil);

}

# =========================================
# DATA EVENT
# =========================================

$event = mysqli_query($conn,"
SELECT * FROM event_request
WHERE status='disetujui'
");

# =========================================
# DATA MOM
# =========================================

$data = mysqli_query($conn,"
SELECT

mom_event.*,
event_request.nama_event,
klien.nama

FROM mom_event

JOIN event_request
ON mom_event.id_event = event_request.id_event

JOIN klien
ON event_request.id_klien = klien.id_klien

ORDER BY id_mom DESC
");

?>

<!DOCTYPE html>
<html>
<head>

<title>Minutes Of Meeting</title>

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
    text-align:center;
    color:white;
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
    font-weight:600;
    color:#334155;
}

.input-group input,
.input-group select,
.input-group textarea{
    width:100%;
    padding:14px;
    border:1px solid #cbd5e1;
    border-radius:12px;
    outline:none;
    font-size:14px;
}

.input-group textarea{
    resize:none;
    height:180px;
    line-height:1.7;
}

.input-group input:focus,
.input-group select:focus,
.input-group textarea:focus{
    border-color:#2563eb;
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

.btn-detail{
    background:#10b981;
    color:white;
    padding:8px 14px;
    border-radius:10px;
    text-decoration:none;
    margin-right:8px;
}

.btn-edit{
    background:#f59e0b;
    color:white;
    padding:8px 14px;
    border-radius:10px;
    text-decoration:none;
}

@media(max-width:1000px){

    .container{
        grid-template-columns:1fr;
    }

}

</style>

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

        <h1>Minutes Of Meeting</h1>

    </div>

    <div class="container">

        <div class="form-box">

            <?php if($edit_mode){ ?>

            <h2>Edit Minutes Of Meeting</h2>

            <form method="POST">

                <input 
                type="hidden"
                name="id_mom"
                value="<?= $edit_data['id_mom'] ?>">

                <div class="input-group">

                    <label>Pilih Event</label>

                    <select name="id_event">

                        <?php

                        $event2 = mysqli_query($conn,"
                        SELECT * FROM event_request
                        WHERE status='disetujui'
                        ");

                        while($e = mysqli_fetch_array($event2)){

                        ?>

                        <option 
                        value="<?= $e['id_event'] ?>"

                        <?php

                        if($edit_data['id_event'] == $e['id_event']){

                            echo "selected";

                        }

                        ?>

                        >

                        <?= $e['nama_event'] ?>

                        </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="input-group">

                    <label>Tanggal Meeting</label>

                    <input 
                    type="date"
                    name="tanggal_meeting"
                    value="<?= $edit_data['tanggal_meeting'] ?>">

                </div>

                <div class="input-group">

                    <label>Hasil Meeting</label>

                    <textarea 
                    name="hasil_meeting"><?= $edit_data['hasil_meeting'] ?></textarea>

                </div>

                <button 
                type="submit"
                name="update_mom"
                class="btn-submit">

                    UPDATE MOM

                </button>

            </form>

            <?php } else { ?>

            <h2>Tambah Minutes Of Meeting</h2>

            <form method="POST">

                <div class="input-group">

                    <label>Pilih Event</label>

                    <select name="id_event">

                        <option value="">
                            -- Pilih Event --
                        </option>

                        <?php while($e = mysqli_fetch_array($event)){ ?>

                        <option value="<?= $e['id_event'] ?>">

                            <?= $e['nama_event'] ?>

                        </option>

                        <?php } ?>

                    </select>

                </div>

                <div class="input-group">

                    <label>Tanggal Meeting</label>

                    <input 
                    type="date"
                    name="tanggal_meeting">

                </div>

                <div class="input-group">

                    <label>Hasil Meeting</label>

                    <textarea 
                    name="hasil_meeting"
                    placeholder="Masukkan hasil meeting..."></textarea>

                </div>

                <button 
                type="submit"
                name="tambah_mom"
                class="btn-submit">

                    SIMPAN MOM

                </button>

            </form>

            <?php } ?>

        </div>

        <div class="table-box">

            <h2>Data Minutes Of Meeting</h2>

            <table>

                <tr>

                    <th>No</th>

                    <th>Klien</th>

                    <th>Event</th>

                    <th>Tanggal</th>

                    <th>Aksi</th>

                </tr>

                <?php

                $no = 1;

                while($d = mysqli_fetch_array($data)){

                ?>

                <tr>

                    <td><?= $no++ ?></td>

                    <td><?= $d['nama'] ?></td>

                    <td><?= $d['nama_event'] ?></td>

                    <td><?= $d['tanggal_meeting'] ?></td>

                    <td>

                        <a 
                        href="detail_mom.php?id=<?= $d['id_mom'] ?>"
                        class="btn-detail">

                            Detail

                        </a>

                        <a 
                        href="data_mom.php?edit=<?= $d['id_mom'] ?>"
                        class="btn-edit">

                            Edit

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