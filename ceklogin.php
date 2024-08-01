<?php

require 'function.php';

if (isset($_SESSION['login'])){
    // LOGIN
} else
    //Belum Login?
    header('location:login.php');


?>