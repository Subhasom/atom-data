<?php 
require_once('../m3/startm3.php');

$html='<div><p><input type="button" value="Access Data" onClick="opt(1)" /></p><p><input type="button" value="Report" onClick="opt(4)" /></p>';
if($_SESSION['app_atom_signin_type']=='admin' || $_SESSION['app_atom_signin_type']=='edit') $html.='<p><input type="button" value="Contacts" onClick="opt(2)" /></p>';
if($_SESSION['app_atom_signin_type']=='admin') $html.='<p><input type="button" value="Manage Users" onClick="opt(3)" /></p><p><input type="button" value="Export Data" onClick="opt(5)" /></p>';
$html.='<p><input type="button" value="Sign Out" onClick="opt(7)" /></p></div>';
echo "<script>parent.dataLoadD(); parent.setAppTitle('Options'); parent.eleHtml('nav','$html'); </script>"; exit();
print($_SESSION['app_atom_signin_name']);
?>