<?php
$getv=array_keys($_GET); if(count($getv)<3) exit();
include_once('../lib/m3/m3_app.php');
$service=$getv[0];
$id=$getv[1]-$APP_AHL1;
$mode=$getv[2];

session_start(); if(!isset($_SESSION['app_atom_signin'])){session_destroy(); echo "<script>window.location='../';</script>"; exit();} require_once('../lib/m3/m3_database.php'); $branch=$_SESSION['app_atom_signin_branch']; date_default_timezone_set("Asia/Kolkata");

if($service=='data'){ if($id<0){echo "<title>Unavailable</title>"; exit();}
if($mode=='e'){
	if($_SESSION['app_atom_signin_type']!='admin' && $_SESSION['app_atom_signin_type']!='edit'){echo "<script>alert('Sorry :( You are not authorised !'); window.location='?data&".$getv[1]."&v';</script>"; exit();}
}

if($mode=='d'){
	if($_SESSION['app_atom_signin_type']!='admin' || $_SESSION['app_atom_signin_id']!=base64_decode($_GET['d'])-$APP_AHL2){echo "<script>alert('Sorry :( You are not authorised !'); window.location='?data&".$getv[1]."&v';</script>"; exit();} $lastuser=$_SESSION['app_atom_signin_id']; $last=time(); if(mysql_query("UPDATE `data` SET `s`='0', `lastuser`='$lastuser', `last`='$last' WHERE `id`='$id' AND `branch`='$branch';")){echo "<script>alert('Item will be DELETED after 7 days !'); window.close();</script>"; exit();};
}

if($mode=='s'){
	if($_POST){
		if($_SESSION['app_atom_signin_type']!='admin' && $_SESSION['app_atom_signin_type']!='edit' || $_SESSION['app_atom_signin_md5p']!=md5($_POST['p'])){echo "<script>alert('Sorry :( You are not authorised !'); window.location='?data&".$getv[1]."&v';</script>"; exit();}
		
		$fileno=$_POST["it_fileno"]; $doa=$_POST["it_doa"]; $macno=$_POST["it_macno"]; $vehicleno=$_POST["it_vehicleno"]; $firno=$_POST["it_firno"]; $firdate=$_POST["it_firdate"]; $firps=$_POST["it_firps"]; $court=$_POST["it_court"]; $advocate=$_POST["it_advocate"]; $investigator=$_POST["it_investigator"]; $claimant=$_POST["it_claimant"]; $casetype=$_POST["it_casetype"]; $policyno=$_POST["it_policyno"]; $hcai=$_POST["it_hcai"]; $insadd=$_POST["it_insadd"]; $note=$_POST["it_note"]; $lastuser=$_SESSION['app_atom_signin_id']; $last=time(); if(mysql_query("UPDATE `data` SET `fileno` = '$fileno', `doa` = '$doa', `macno` = '$macno', `vehicleno` = '$vehicleno', `firno` = '$firno', `firdate` = '$firdate', `firps` = '$firps', `court` = '$court', `advocate` = '$advocate', `investigator` = '$investigator', `claimant` = '$claimant', `policyno` = '$policyno', `hcai` = '$hcai', `insadd` = '$insadd', `note` = '$note', `casetype` = '$casetype', `lastuser` = '$lastuser', `last` = '$last' WHERE `id` = '$id' AND `s`='1';")){echo "<script>alert('Item is updated!'); window.location='?data&".$getv[1]."&v';</script>"; exit();}
	}
}

if($mode=='v' || $mode=='e'){
$q="SELECT * FROM `data` WHERE `id`='$id' AND `branch`='$branch'"; if($_SESSION['app_atom_signin_type']!='admin')$q.=" AND `s`='1'";
$d=mysql_fetch_array(mysql_query($q)); if($d['id']!=$id){echo "<title>Unavailable</title>"; exit();} ?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="initial-scale=1.0, user-scalable=no"><link rel="shortcut icon" href="../ui/favapp.png"><title>Data ID <?php echo $id; ?></title><link rel="stylesheet" href="../ui/view.css" /><script src="../bin/view.js"></script></head><body id="atom" onLoad="loadView();">
<div class="half fx">
	<div>
    	<h2>MAC CASE NO: <?php echo $d['macno']; if($mode=='e') echo ' <span>EDITING</span>'; if($d['s']!='1') echo ' <span class="dl">DELETED</span>';?></h2>
        <p class="p">ED<?php echo $d['ed']; ?>-LA<?php echo date('Ymd.his', $d['last']); ?>-BY<?php echo $d['lastuser']; ?><br /><?php echo md5($id); ?><br /><?php if($d['proc']!='') echo 'PR'.$d['proc'].'-RS'.$d['total']; else echo 'NOT PROCESSED'; ?><br />FIR Delay <?php if($d['firdate']!='') echo floor((strtotime($d['firdate'])-strtotime($d['doa']))/(60*60*24))." DAY(S)"; else echo "Not Available"; ?></p><p>&nbsp;</p>
        <p class="abns"><?php if($d['s']=='1') if($mode=='v'){ if($_SESSION['app_atom_signin_type']=='admin' || $_SESSION['app_atom_signin_type']=='edit') {?><input type="button" value="P 1" onClick="chMode('data',<?php echo $getv[1] ?>,'p1');" /><input type="button" value="P 2" onClick="chMode('data',<?php echo $getv[1] ?>,'p2');" /> <input type="button" value="EDIT" onClick="chMode('data',<?php echo $getv[1] ?>,'e');" /> <input type="button" value="PROC" onClick="chMode('data',<?php echo $getv[1] ?>,'p');" /> <input id="qdBtn" type="button" value="DEL" onClick="chMode('data',<?php echo $getv[1] ?>,'d');" /><?php }} ?></p>
    </div>
</div>
<div class="half fx2">
    <div>
    	<form action="?<?php echo $getv[0].'&'.$getv[1].'&s'; ?>" method="post" onSubmit="return <?php if($mode=='e') echo ' true'; else echo ' false'; ?>">
            <p>FILE NO: <input name="it_fileno" type="text" maxlength="15" value="<?php echo $d['fileno']; ?>" /></p>
            <p>DATE OF ACCIDENT: <input name="it_doa" type="text" maxlength="10" value="<?php echo $d['doa']; ?>" placeholder="DD.MM.YYYY" /></p>
            <p>MAC CASE NO: <input name="it_macno" type="text" maxlength="20" value="<?php echo $d['macno']; ?>" /></p>
            <p>VEHICLE NO: <input name="it_vehicleno" type="text" maxlength="50" value="<?php echo $d['vehicleno']; ?>" /></p>
            <p>FIR NO: <input name="it_firno" type="text" maxlength="50" value="<?php echo $d['firno']; ?>" /></p>
            <p>FIR DATE: <input name="it_firdate" type="text" maxlength="10" value="<?php echo $d['firdate']; ?>" placeholder="DD.MM.YYYY" /></p>
            <p>PS: <input name="it_firps" type="text" maxlength="20" value="<?php echo $d['firps']; ?>" /></p>
            <p>COURT: <input name="it_court" type="text" maxlength="20" value="<?php echo $d['court']; ?>" /></p>
            <p>ADVOCATE: <input name="it_advocate" type="text" maxlength="50" value="<?php echo $d['advocate']; ?>" /></p>
            <p>INVESTIGATOR: <input name="it_investigator" type="text" maxlength="50" value="<?php echo $d['investigator']; ?>" /></p>
            <p>CLAIMANT: <input name="it_claimant" type="text" maxlength="50" value="<?php echo $d['claimant']; ?>" /></p>
            <p>CASE TYPE: <input name="it_casetype" type="text" maxlength="20" value="<?php echo $d['casetype']; ?>" placeholder="injury OR death" /></p>
            <p>POLICY NO:<input name="it_policyno" type="text" maxlength="50" value=" <?php echo $d['policyno']; ?>" /></p>
            <p>INSURED: <input name="it_hcai" type="text" maxlength="50" value="<?php echo $d['hcai']; ?>" /></p>
            <p>INSURED ADDRESS: <input name="it_insadd" type="text" value="<?php echo $d['insadd']; ?>" /></p>
            <p>NOTE: <input name="it_note" type="text" maxlength="15" value="<?php echo $d['note']; ?>" /></p><p>&nbsp;</p>
            <?php if($mode=='e') { ?><p class="abns">AUTH CODE: <input type="password" name="p" placeholder="Password" required /><input type="hidden" name="auth" value="3" /></p><p>&nbsp;</p>
            <p class="abns"><input type="submit" value="SAVE" /> <input type="button" value="CANCEL EDIT" onClick="chMode('data',<?php echo $getv[1] ?>,'v');" /></p><?php } ?>
        </form>
    </div>
</div>
</body></html><?php exit();}
if($mode=='p'){
if($_SESSION['app_atom_signin_type']!='admin' && $_SESSION['app_atom_signin_type']!='edit'){echo "<title>Unavailable</title>"; exit();}

if($_POST){
	if($_SESSION['app_atom_signin_md5p']!=md5($_POST['p'])){echo "<script>alert('Sorry :( You are not authorised !'); window.location='?data&".$getv[1]."&v';</script>"; exit();}
	
	$claimno=$_POST['claimno'];
	$amount=$_POST['amount'];
	$rate=$_POST['rate'];
	$ra=$_POST['ra'];
	$total=$_POST['total'];
	$casetype=$_POST['casetype'];
	$awardtype=$_POST['awardtype'];
	$insperiod=$_POST['insperiod'];
	$proc=$_POST['proc']; if($proc!=''){$doa=explode('-',$proc); $proc=$doa[0].$doa[1].$doa[2];}
	$preproc=$_POST['preproc']; if($preproc!=''){$doa=explode('-',$preproc); $preproc=$doa[0].$doa[1].$doa[2];}
	$lastuser=$_SESSION['app_atom_signin_id']; $last=time();
	
	if(mysql_query("UPDATE `data` SET `claimno` = '$claimno', `amount` = '$amount', `rate` = '$rate', `ra` = '$ra', `total` = '$total', `awardtype` = '$awardtype', `casetype` = '$casetype', `insperiod` = '$insperiod', `preproc` = '$preproc', `proc` = '$proc', `lastuser` = '$lastuser', `last` = '$last' WHERE `id` = '$id';")) echo "<script>alert('Item is updated!');</script>";
}

$q="SELECT * FROM `data` WHERE `id`='$id' AND `branch`='$branch'"; if($_SESSION['app_atom_signin_type']!='admin') $q.=" AND `s`='1'";
$d=mysql_fetch_array(mysql_query($q)); if($d['id']!=$id){echo "<title>Unavailable</title>"; exit();}

$proc=$d['proc']; if($d['proc']!=''){$proc=substr($proc,0,4)."-".substr($proc,4,2)."-".substr($proc,6,2);}
$preproc=$d['preproc']; if($d['preproc']!=''){$preproc=substr($preproc,0,4)."-".substr($preproc,4,2)."-".substr($preproc,6,2);}
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="initial-scale=1.0, user-scalable=no"><link rel="shortcut icon" href="../ui/favapp.png">
<title>Process Sheet ID <?php echo $id; ?></title>
<link rel="stylesheet" href="../ui/view.css" /><script>mra=<?php echo $d['ra']; ?>;</script><script src="../bin/view.js"></script></head><body class="proce">
<div id="stg"><div class="b"><?php include_once('../ui/header.png'); ?></div>
<p><?php echo $APP_DEF_ADDRESS; ?></p>
<p><br /><strong><u>CLAIM PROCESSING SHEET</u></strong></p>
<form action="?<?php echo $getv[0].'&'.$getv[1].'&p'; ?>" method="post" onSubmit="return procCon()">
<p class="dda">
<strong>Our File No.</strong> <span class="upp"><?php echo $d['fileno']; ?></span><br />
<strong>MAC Case No:</strong> <span class="upp"><?php echo $d['macno']; ?></span> at <span class="upp"><?php echo $d['court']; ?></span><br />
<strong>Vehicle No:</strong> <span class="upp"><?php echo $d['vehicleno']; ?></span>, date of accident: <?php echo $d['doa']; ?><br />
<strong>Investigator:</strong> <span class="upp"><?php echo $d['investigator']; ?></span><br />
<strong>Advocate:</strong> <span class="upp"><?php echo $d['advocate']; ?></span><br />
<span class="np"><strong>Processed on:</strong> <span class="upp"><?php if($d['proc']){$proc_u=$d['proc']; $proc_u=substr($proc,8,2).".".substr($proc,5,2).".".substr($proc,0,4); echo $proc_u;}else echo '<font color="#f63">NOT YET PROCESSED</font>'; ?></span><br /></span>
<br />
<strong>Policy No:</strong> <span class="upp"><?php echo $d['policyno']; ?></span><br />
<strong>Period of Insurance:</strong> <input name="insperiod" type="text" placeholder="_______________________" value="<?php echo $d['insperiod']; ?>" class="xl" /><br />
<strong>Claim No.</strong> <input name="claimno" type="text" placeholder="_______________________" value="<?php echo $d['claimno']; ?>" class="xl" /><br />
<span class="np"><strong>Period of Interest:</strong> <input id="sdate" name="preproc" type="date" value="<?php echo $preproc; ?>" required /> &nbsp; to &nbsp; <input id="edate" name="proc" type="date" value="<?php echo $proc; ?>" required /><span id="ddval" class="np"> Required for Auto calculation</span><br /></span>
<span class="op"><strong>Period of Interest:</strong> <?php if($d['preproc']) echo $d['preproc']; else echo '_______________'; ?> to <?php if($d['proc']) echo $d['proc']; else echo '_______________'; ?><br /></span>
<strong>Amount of Award:</strong> <input id="amount" name="amount" type="text" value="<?php echo $d['amount']; ?>" class="num" onKeyUp="if(isNaN(this.value))this.value=0;" /> (Rs.)<br />
<strong>Rate of Interest:</strong> <input id="rate" name="rate" type="text" value="<?php echo $d['rate']; ?>" class="num" onKeyUp="if(isNaN(this.value))this.value=0;" /> %<br />
<strong>Amount of Interest:</strong> <input id="ra" name="ra" type="text" value="<?php echo $d['ra']; ?>" class="num" onKeyUp="this.value=mra;" /> (Rs.)<span class="np" onClick="calc()"> Calculate</span><br />
<strong>Total of Liability:</strong> <input id="total" name="total" type="text" value="<?php echo $d['total']; ?>" class="num" onKeyUp="chkto()" /> (Rs.)<span class="np" onClick="insnotpaid()"> Do not add Interest Amount</span><br />
<span class="np"><br /><strong>Award through:</strong> <select name="awardtype"><option value="" class="bln">N/A</option><option value="court"<?php if($d['awardtype']=='court')echo' selected'; ?>>Court</option><option value="lokadalat"<?php if($d['awardtype']=='lokadalat')echo' selected'; ?>>Lokadalat</option></select><br />
<strong>Case of:</strong> <select name="casetype"><option value="" class="bln">N/A</option><option value="injury"<?php if($d['casetype']=='injury')echo' selected'; ?>>Injury</option><option value="death"<?php if($d['casetype']=='death')echo' selected'; ?>>Death</option></select><br /></span>
<br />
<span class="np bl"><br />AUTH CODE: <input name="p" type="password" placeholder="Password" required /><input type="hidden" name="auth" value="3" /><br /><br /><input type="submit" value="UPDATE" /> <input type="button" value="CANCEL PROC" onClick="chMode('data',<?php echo $getv[1] ?>,'v')" /><?php if($d['proc']) echo '<br /><small>OR press CTRL+P to print.</small>'; ?><br /><br /></span>
</p>
</form>
<div contenteditable="true">
<p><strong>WHETHER SEC 64 VB COMPLIED?</strong> YES</p>
<p><strong>Advocate opinion about liability:</strong> No merit for appeal/appeal</p>
<p>Departmental observation:</p>
<p><strong>Cheque to be issued in favour of:</strong><br /><br /> __________________________ Rs. <input id="favof" type="text" value="<?php echo ceil($d['total']); ?>" disabled /> &nbsp;</p>
<p><strong>DATE OF AWARD:<br />CHEQUE TO BE ISSUED ON BEFORE: </strong></p>
</div>
<p><br />__________________________<br /><small>Recommended By</small></p>
<p><br />__________________________<br /><small>Approved By</small></p>
</div></body></html><?php exit();}
if($mode=='p1'){
if($_SESSION['app_atom_signin_type']!='admin' && $_SESSION['app_atom_signin_type']!='edit'){echo "<title>Unavailable</title>"; exit();}

$q="SELECT * FROM `data` WHERE `id`='$id'"; if($_SESSION['app_atom_signin_type']!='admin') $q.=" AND `s`='1'";
$d=mysql_fetch_array(mysql_query($q)); if($d['id']!=$id){echo "<title>Unavailable</title>"; exit();}

?>

<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="initial-scale=1.0, user-scalable=no"><link rel="shortcut icon" href="../ui/favapp.png">
<title>Print ID <?php echo $id; ?></title>
<link rel="stylesheet" href="../ui/view.css" /><script src="../bin/view.js"></script></head><body class="proce">
<div id="stg"><div class="b"><?php include_once('../ui/header.png'); ?></div>
<p><?php echo $APP_DEF_ADDRESS; ?></p>
<p>Our Ref:<span class="upp"> <?php echo $d['fileno']; ?></span><br /><span class="d">Date: <?php echo date('d M Y'); ?></span></p>
<div contenteditable="true"><p>To,<br />Mr./Mrs./Ms.<span class="upp"> <?php echo $d['hcai']; ?><br /><?php echo $d['insadd']; ?></span></p>
<p><strong>Sub: <u>MAC Case No:<span class="upp"> <?php echo $d['macno']; ?></span> at <span class="cap"><?php echo $d['court']; ?></span>, Accident to Vehicle No: <span class="upp"><?php echo $d['vehicleno']; ?></span> on <?php echo $d['doa']; ?> relates to PS Case NO: <?php if($d['firno']) echo $d['firno']; else echo "(NILL)"; ?> at <span class="upp"><?php if($d['firps']) echo $d['firps']; else echo "(NILL)"; ?></span></u></strong></p>
<p><strong><span class="cap"><?php echo $d['claimant']; ?></span> vs Yourself &amp; Ourselves.</strong></p>
<p>Dear Sir/Madam,</p>
<p>Perhaps you have received the notice from MACT for the above noted accident case allegedly involved your above noted vehicle, You are requested to send us the following information / documents at the earliest.</p>
<ul>
<ol>1) Claim from duly completed (enclosed herewith)</ol>
<ol>2) Vehicular documents like Re Book Tax Token, Policy Copy, Fitness Certificate, Permit, Load Chalan which are applicable according to vehicle.</ol>
<ol>3) Copy of Driving License of Driver at the material time of accident.</ol>
</ul>
<p>We have appointed the following advocate &amp; investigator to defend the case,you are requested to extend your co-operation  to them.</p>
<p>Name of the Advocate: <span class="upp"> <?php echo $d['advocate']; ?></span><br />Name of the Investigator: <span class="upp"> <?php echo $d['investigator']; ?> </span>.</p>
<p>As per policy condition to avail the facility of insurance policy, you have  to supply the above information / documents  as asked for and to co-operate with us in all respect.</p>
<p>Thanking You,<br />Yours faithfully</p><p>&nbsp;</p>
<p>__________________________<br />Authorised Signatory</p>
<p>&nbsp;</p>
</div></div></body></html><?php exit();}
if($mode=='p2'){
if($_SESSION['app_atom_signin_type']!='admin' && $_SESSION['app_atom_signin_type']!='edit'){echo "<title>Unavailable</title>"; exit();}

$q="SELECT * FROM `data` WHERE `id`='$id'"; if($_SESSION['app_atom_signin_type']!='admin') $q.=" AND `s`='1'";
$d=mysql_fetch_array(mysql_query($q)); if($d['id']!=$id){echo "<title>Unavailable</title>"; exit();}

?>

<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="initial-scale=1.0, user-scalable=no"><link rel="shortcut icon" href="../ui/favapp.png">
<title>Print 2 ID <?php echo $id; ?></title>
<link rel="stylesheet" href="../ui/view.css" /><script src="../bin/view.js"></script></head><body class="proce">
<div id="stg"><div class="b"><?php include_once('../ui/header.png'); ?></div>
<p><?php echo $APP_DEF_ADDRESS; ?></p>
<p>Our Ref:<span class="upp"> <?php echo $d['fileno']; ?></span><br /><span class="d">Date: <?php echo date('d M Y'); ?></span></p>
<div contenteditable="true"><p>To,<br />Mr./Mrs./Ms.<span class="upp"> <?php echo $d['investigator']; ?><br /><?php echo $d['court']; ?></span></p>
<p><strong>Sub: <u>MAC Case No:<span class="upp"> <?php echo $d['macno']; ?></span> at <span class="cap"><?php echo $d['court']; ?></span>, Accident to Vehicle No: <span class="upp"><?php echo $d['vehicleno']; ?></span> on <?php echo $d['doa']; ?> relates to PS Case NO: <?php if($d['firno']) echo $d['firno']; else echo "(NILL)"; ?> at <span class="upp"><?php if($d['firps']) echo $d['firps']; else echo "(NILL)"; ?></span></u></strong></p>
<p><strong><span class="cap"><?php echo $d['claimant']; ?></span> vs Ourselves.</strong></p>
<p>Dear Sir/Madam,</p>
<p>Please investigate the above case on its genuinity &amp; admissibility. Submit your report within 30 days to the undernoted advocate with a copy to us along with your Professional Bill &amp; following supporting Documents/Information.</p>
<ul>
<ol>1) Copy of RC Book, D/L &amp; permit</ol>
<ol>2) Confirmation of accident  from driver/owner</ol>
<ol>3) Copy of FIR/Charge Sheet/Seizure list. Conviction details &amp; sketch</ol>
<ol>4) PM Report/Disability Certificate/Injury Report as the case may be</ol>
<ol>5) Proof of age, income &amp; occupation</ol>
<ol>6) Verification of Medical Bill of locality</ol>
<ol>7) Copy of Policy/Cover note</ol>
<ol>8) Other related documents/details information</ol>
</ul>
<p>Thanking You,<br />Yours faithfully</p><p>&nbsp;</p>
<p>__________________________<br />Authorised Signatory</p>
<p><strong>CC:</strong> Advocate<span class="upp"> <?php echo $d['advocate']; ?>,</span> <span class="cap"><?php echo $d['court']; ?> Bar</span> for information. we enclose herewith summon  along with claim petition, Vakalatnama, Policy copy to enable you to appear on our behalf and take all available defences. Kindly keep us posted all development time to time.</p>
<p><strong>CC:</strong>&nbsp;</p>
<p>&nbsp;</p>
</div></div></body></html><?php exit();}exit();}
if($service=='report'){

if($mode=='u'){
	if($_POST){ if(!isset($_POST['auth'])){echo "<title>Unavailable</title>"; exit();}
	$r_d=$_POST['rd']; $r_ds=explode('-',$r_d); $r_d=$r_ds[0].$r_ds[1].$r_ds[2];
	$r_d2=$_POST['rd2']; $r_ds2=explode('-',$r_d2); $r_d2=$r_ds2[0].$r_ds2[1].$r_ds2[2];
		
	$r_entry_no=mysql_num_rows(mysql_query("SELECT `id` FROM `data` WHERE `ed` BETWEEN $r_d AND $r_d2 AND `branch`='$branch'"));
	$r_entry_no_del=mysql_num_rows(mysql_query("SELECT `id` FROM `data` WHERE `ed` BETWEEN $r_d AND $r_d2 AND `branch`='$branch' AND `s`='0'"));
	$r_proc_no=mysql_num_rows(mysql_query("SELECT `id` FROM `data` WHERE `proc`!='' AND (`proc` BETWEEN $r_d AND $r_d2) AND `branch`='$branch' AND `s`='1'"));
	
	$r_ob=$_POST['rob']; if($r_ob!='default'){$r_ob=" ORDER BY `$r_ob` DESC";}else{$r_ob=" ORDER BY `ed` DESC";}
	$r_proc_data_up=mysql_query("SELECT `id`,`fileno`,`doa`,`macno`,`investigator`,`firdate`,`firps`,`advocate`,`casetype` FROM `data` WHERE `proc`='' AND (`ed` BETWEEN $r_d AND $r_d2) AND `branch`='$branch' AND `s`='1' ORDER BY `ed` DESC");
	$r_proc_data_p=mysql_query("SELECT `id`,`fileno`,`macno`,`ra`,`total`,`advocate`,`awardtype`,`casetype` FROM `data` WHERE `proc`!='' AND (`proc` BETWEEN $r_d AND $r_d2) AND `branch`='$branch' AND `s`='1'$r_ob");
	
	$r_entry_now=mysql_num_rows(mysql_query("SELECT `id` FROM `data` WHERE `branch`='$branch' AND `s`='1'"));
	$r_proc_now=mysql_num_rows(mysql_query("SELECT `id` FROM `data` WHERE `proc`!='' AND `branch`='$branch' AND `s`='1'"));
	
	$r_paid_am=mysql_fetch_array(mysql_query("SELECT SUM(`total`) FROM `data` WHERE `proc` BETWEEN $r_d AND $r_d2 AND `branch`='$branch' AND `s`='1'"));
	$r_paid_ra=mysql_fetch_array(mysql_query("SELECT SUM(`ra`) FROM `data` WHERE `proc` BETWEEN $r_d AND $r_d2 AND `branch`='$branch' AND `s`='1'"));
	$r_injury_no=mysql_num_rows(mysql_query("SELECT `id` FROM `data` WHERE `casetype`='injury' AND `proc` BETWEEN $r_d AND $r_d2 AND `branch`='$branch' AND `s`='1'"));
	$r_death_no=mysql_num_rows(mysql_query("SELECT `id` FROM `data` WHERE `casetype`='death' AND `proc` BETWEEN $r_d AND $r_d2 AND `branch`='$branch' AND `s`='1'"));
	$r_caward_no=mysql_num_rows(mysql_query("SELECT `id` FROM `data` WHERE `awardtype`='court' AND `proc` BETWEEN $r_d AND $r_d2 AND `branch`='$branch' AND `s`='1'"));
	$r_laward_no=mysql_num_rows(mysql_query("SELECT `id` FROM `data` WHERE `awardtype`='lokadalat' AND `proc` BETWEEN $r_d AND $r_d2 AND `branch`='$branch' AND `s`='1'"));
	$r_naaward_no=mysql_num_rows(mysql_query("SELECT `id` FROM `data` WHERE `awardtype`='' AND `proc` BETWEEN $r_d AND $r_d2 AND `branch`='$branch' AND `s`='1'"));
	
	}else{echo "<title>Unavailable</title>"; exit();}
}

?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="initial-scale=1.0, user-scalable=no"><link rel="shortcut icon" href="../ui/favapp.png">
<title>Report</title><link rel="stylesheet" href="../ui/view.css" /><script src="../bin/view.js"></script></head><body id="atom" onLoad="loadView()">
<div class="half fx">
	<div>
    	<h2>REPORT<?php if($mode=='u') echo " (".substr($r_d,6,2).".".substr($r_d,4,2).".".substr($r_d,0,4)." - ".substr($r_d2,6,2).".".substr($r_d2,4,2).".".substr($r_d2,0,4).")";?></h2>
        <?php if($mode=='v'){ ?><form action="?report&0&u" method="post"><input type="hidden" name="auth" value="1" />
        <p>FROM <input type="date" name="rd" required></p><p>UPTO &nbsp;<input type="date" name="rd2" required></p><p>ORDER BY <select name="rob"><option value="default" selected>Last Entry</option><option value="awardtype">Award Type</option><option value="casetype">Case Type</option></select></p><p>&nbsp;</p>
        <p><input type="submit" value="SHOW" /></p>
        </form><?php }if($mode=='u'){ ?>
        <p>
            ENTRY: <span><?php echo $r_entry_no; ?></span></br />
            DELETED: <span><?php echo $r_entry_no_del; ?></span></br /></br />
            PROCESSED: <span><?php echo $r_proc_no; ?></span></br />
            PAID AMOUNT:<span> <?php echo number_format((float)$r_paid_am[0], 2, '.', ''); ?></span> (Rs.)</br />
            AMOUNT OF INTEREST: <span><?php echo number_format((float)$r_paid_ra[0], 2, '.', ''); ?></span> (Rs.)</br />
            INJURY: <span><?php echo $r_injury_no; ?></span></br />
            DEATH: <span><?php echo $r_death_no; ?></span></br /><br />
            COURT: <span><?php echo $r_caward_no; ?></span></br />
            LOKADALAT: <span><?php echo $r_laward_no; ?></span></br />
            INTER OFFICE: <span><?php echo $r_naaward_no; ?></span></br /><br />
            TOTAL PENDING: <span><?php echo $r_entry_now-$r_proc_now; ?></span> / <?php echo $r_entry_now; ?></br />
        </p><p>&nbsp;</p><p><input type="button" value="CLEAR" onClick="chMode('report',0,'v');" /></p><?php } ?><p>&nbsp;</p>
    </div>
</div>
<?php if($mode=='u'){ ?>
<div class="half fx2">
    <div>
    	<h2 id="re1">ENTRY<span class="np" onClick="rhide('e')"> <small>(hide)</small></span></h2>
        <table id="re2">
        <tr><th>ID *</th><th>FILE NO</th><th>CASE NO</th><th class="name">ADVOCATE</th><th class="name">INVESTIGATOR</th><th>FIR DELAY</th></tr><?php 
		$r_co=1; while($r_da=mysql_fetch_array($r_proc_data_up)){ 
        $r_colcol=''; if($r_da["casetype"]=='death'){$r_colcol=' class="dth"';} $fid=$r_da['id']+$APP_AHL1;
		if($r_da['firdate']!='') $fdelay=floor((strtotime($r_da['firdate'])-strtotime($r_da['doa']))/(60*60*24)); else $fdelay='N/A';
        echo '<tr'.$r_colcol.'><td><a href="?data&'.$fid.'&v" target="_blank">'.$r_da["id"].'</a></td><td>'.$r_da["fileno"].'</td><td>'.$r_da["macno"].'</td><td class="name">'.$r_da["advocate"].'</td><td class="name">'.$r_da["investigator"].'</td><td>'.$r_da["firps"].' '.$fdelay.'</td></tr>'; $r_co++;
        }
		if($r_co==1){echo '<tr><td colspan="8" class="nodata"><br /><br />SORRY :( NOTHING FOUND</td></tr>';} ?></table>
        <p>&nbsp;</p>
        <h2 id="rp1">PROCESSED<span class="np" onClick="rhide('p')"> <small>(hide)</small></span></h2>
        <table id="rp2">
        <tr><th>ID *</th><th>FILE NO</th><th>CASE NO</th><th class="name">ADVOCATE</th><th class="rtlm sm">INTEREST</th><th class="rtlm">TOTAL</th><th>AWARD</th></tr><?php 
		$r_co=1; while($r_da=mysql_fetch_array($r_proc_data_p)){ 
        $r_colcol=''; if($r_da["casetype"]=='death'){$r_colcol=' class="dth"';} $fid=$r_da['id']+$APP_AHL1;
        echo '<tr'.$r_colcol.'><td><a href="?data&'.$fid.'&v" target="_blank">'.$r_da["id"].'</a></td><td>'.$r_da["fileno"].'</td><td>'.$r_da["macno"].'</td><td class="name">'.$r_da["advocate"].'</td><td class="rtlm sm">'.$r_da["ra"].'</td><td class="rtlm">'.$r_da["total"].'</td><td>'.$r_da["awardtype"].'</td></tr>'; $r_co++;
        }
		if($r_co==1){echo '<tr><td colspan="8" class="nodata"><br /><br />SORRY :( NOTHING FOUND</td></tr>';} ?></table>
    </div>
</div>
<?php } ?>
</body></html><?php exit();}
if($service=='export'){
if($_SESSION['app_atom_signin_type']!='admin' && $_SESSION['app_atom_signin_type']!='edit'){echo "<title>Unavailable</title>"; exit();}

if($_POST){
if($_SESSION['app_atom_signin_md5p']!=md5($_POST['p'])){echo "<script>alert('Sorry :( You are not authorised !'); window.location='?export&".$getv[1]."&v';</script>"; exit();}

$eq="SELECT * FROM `data` WHERE `branch`='$branch' AND `s`='1'";
mysql_query('SET NAMES utf8;');
$eqq = mysql_query($eq);
$efld = mysql_num_fields($eqq);
$e_col_title=""; for($i = 0; $i < $efld; $i++){$e_col_title .= '<Cell ss:StyleID="2"><Data ss:Type="String">'.mysql_field_name($eqq, $i).'</Data></Cell>';}
$e_col_title = '<Row>'.$e_col_title.'</Row>';
$eqdata=''; while($eqr = mysql_fetch_row($eqq)){
	$line = '';
	foreach($eqr as $eqv) {
		if ((!isset($eqv)) OR ($eqv == "")) {
			$eqv = '<Cell ss:StyleID="1"><Data ss:Type="String"></Data></Cell>\t';
		} else {
			$eqv = str_replace('"', '', $eqv);
			$eqv = '<Cell ss:StyleID="1"><Data ss:Type="String">' . $eqv . '</Data></Cell>\t';
		}
		$line .= $eqv;
	}
	$eqdata .= trim("<Row>".$line."</Row>")."\n";
}

$eqdata = str_replace("\r","",$eqdata);

header("Content-Type: application/vnd.ms-excel;");
header("Content-Disposition: attachment; filename=".$APP_NAME."-Export-".date('dMY')."-".time().".xls");
header("Pragma: no-cache");
header("Expires: 0");

$xls_header = '<?xml version="1.0" encoding="utf-8"?>
<Workbook xmlns="urn:schemas-microsoft-com:office:spreadsheet" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet" xmlns:html="http://www.w3.org/TR/REC-html40">
<DocumentProperties xmlns="urn:schemas-microsoft-com:office:office">
<Author></Author>
<LastAuthor></LastAuthor>
<Company></Company>
</DocumentProperties>
<Styles>
<Style ss:ID="1">
<Alignment ss:Horizontal="Left"/>
</Style>
<Style ss:ID="2">
<Alignment ss:Horizontal="Left"/>
<Font ss:Bold="1"/>
</Style>

</Styles>
<Worksheet ss:Name="Export">
<Table>';

$xls_footer = '</Table>
<WorksheetOptions xmlns="urn:schemas-microsoft-com:office:excel">
<Selected/>
<FreezePanes/>
<FrozenNoSplit/>
<SplitHorizontal>1</SplitHorizontal>
<TopRowBottomPane>1</TopRowBottomPane>
</WorksheetOptions>
</Worksheet>
</Workbook>';

print $xls_header.$e_col_title.$eqdata.$xls_footer; exit();

}


if($_SESSION['app_atom_signin_type']!='admin'){echo "<title>Unavailable</title>"; exit();} ?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="initial-scale=1.0, user-scalable=no"><link rel="shortcut icon" href="../ui/favapp.png">
<title>Export</title><link rel="stylesheet" href="../ui/view.css" /><script src="../bin/view.js"></script></head><body id="atom" onLoad="loadView()">
<div class="half fx">
	<div>
    	<h2>EXPORT</h2>
        <form action="?export&0&v" method="post"><input type="hidden" name="auth" value="7" />
        <p class="abns">AUTH CODE: <input id="epx" type="password" name="p" placeholder="Password" required></p><p>&nbsp;</p>
        <p class="abns"><input type="submit" value="DOWNLOAD" /></p>
        </form>
    </div>
</div>
</body></html><?php exit();} ?><!--17012015.1400.v20.14-->