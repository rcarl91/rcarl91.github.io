////NO NEED TO EDIT BELOW THIS LINE////////////
marqueespeed=(document.all)? marqueespeed : Math.max(1, marqueespeed-1) //slow speed down by 1 for NS
var copyspeed=marqueespeed
var pausespeed=(pauseit==0)? copyspeed: 0
var iedom=document.all||document.getElementById
if (iedom)
document.write('<span id="temp" style="font-family:Verdana, Arial, Helvetica, Sans; font-size:13px; visibility:hidden;position:absolute;top:-100;left:-5000">'+marqueecontent+'</span>')
var actualwidth=''
var cross_marquee, ns_marquee

function populate(){
if (iedom){
cross_marquee=document.getElementById? document.getElementById("iemarquee") : document.all.iemarquee
cross_marquee.style.left=marqueewidth+8
cross_marquee.innerHTML=marqueecontent
actualwidth=document.all? cross_marquee.offsetWidth : document.getElementById("temp").offsetWidth
}
else if (document.layers){
ns_marquee=document.ns_marquee.document.ns_marquee2
ns_marquee.left=marqueewidth+8
ns_marquee.document.write(marqueecontent)
ns_marquee.document.close()
actualwidth=ns_marquee.document.width
}
lefttime=setInterval("scrollmarquee()",20)
}
window.onload=populate

function scrollmarquee(){
if (iedom){
if (parseInt(cross_marquee.style.left)>(actualwidth*(-1)+8))
cross_marquee.style.left=parseInt(cross_marquee.style.left)-copyspeed
else
cross_marquee.style.left=marqueewidth+8

}
else if (document.layers){
if (ns_marquee.left>(actualwidth*(-1)+8))
ns_marquee.left-=copyspeed
else
ns_marquee.left=marqueewidth+8
}
}

if (iedom||document.layers){
with (document){
document.write('<table border="0" cellspacing="0" cellpadding="0"><td>')
if (iedom){
write('<div style="position:relative;width:'+marqueewidth+';height:'+marqueeheight+';overflow:hidden; border:solid 1px #000000;">')
write('<div style="position:absolute;width:'+marqueewidth+';height:'+marqueeheight+';background-color:'+marqueebgcolor+'" onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=marqueespeed">')
write('<div id="iemarquee" style="position:absolute;left:0;top:0"></div>')
write('</div></div>')
}
else if (document.layers){
write('<ilayer border="1" width='+marqueewidth+' height='+marqueeheight+' name="ns_marquee" bgColor='+marqueebgcolor+'>')
write('<layer name="ns_marquee2" left=0 top=0 onMouseover="copyspeed=pausespeed" onMouseout="copyspeed=marqueespeed"></layer>')
write('</ilayer>')
}
document.write('</td></table>')
}
}