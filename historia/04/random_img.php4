<?php
// Random image generator.
// Put images in directory.

/* Seed function. */
function mkseed ( )
{
	return hexdec ( substr ( md5 ( microtime ( ) ) , -8 ) ) & 0x7fffffff;
}

$RES_d = dir ( '.' );
$ARR_files = array ( );
$INT_imgcount = 0;


while ( ( $STR_file = $RES_d->read ( ) ) != false )
{
	array_push ( $ARR_files , $STR_file );
	$INT_imgcount++;
}
	

mt_srand ( mkseed ( ) );

print $ARR_files[floor ( mt_rand ( ) * $INT_imgcount )];

 ?>
