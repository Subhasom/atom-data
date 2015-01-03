<?php 
if(!isset($_REQUEST['s'])){exit();}
require_once('../m3/startm3.php');
include_once('../m3/m3_app.php');
$auth=$_REQUEST['auth']; $s=$_REQUEST['s']; $branch=$_SESSION['app_atom_signin_branch']; $ext_script="";

/*add*/
if(isset($_REQUEST['add'])){
	/*$fileno=$_POST["it_fileno"];
	$doa=$_POST["it_doa"];
	$macno=$_POST["it_macno"];
	$vehicleno=$_POST["it_vehicleno"];
	$firno=$_POST["it_firno"];
	$firdate=$_POST["it_firdate"];
	$firps=$_POST["it_firps"];
	$court=$_POST["it_court"];
	$advocate=$_POST["it_advocate"];
	$investigator=$_POST["it_investigator"];
	$claimant=$_POST["it_claimant"];
	$policyno=$_POST["it_policyno"];
	$hcai=$_POST["it_hcai"];
	$insadd=$_POST["it_insadd"];
	$note=$_POST["it_note"];
	$casetype=$_POST["it_casetype"];
	
	$doa=explode('-',$doa);
	$doa=$doa[2].'.'.$doa[1].'.'.$doa[0];
	
	$firdate=explode('-',$firdate);
	$firdate=$firdate[2].'.'.$firdate[1].'.'.$firdate[0];
	
	$lastuser=$_SESSION['app_atom_signin_id'];
	$last=time();
	date_default_timezone_set("Asia/Kolkata"); $ed=date('Ymd');
	
	if(mysql_query("INSERT INTO `data` (`id`, `fileno`, `ed`, `doa`, `macno`, `vehicleno`, `firno`, `firdate`, `firps`, `court`, `advocate`, `investigator`, `claimant`, `policyno`, `hcai`, `insadd`, `note`, `casetype`, `branch`, `lastuser`, `last`, `s`) VALUES (NULL, '$fileno', '$ed', '$doa', '$macno', '$vehicleno', '$firno', '$firdate', '$firps', '$court', '$advocate', '$investigator', '$claimant', '$policyno', '$hcai', '$insadd', '$note', '$casetype', '$branch', '$lastuser', '$last', '1');")){echo "<script>alert('Item is added by ".$_SESSION['app_atom_signin']." !');</script>";}
	*/
}

/*query*/
$c=1; $q="select * from `data` WHERE 1";

if($s!=''){/*search mode*/
$ss=explode("=",$s);
if($ss[0]=="id" || $ss[0]=="ID") $q.=" AND `id`='$ss[1]'"; /*smart search*/
else $q.=" AND `fileno` LIKE '%$s%' OR `doa` LIKE '%$s%' OR `macno` LIKE '%$s%' OR `vehicleno` LIKE '%$s%' OR `court` LIKE '%$s%' OR `advocate` LIKE '%$s%' OR `policyno` LIKE '%$s%' OR `note` LIKE '%$s%'"; /*normal search*/
}
$q.=" AND `branch`='$branch'";
if($_SESSION['app_atom_signin_type']!='admin') $q.=" AND `s`='1'";

$q.=" ORDER BY `id` DESC";
if($s=='') $q.=" LIMIT 0,25"; else  $q.=" LIMIT 0,100";/*simple mode*/

$html="";

$resply=mysql_query($q); while($d=mysql_fetch_array($resply)){
	$fid=$d['id']+$APP_AHL1;
	$html.='<tr id="i'.$fid.'" class="d'; if($c%2==0) $html.=" evn"; if($d['proc']!='') $html.=" prd"; if($d['s']=='0') $html.=" del"; 
	$html.='"><td onClick="viwItem('.$fid.')">'.$d['id'].'</td><td>'.$d['fileno'].'</td><td>'.$d['doa'].'</td><td>'.$d['macno'].'</td><td>'.$d['vehicleno'].'</td><td>'.$d['court'].'</td><td>'.$d['advocate'].'</td><td>'.$d['investigator'].'</td><td>'.$d['claimant'].'</td><td>'.$d['policyno'].'</td><td>'.$d['hcai'].'</td><td>'.$d['note'].'</td></tr>';
	$c++;
}
/*entry form*/
$html_enf='';

if($c==1){$html='<tr><td class="nodata" colspan="12">SORRY :( NOTHING FOUND</td></tr>';}

