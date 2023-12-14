<?php

require 'function.php';

if(isset($_SESSION['login'])){
    
}else{
    header('location:index.php');
}

?>