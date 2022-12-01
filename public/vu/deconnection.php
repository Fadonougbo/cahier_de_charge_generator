<?php 

session_start();
unset($_SESSION['auth']);
session_destroy();
header("location:{$router->generate('home')}")


 ?>