<?php

include ( 'include.inc' );

pageHeader ( false );

inlineTableHeader ( 400 , 0 );


/********************************
 * Uppdateringar gjorda:
 * 16/3 - bytte till PHP, lade upp figurinfo, räknaren började på noll.
 * 29/3 - lade till länkar.
 * 1/5 - Slängde upp häfvresultat.
 */
 ?>

<!-- SENAST UPPDATERAD -->
	<center>
	<font size="1">Senast uppdaterad 2004-05-01</font>
	</center>
<!-- /SENAST UPPDATERAD -->

<?php

inlineTableFooter ( );

 ?>
 
<br /><br />

<table border="0" cellspacing="0" cellpadding="4">
<tr>
	<td align="left" valign="top">
	<font face="Helvetica, Sans-Serif" size="2">
	<a href="ankan.php4"><img border="1" src="bilder/ankan_intro01.jpg" alt="" /></a ><br />
	&#160; <a href="ankan.php4"><b>Kalle Anka</b></a><br />
	&#160; Ordf&ouml;rande<br />
	</font>
	</td>

	<td align="left" valign="top">
	<font face="Helvetica, Sans-Serif" size="2">
	<a href="rottigan.php4"><img border="1" src="bilder/rottigan_intro03.jpg" alt="" /></a><br />
	&#160; <a href="rottigan.php4"><b>Rottigan</b></a><br />
	&#160; Kass&ouml;r<br />
	</font>
	</td>
	
	<td align="left" valign="top">
	<font face="Helvetica, Sans-Serif" size="2">
	<a href="squeeks.php4"><img border="1" src="bilder/squeeks_intro00.jpg" alt="" /></a><br />
	&#160; <a href="squeeks.php4"><b>Squeeks</b></a><br
/>
	&#160; Korrespondenschef<br />
	</font>	
	</td>
</tr>
</table>
<br /><br />
<table border="0" cellspacing="0" cellpadding="4">
<tr>
	<td align="left" valign="top">
	<font face="Helvetica, Sans-Serif" size="2">
	<a href="john.php4"><img border="1" src="bilder/john_intro00.jpg" alt="" /></a><br />
	&#160; <a href="john.php4"><b>Hederlige John</b></a><br />
	&#160; &Oslash;hlchef<br />
	</font>
	</td>

	<td align="left" valign="top">
	<font face="Helvetica, Sans-Serif" size="2">
	<a href="elliot.php4"><img border="1" src="bilder/elliot_intro00.jpg" alt="" /></a><br />
	&#160; <a href="elliot.php4"><b>Elliot</b></a><br />
	&#160; Filmchef<br />

 <?php
 
visitorCounter ( );

pageFooter ( );
 ?>
