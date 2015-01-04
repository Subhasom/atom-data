<?php 
require_once('../m3/m3_core.php');
include_once('../m3/m3_app.php');

if(isset($_GET['signin']) && $_POST){
	$e=$_POST['e']; $p=md5($_POST['p']);
	$q=mysql_query("SELECT * FROM `user` WHERE `email`='$e' AND `password`='$p' AND `status`='1'");
	$d=mysql_fetch_array($q);
	if(mysql_num_rows($q)){
		$_SESSION['app_atom_signin']=$e; $_SESSION['app_atom_signin_type']=$d['type']; $_SESSION['app_atom_signin_id']=$d['id']; $_SESSION['app_atom_signin_md5p']=$p; $_SESSION['app_atom_signin_branch']=$d['branch'];
		echo "<script>parent.appLoad(false);</script>"; exit();
	}else{
		echo "<script>parent.dataLoadD(); parent.document.getElementById('signin').style.display='block'; parent.eleValue('signinBtn','Try Again');</script>"; exit();
	}
}

if(!isset($_SESSION['app_atom_signin'])){
	$html='<form id="signin" target="dataViz" method="post" action="lib/signin/?auth=1&signin" onSubmit="app_signin()"><p><input type="email" name="e" placeholder="Email ID" required /></p><p><input type="password" name="p" placeholder="Password" required /></p><p>&nbsp;</p><p><input id="signinBtn" type="submit" value="Sign In" /></p></form>';
	echo "<script>parent.document.title='".$APP_DEF."'; parent.setAppTitle('".$APP_TITLE."'); parent.eleHtml('nav','$html'); parent.dataLoadD();</script>";
	exit();
}else{echo "<script>parent.document.title='".$APP_DEF."'; parent.appLoad(true);</script>"; exit();}

?>