<?php
session_start();
session_unset();
session_destroy();

// kembali ke login
header("Location: login.php");
exit();