if($auth==1){/*first time auto load*/	
	$html='<div class="hdr" id="hdr"><center><div class="sm"><form id="userSearch" target="dataViz" action="lib/data/?auth=1" onSubmit="submitSearch()"><input type="search" name="s" id="srch" placeholder="Search" autocomplete="off" onKeyUp="startSearch()" onMouseOut="blurSearch(false)" required /><input type="hidden" name="auth" value="2" /></form><p id="qSrchRes"></p><p id="qAct"><input id="addNewBtn" type="button" value="+ ADD" onClick="addNewTgl()" /><input id="clrBtn" type="button" value="CLEAR" onClick="blurSearch(true);" /></p></div></center></div><div class="tabData" id="tda"><div id="des" class="des"></div><table id="tdar" cellpadding="0" cellspacing="0"><tr class="tdh"><td>ID *</td><td>FILE NO</td><td>DATE</td><td>CASE NO</td><td>VEHICLE NO</td><td>COURT</td><td>ADVOCATE</td><td>INVESTIGATOR</td><td>CLAIMANT</td><td>POLICY NO</td><td>INSURED</td><td>NOTE</td></tr>'.$html.'</table></div>';
	$r_area="sta";
}
if($auth==2){/*user search, replace table data only*/
	$html='<tr class="tdh"><td>ID *</td><td>FILE NO</td><td>DATE</td><td>CASE NO</td><td>VEHICLE NO</td><td>COURT</td><td>ADVOCATE</td><td>INVESTIGATOR</td><td>CLAIMANT</td><td>POLICY NO</td><td>INSURED</td><td>NOTE</td></tr>'.$html.'';
	$r_area="tdar";
}
if($auth==3){/*load entry form*/
	$h1=""; $q1="SELECT `type`, `value_1` FROM `terms` WHERE `type`='court' ORDER BY `value_1` ASC";
	$r1=mysql_query($q1); while($d1=mysql_fetch_array($r1)){
		$h1.='<option value="'.$d1['value_1'].'" >'.$d1['value_1'].'</option>';
	}
	$h2=""; $q2="SELECT `type`, `value_1` FROM `terms` WHERE `type`='advocate' ORDER BY `value_1` ASC";
	$r2=mysql_query($q2); while($d2=mysql_fetch_array($r2)){
		$h2.='<option value="'.$d2['value_1'].'" >'.$d2['value_1'].'</option>';
	}
	$h3=""; $q3="SELECT `type`, `value_1` FROM `terms` WHERE `type`='investigator' ORDER BY `value_1` ASC";
	$r3=mysql_query($q3); while($d3=mysql_fetch_array($r3)){
		$h3.='<option value="'.$d3['value_1'].'" >'.$d3['value_1'].'</option>';
	}
	$html='<form id="addNewEntry" target="dataViz" action="lib/data/?auth=1" method="post" onSubmit="userSubmit()"><input type="hidden" name="auth" value="1" /><input type="hidden" name="add" value="'.time().'" /><input type="hidden" name="s" value="" /><div class="half"><div class="p"><h2>BASIC DETAILS</h2><p><input type="text" placeholder="FILE NO" id="it_fileno" name="it_fileno" maxlength="15" required /></p><p><input type="date" placeholder="DATE" name="it_doa" required /></p><p><input type="text" placeholder="MAC CASE NO" name="it_macno" maxlength="20" required /></p><p><input type="text" placeholder="VEHICLE NO" name="it_vehicleno" maxlength="50" required /></p><p><input type="text" placeholder="POLICY NO" name="it_policyno" maxlength="50" /></p><p><input type="text" placeholder="INSURED" name="it_hcai" maxlength="50" required /></p><p><input type="text" placeholder="INSURED ADDRESS" name="it_insadd" /></p></div></div><div class="half"><div class="p"><h2>INVESTIGATION DETAILS</h2><p><input type="text" placeholder="FIR NO" name="it_firno" maxlength="50" /></p><p><input type="date" placeholder="FIR DATE" name="it_firdate" /></p><p><input type="text" placeholder="PS" name="it_firps" maxlength="50" /></p><p><select id="it_court" name="it_court" onChange="chkAvl(this);"><option class="_d" value="">COURT</option>'.$h1.'<option class="_n" value="">+ ADD NEW</option></select></p><p><select id="it_advocate" name="it_advocate" onChange="chkAvl(this);"><option class="_d" value="">ADVOCATE</option>'.$h2.'<option class="_n" value="">+ ADD NEW</option></select></p><p><select id="it_investigator" name="it_investigator" onChange="chkAvl(this);"><option class="_d" value="">INVESTIGATOR</option>'.$h3.'<option class="_n" value="">+ ADD NEW</option></select></p><p><input type="text" placeholder="CLAIMANT" name="it_claimant" maxlength="50" /></p><p><select name="it_casetype"><option selected class="_d" value="0">CASE TYPE</option><option value="injury">INJURY</option><option value="death">DEATH</option></select></p><p><input type="text" placeholder="NOTE" name="it_note" /></p><p>&nbsp;</p><p><input type="submit" value="SAVE" /></p></div></div></form>';
	$r_area="des";
	$ext_script=" parent.addNewTglDone();";
}
if($auth==4){/*add new quick data*/
	$typl=ltrim($_GET['type'],'it_');
	$vvl=strtoupper($_GET['v']);
	mysql_query("INSERT INTO `terms` (`id`, `type`, `value_1`, `s`) VALUES (NULL, '$typl', '$vvl', '1');");
	
	$r_area='';
	$html_mod='';
}

$html_mod = stripslashes(preg_replace('/\'/', '', stripslashes($html)));


echo "<script>parent.dataLoadD(); parent.setAppTitle('Data'); parent.eleHtml('".$r_area."','".$html_mod."');".$ext_script."</script>";

exit();

?>