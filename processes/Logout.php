<?php

session_start();

$_SESSION["user"] = null;

session_destroy();

?>

<script>
    window.location = "../Login.php";
</script>

<?php















?>