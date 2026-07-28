<?php

include '../config/koneksi.php';

$id_event = $_POST['id_event'];

$id_pic = $_POST['id_pic'];

$progress = "Persiapan";

mysqli_query($conn,"
UPDATE event_request
SET 
id_pic='$id_pic',
progress_event='$progress'
WHERE id_event='$id_event'
");

echo "

<script>

alert('PIC berhasil ditugaskan');

window.location='approval_event.php';

</script>

";

?>