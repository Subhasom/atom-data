var app_cs=null; var usrSubmitMode=false; var usrNavMode=navigator.userAgent.toLowerCase().indexOf('.net')<0; var usrNavMode2=navigator.userAgent.toLowerCase().indexOf('firefox')<0;
function chMode(s,id,m){
	var u='?'+s+'&'+id;
	if(m=='d'){var c=prompt('Are you sure that you want to issue DELETE REQUEST for this item? It will take upto 7 days.\n\nPlease enter your 6 digit APIN:'); if(c) window.location=u+'&d='+btoa(c); else document.getElementById('qdBtn').blur();}
	else window.location=u+'&'+m;
}
function loadView(){if(usrNavMode && usrNavMode2)return true; else{document.getElementById('atom').innerHTML='<div class="ern"><div><p class="h">Sorry :(<p><p>App does not support your browser!</p><p><a href="https://www.google.com/chrome/browser/">try Google Chrome</a></p></div></div>'; document.title='Sorry :('; return false;}}
function ddlc(sd,ed){if(sd!='' && ed!='')document.getElementById('ddlci').innerHTML=daydiff(parseDate(sd), parseDate(ed))+' day(s)';else document.getElementById('ddlci').innerHTML='Not Available';}
function calc(){var ca=document.getElementById('amount').value;var ci=document.getElementById('rate').value;var sd=document.getElementById('sdate').value;var ed=document.getElementById('edate').value;var dy=daydiff(parseDate(sd), parseDate(ed));ci=(ci/365)*dy;
var ramo=parseFloat(ca*ci/100); var total=ramo+parseFloat(ca);
mra=Math.round(ramo*100)/100;
total=Math.round(total*100)/100;
if(isNaN(total)) total=0;document.getElementById('ddval').innerHTML=dy+' days';
document.getElementById('total').value=total;document.getElementById('ra').value=mra;document.getElementById('favof').value=Math.ceil(total);}
function procCon(){var c=confirm('Are you sure that you want to UPDATE this item? You can press CTRL+P to PRINT WIHOUT UPDATE !'); if(c) return true; else return false;}
function chkto(){document.getElementById('favof').value=document.getElementById('total').value;} function insnotpaid(){document.getElementById('total').value=document.getElementById('amount').value; chkto();} function parseDate(str){var mdy = str.split('-'); return new Date(mdy[0]-1, mdy[1], mdy[2]);}
function daydiff(f,s){return (s-f)/(1000*60*60*24);} function rhide(i){document.getElementById("r"+i+"1").style.display=document.getElementById("r"+i+"2").style.display='none';}