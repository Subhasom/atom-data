<?php 
$html='<div class="ern"><div><p class="h">Updating!</p><p></p><p>We are updating some of our core services.</p><p><a onClick="window.location=window.location;">Refresh</a></p></div></div>';
$db = mysql_connect("localhost","root","") or die("<script>parent.dataLoadD(); parent.eleHtml('atom','$html');</script>"); mysql_select_db("app_atom") or die("<script>parent.dataLoadD(); parent.eleHtml('atom','$html');</script>");
?>