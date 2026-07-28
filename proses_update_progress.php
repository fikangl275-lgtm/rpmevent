<?php

include '../config/koneksi.php';

# =========================
# AMBIL DATA
# =========================

$id_event = $_POST['id_event'];

$progress = $_POST['progress_event'];

# =========================
# UPDATE PROGRESS
# =========================

mysqli_query($conn,"
UPDATE event_request
SET progress_event='$progress'
WHERE id_event='$id_event'
");

# =========================
# AMBIL DATA EVENT
# =========================

$data = mysqli_query($conn,"
SELECT * FROM event_request
WHERE id_event='$id_event'
");

$d = mysqli_fetch_array($data);

$id_klien = $d['id_klien'];

# =========================
# BUAT PESAN NOTIFIKASI
# =========================

$nama_event = mysqli_real_escape_string(
$conn,
$d['nama_event']
);

$pesan = "Progress event '$nama_event' diupdate menjadi $progress";

$pesan = mysqli_real_escape_string(
$conn,
$pesan
);

# =========================
# INSERT NOTIFIKASI
# =========================

mysqli_query($conn,"
INSERT INTO notifikasi (

id_klien,
pesan,
status_baca,
created_at

)

VALUES(

'$id_klien',

'$pesan',

'belum',

NOW()

)
");

# =========================
# REDIRECT
# =========================

echo "

<script>

alert('Progress event berhasil diupdate');

window.location='tugas_event.php';

</script>

";

?>