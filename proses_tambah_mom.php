<?php

include '../config/koneksi.php';

# =========================
# AMBIL DATA FORM
# =========================

$id_event = $_POST['id_event'];

$tanggal_meeting = $_POST['tanggal_meeting'];

$hasil_meeting = mysqli_real_escape_string(
$conn,
$_POST['hasil_meeting']
);

# =========================
# VALIDASI
# =========================

if(

    empty($id_event) ||

    empty($tanggal_meeting) ||

    empty($hasil_meeting)

){

    echo "

    <script>

    alert('Semua form wajib diisi');

    window.location='tambah_mom.php';

    </script>

    ";

    exit;
}

# =========================
# INSERT DATABASE
# =========================

mysqli_query($conn,"
INSERT INTO mom_event (

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

# =========================
# REDIRECT
# =========================

echo "

<script>

alert('Minutes Of Meeting berhasil disimpan');

window.location='data_mom.php';

</script>

";

?>