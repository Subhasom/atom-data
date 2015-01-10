/*system*/
var app_title='';
var ldgOpt=false;
var menu_view=true;
var app_menu=0;
var app_menu_depth=0;
var app_cs=null;
var pastSearch='';
var usrSubmitMode=false;
var usrNavMode=navigator.userAgent.toLowerCase().indexOf('.net')<0; var usrNavMode2=navigator.userAgent.toLowerCase().indexOf('firefox')<0;
var usrAppMode=false;
function setAppTitle(t){var ct=document.getElementById('app_title').innerHTML=app_title=t;}
function _ldgAct(t){if(ldgOpt==false) document.getElementById('prg').style.opacity='1'; ldgOpt=true; document.getElementById('app_title').innerHTML=app_title+'<small><center><div></div></center></small>'; if(t>0 && t<100){document.getElementById('prg').style.width=t+'%';}else{document.getElementById('prg').style.width='100%'; document.getElementById('app_title').innerHTML=app_title; document.getElementById('prg').style.opacity='0'; setTimeout(function(){document.getElementById('prg').style.width='0px'; ldgOpt=false;},1000);}}
/*dataViz*/
function dataLoad(service,arg){document.getElementById('dataViz').src='lib/'+service+'?'+arg+'&n='+usrNavMode; app_cs=service;}
function dataLoadD(t){_ldgAct(100);}
function eleHtml(id,h){if(id!='' && h!='') document.getElementById(id).innerHTML=h;}
function eleValue(id,v){document.getElementById(id).value=v;}
function appStart(){if(createApp()){setTimeout(function(){setAppTitle(''); _ldgAct(40); dataLoad('signin','auth=0&ldg');});}}
function createApp(){tryAppMode(); if((usrNavMode && usrNavMode2) || usrAppMode){document.getElementById('atom').innerHTML='<iframe id="dataViz" name="dataViz" frameborder="0" src=""></iframe><div id="top" class="fl"><div id="prg"></div><span id="app_title"></span><input type="button" class="actbtn" id="menuBtn" value="&equiv;" onClick="_actMenu()" /><div id="nav"></div></div><div id="sta"></div>'; return true;}else{document.getElementById('atom').innerHTML='<div class="ern"><div><p class="h">Sorry :(<p><p>App does not support your browser!</p><p><a href="https://www.google.com/chrome/browser/">try Google Chrome</a></p></div></div>'; document.title='Sorry :('; return false;}}
function tryAppMode(){if(window.location.href!=parent.window.location.href) usrAppMode=true;}
/*signin*/
function app_signin(){_ldgAct(60); document.getElementById('signin').style.display='none';}
function appLoad(a){_ldgAct(80); var at=document.getElementById('app_title'); if(!a) at.removeChild(at.childNodes[0]); dataLoad('home','auth=1&home');}
/*menu*/
function _menuHide(s){
	if(s){document.getElementById('nav').classList.add('hi'); document.getElementById('top').classList.add('cl'); document.getElementById('menuBtn').style.display='block';}
	else{document.getElementById('top').classList.remove('cl'); setTimeout(function(){document.getElementById('nav').classList.remove('hi');},300);}
}
function opt(i){
	if(i==1){_ldgAct(60); dataLoad('data','auth=1&s'); optCl();}
	if(i==2){alert('Sorry! This option is not available for this version.');}
	if(i==3){alert('Sorry :( You are not authorised !');}
	if(i==4){window.open('view/?report&0&v','','height=550,width=800,location=0');}
	if(i==5){window.open('view/?export&0&v','','height=550,width=800,location=0');}
	if(i==7){_ldgAct(90); dataLoad('signout','auth');}
}
function optCl(){_menuHide(true); document.getElementById('menuBtn').classList.add('sh'); menu_view=true;}
function _actMenu(){if(menu_view){_menuHide(false); menu_view=false;}else{menu_view=true; _menuHide(true);}document.getElementById('menuBtn').blur();}
/*search*/
function startSearch(){var s=document.getElementById('srch'); var hdr=document.getElementById('hdr');if(s.value!=''){var patt=/[a-zA-Z@&%#^_<>]/g;if(!patt.test(s.value) && s.value.length<35){var res="= "+(eval(s.value)); showQsr(res,true);} else showQsr('',false);}else{showQsr('',false);}}
function blurSearch(t){if(document.getElementById('srch').value=='' || t){showQsr('',false); if(pastSearch!=''){pastSearch=''; _ldgAct(60); document.getElementById('srch').blur(); dataLoad('data','auth=2&s');}} if(t){document.getElementById('srch').value=''; document.getElementById('clrBtn').blur();}}
function submitSearch(){pastSearch=document.getElementById('srch').value; _ldgAct(60); document.getElementById('srch').blur();}
function showQsr(v,s){if(s){document.getElementById('qSrchRes').innerHTML=v; document.getElementById('hdr').classList.add('sact'); document.getElementById('tda').classList.add('sact2');}else{document.getElementById('qSrchRes').innerHTML=''; document.getElementById('hdr').classList.remove('sact'); document.getElementById('tda').classList.remove('sact2');}}
function viwItem(id){window.open('view/?'+app_cs+'&'+id+'&v','','height=550,width=700,location=0');}
/*adding item*/
function addNewTgl(){var b=document.getElementById('addNewBtn'); if(b.value!='- CANCEL'){if(document.getElementById('des').innerHTML==''){b.value='...'; _ldgAct(60); dataLoad('data','auth=3&s');}else addNewTglDone();}else{b.value='+ ADD'; document.getElementById('des').classList.add('des'); b.blur();}}
function addNewTglDone(){document.getElementById('des').classList.remove('des'); window.scrollTo(0,0); document.getElementById('addNewBtn').value='- CANCEL';}
function chkAvl(ele){if(ele.options[ele.selectedIndex].text=='+ ADD NEW'){var flnd=prompt('Enter new name:'); if(flnd){_ldgAct(40); dataLoad('data','auth=4&s&type='+ele.id+'&v='+flnd); var lcc=document.createElement("option"); lcc.setAttribute('value',flnd); lcc.setAttribute('selected','true'); lcc.innerHTML=flnd; ele.appendChild(lcc);}}}
function userSubmit(){if(!usrSubmitMode){var c=confirm('Are you sure that you want to ADD this item?'); if(c){_ldgAct(80); usrSubmitMode=true;} else return false;}else return false;}