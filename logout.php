<?php
include ("include.inc.php");

session_start();

$query = "UPDATE sesiones SET fin=NOW() WHERE hash='$ID'";
$dbq = $conn->execute($query);

Header("Location: index.php");

?>
