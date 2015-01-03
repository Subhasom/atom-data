<?php 

header('Access-Control-Allow-Origin: *');
if(isset($_GET['id'])) echo 'response  '.$_GET['id'];

?>