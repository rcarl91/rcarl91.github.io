<?php

/* ********************************************
 * PHP include script for EKAK's homepage.    *
 *                                            *
 * Made by Rottigan (Per Andersson) 2004.     *
 **********************************************/



/* Logging function for visitor. Saves */
function logVisitor ( )
{
	$FILE_visitlog = 'visit.log';					// File for visit log.

	clearstatcache ( );						// Clear file stat cache.
	ignore_user_abort ( true );					// Prevent refresh while handling file.

	if ( file_exists ( $FILE_visitlog ) )
	{
		$FP_visitlog = fopen ( $FILE_visitlog , 'r+' );		// Open log file for r/w.

		while ( true )
		{
			if ( flock ( $FP_visitlog , LOCK_EX ) )
			{
#				read1strow and extract number;
#				increase visitor number;
#				fwrite number> date - host/addr -  user_agent; 

				flock ( $FP_visitorlog , LOCK_UN );
				break;
			}
		}
	}
	else
	{
		$FP_visitlog = fopen ( $FILE_visitlog , 'w+' );
		fwrite ( $FP_visitlog ,  '1' );

		$INT_visitor = 1;
	}

	fclose ( $FP_visitlog );

	return $INT_visitor;
}




/* Trivial counter for homepage. */
function visitorCounter ( )
{
	/* Store number of visitors in a variable. */
	$INT_visitors = file ( 'visitors.txt' );
	$INT_visitors = $INT_visitors[0];


	/* Open files for writing. */
	$FP_visitors = fopen ( 'visitors.txt' , 'w' );			// Open visitor counter file.
	$FP_visitorlog = fopen ( 'visitorlog.txt' , 'a+' );		// Open visitor log file.
	clearstatcache ( );
	rewind ( $FP_visitorlog );					// Place FP at beginning of file stream.

	/* Increase visitor number. */
	$INT_visitors += 1;


	/* Write data. */
	fwrite ( $FP_visitors , $INT_visitors );
	fwrite ( $FP_visitorlog , $INT_visitors.'> '.date ( 'Y-m-d H:i' ).' - '.gethostbyaddr ( $_SERVER['REMOTE_ADDR'] ).'/'.$_SERVER['REMOTE_ADDR'].' - '.$_SERVER['HTTP_REFERER'].' - '.$_SERVER['HTTP_USER_AGENT']."\n" );


	/* Close files. */
	fclose ( $FP_visitors );
	fclose ( $FP_visitorlog );

	/* Print current amount of visitors, secretly of course! */
	print '<span style="color: #fefe29;">'.$INT_visitors.'</span>';
}



/* Prints the head of the HTML document. */
function pageHeader ( $BOOL_photo )
{
	print '<html>

<head>
    <meta http-equiv="Content-type" content="text/html; charset=iso-8859-1" />
	<title>EKAK 2004</title>
</head>

<body bgcolor="#fefe29" text="#000000" link="#bb0000" vlink="#bb0000" alink="#bb0000">
<center>

<table width="640" border="0" cellspacing="0" cellpadding="4">
<tr>
	<td align="middle" valign="top">
	<font face="Helvetica, Sans-Serif" size="2">';

if ( $BOOL_photo )
	print '<img src="../bilder/anka.gif" align="absmiddle" alt="" /> <img src="../bilder/ekaktop.gif" align="absmiddle" alt="" />';
else
	print '<img src="bilder/anka.gif" align="absmiddle" alt="" /> <img src="bilder/ekaktop.gif" align="absmiddle" alt="" />';

print '<table width="628" cellspacing="0" cellpadding="6" style="border:
1px solid #000000;">
<tr bgcolor="#fdff75">
	<td align="middle" valign="middle">
	<font size="3" face="Helvetica, Sans-serif">';

if ( $BOOL_photo )
	print '<a href="../main.php4">EKAK</a> | <a href="../omekak.php4">Om EKAK</a> | <a href="../ohlhafv.php4">&Oslash;hlh&auml;fv</a> | <a  href="../filmer.php4">Filmer</a> | <a href="../forr.php4">F&ouml;rr</a> | <a href="../kontakt.php4">Kontakta</a> | <a href="../lankar.php4">L&auml;nkar</a>';
else
	print '<a href="main.php4">EKAK</a> | <a href="omekak.php4">Om EKAK</a> | <a href="ohlhafv.php4">&Oslash;hlh&auml;fv</a> | <a href="filmer.php4">Filmer</a> | <a href="forr.php4">F&ouml;rr</a> | <a href="kontakt.php4">Kontakta</a> | <a href="lankar.php4">L&auml;nkar</a>';

print '	</font>
	<td>
</tr>
</table>
';
}



/* Prints the footer of the HTML document. */
function pageFooter ( )
{
	print '	<br />
	</font>
	</td>
</tr>
</table>

<!-- DISCLAIMER -->
	<br /><br />
	

<table width="628" cellspacing="0" cellpadding="6" style="border: 1px solid #000000;">
<tr bgcolor="#fdff75">
	<td align="middle" valign="middle">
	<font size="1" face ="Helvetica, Sans-serif">
	<center>
	<a href="#" onClick="window.open( \'http://www.chalmers.se/HyperText/Standardtext.html\' , \'disclaimer\' , \'toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=1,resizable=0,copyhistory=0,width=400,height=300\' );">Chalmers disclaimer</a>
	</center>
	</font>
	</td>
</tr>
</table>
<!-- /DISCLAIMER -->	
</center>


	</td>
</tr>
</table>

</center>
</body>
</html>';
}



/* Creates a small inline table in the HTML document. */
function inlineTableHeader ( $INT_width , $INT_cellpadding )
{
	$INT_width = ( empty ( $INT_width ) ) ? 400 : $INT_width;
	
	
	print '<table width="'.$INT_width.'" cellspacing="0" cellpadding="'.$INT_cellpadding.'">
<tr>
<td align="left" valign="top">
	<font face="Helvetica, Sans-Serif" size="2">
	<br />';
}



/* Ends a small inline table in the HTML document. */
function inlineTableFooter ( )
{
	print '	</font>
	</td>
</tr>
</table>';
}
