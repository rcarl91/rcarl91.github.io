<?php

## EKAK specific
include ( '../include.inc' );


## SETTINGS */

## Do NOT REMOVE any of these lines, doing that may cause security issues.

$gallery_name = "EKAK photogalleri"; /* Sets a name to the
gallery, used in <title> */

$max_width = 100; /* thumnail maxwidth */
$max_height = 100; /* maxheight */
$screenwidth = 790; /* standardwidth of the browser */
$quality = 70; /* jpg quality of the thumbnails (to update you'll have to remove all the .thumb-files) */
$imagespacing = 20; /* space between each picture, standard at 20 */

$gd = 1; /* This is your phpGD-version. If you have phpGD 2.x installed (or later), write 2 here
                If you are using phpGD 1.x, write 1 here. */

$systemfolder = ".images"; /* Folder for the differens design files and stuff. default is ".imagesystem" */
$show_hidden_folders = false; /* If you want to show folders starting with '.' */
$show_hidden_files = false; /* show files starting with '.' */
$show_hidden_images = false; /* shows supported imagetypes starting with '.' */
$include_include = true; /* Includes the file 'include.php' if it exists, needed for using the uploadsystem. */
$click_bigimage = true; /* recomended, this makes you able to click on the full size-image tog go back to the directory listing */

$design = "default"; /* This is where you change the design of GIS, you can either change the defualt.css-file
                 in the systemfolder or make a new one. If your new filename is eg. pink.css, then the value of this
                 variable should be "pink".
                 If you think your design looks good, please send it to me at gussoh@gussoh.com and maybe I'll add it */

/*      Icons: Use any browsersupported imagetype. Standard size is 11x11px. Gif is recommended.
        do NOT use spaces in your filename, it will NOT work.
        If you don't want any icon, change the value to "" or comment it using '//' */
$foldericon = ".images/folder.gif"; /* folder icon */
$folderupicon = ".images/folderup.gif"; /* foldericon to go up one level in the tree */
$aviicon = ".images/avi.gif"; /* .avi icon */
$wmvicon = ".images/wmvicon.gif"; /* .wmv icon */
$gificon = ".images/gificon.gif"; /* .gif icon */
/* Right now you can't add your own icons (like a mpegicon or something) by yourself without changing the actual php code,
   send me a mail with your new icon and perhaps I'll add it. */

$arrow_left = ".images/arrow_left.gif"; /* Browse left arrow */
$arrow_right = ".images/arrow_right.gif"; /* Browse right arrow */

/* This sets the order of the files and folderlistings. Use "date" to sort by date or nothing ("") to sort by alphabet. */
$order = "";

/* The usertag gives you the ability to add some nice ASCII-art on top of the archive (or whatever you want). The <pre>-tagg is already added,
         so you dont have to make any <br> or anything.. This setting will probably be moved to an external file later.. */
$usertag = "EKAKs photogalleri";


/* Change the version to something like "($version) - changed by xxx" if you have made greater changes in the code.
        If it is something useful, DON'T FORGET TO SEND ME THE COPY AND EXPLAIN WHAT HAS CHANGED! */
$version = "3.13";

/* ##        END OF SETTINGS */

$PHP_SELF = $_SERVER['PHP_SELF'];

function listFiles($dirname, $order) { /* Listing files, returning an array */

        if(!$dirname)
                $dirname = "./";
        else
                $dirname .= "/";

        if ($dir = @opendir($dirname)) {
                $files[] = ".";
                $files[] = "..";
                while($file=readdir($dir)) {
                        if($file != "." && $file != "..") {
                                if($order == "date")
                                        $files[filemtime($dirname . $file) . $file] = $file;
                                else
                                        $files[] = $file;
                        }
                }
                if($order != "date") {
                        natcasesort($files);
                        reset($files);
                }
                closedir($dir);

                while(list($null, $file) = each($files))
                        $return_files[] = $file;
        }
        else {
                die("Error reading directory.<br>");
        }
        return $return_files;
}

function resizeToFile($sourcefile, $dest_x, $dest_y, $targetfile, $jpegqual, $gd) {
        /* Modified function from php.net */

        /* Get the dimensions of the source picture */
        $picsize=getimagesize("$sourcefile");

        $source_x  = $picsize[0];
        $source_y  = $picsize[1];

        touch($targetfile);

        if(strcasecmp(substr($sourcefile, -4),".jpg") == 0 || strcasecmp(substr($sourcefile, -5),".jpeg") == 0) {
                $source_id = imageCreateFromJPEG("$sourcefile");
                $imagetype = "jpeg";
        }
        else if(strcasecmp(substr($sourcefile, -4),".png") == 0) {
                $imagetype = "png";
                $source_id = imageCreateFromPNG("$sourcefile");
        }

        /* Create a new image object (not neccessarily true colour) */
        if($gd < 2.0)
                $target_id=imagecreate($dest_x, $dest_y); /* uses GD < 2.0 */
        else
                $target_id=imagecreatetruecolor($dest_x, $dest_y); /* GD > 2.0 */

        /* Resize the original picture and copy it into the just created image object. */

        if($gd < 2.0)
                $target_pic=imagecopyresized($target_id,$source_id, 0,0,0,0, $dest_x,$dest_y, $source_x,$source_y); /* GD < 2.0 */
        else
                $target_pic=imagecopyresampled($target_id,$source_id, 0,0,0,0, $dest_x,$dest_y, $source_x,$source_y); /* GD > 2.0 */

        /* Create a jpeg with the quality of "$jpegqual" out of the image object "$target_pic". This will be saved as $targetfile */

        switch($imagetype) {
                case "jpeg":
                        imagejpeg($target_id, $targetfile, $jpegqual);
                        break;
                case "png":
                        /*imagepng($target_id, $targetfile);*/ /* Needs color allocation! All imagages will be of maximum # of colors. */
                        imagejpeg($target_id, $targetfile, $jpegqual);
                        break;
                default:
                        return false;
        }

	chmod ( $targetfile , 0644 );		/* Set rights. */

        return true;
}

$direc = $_GET['direc']; /* Fetches the variables */
$bigimage = $_GET['bigimage'];


/* Original script
echo("
        <html>
        <head>
");

if(file_exists($systemfolder . "/" . $design . ".css")) {
        echo("<link rel=stylesheet href=\"" . $systemfolder . "/" . $design . ".css\">");
}
else {
        echo("<style>
                body {background-color: black; font-family: verdana, arial, helvetica; font-size: 11px; color: white}
                td {font-size: 9px;}
                img {border: 0;}
                a {color: white; border: 0; text-decoration: none}
                a:visited {color:gray}
                a:hover {color: #EEEEFF; text-decoration: underline}
                #thumbnail {border: 1; border-color: #9999BB; border-style: solid}
               </style>
         ");
}
if(!strip_tags($direc))
        $title = $gallery_name . " ";
else
        $title = strip_tags($direc); // . " - GIS";

echo("
        <title>$title</title>

        </head>
        <body>
");

*/


/* EKAK specific. */
pageHeader ( true );

inlineTableHeader ( 600 , 0 );

if($usertag)
        print '<font size="4">'.$usertag;
if($direc)
	print ' - '.strip_tags($direc);

print '</font><p />';

if($bigimage && file_exists($bigimage)) {

        /* Next and previous image function */
        $direc = dirname($bigimage);
        $direc = $direc=="."?"":$direc;
        $files = listFiles($direc, $order);
        $current = 0;
        /* Places all images in a new array ($imagelis) */
        foreach ($files as $index => $val)
        {
                if((substr(strtolower($val), -4) == ".jpg") || (substr(strtolower($val), -4) == ".png"))    /* Checks if it is a png or jpg image */
                {
                        if($val == basename($bigimage))                        /* When it finds the correct image */
                        {
                                $current = count($imagelist);           /* Put the index number in $current */
                        }
                        $imagelist[] = $val;
                }

        }
        $next = $direc . "/" . ($current+1==count($imagelist)?$imagelist[0]:$imagelist[$current+1]);      /* Fix so it can go "around" and put directory data in front */
        $prev = $direc . "/" . ($current==0?$imagelist[count($imagelist)-1]:$imagelist[$current-1]);
        $next = $next{0}=="/"?substr($next,1):$next;  /* checks if the first character is a slash, if it is, cut it */
        $prev = $prev{0}=="/"?substr($prev,1):$prev;

        $bildnr = ($current + 1) . "/" . count($imagelist);
        /* End of Next an Prev */

        $bigimagesize = getimagesize($bigimage);
        $tmpstrdirec = substr($bigimage, 0, strrpos(substr($bigimage, 0, -1), "/"));

        if($tmpstrdirec)
                $backlink = "$PHP_SELF?direc=" . urlencode($tmpstrdirec);
        else
                $backlink = $PHP_SELF;

        echo("<a href=\"$backlink\">");

        if(file_exists($folderupicon)) {
                echo("<img src=$folderupicon>");
        }
        echo(" back</a><br>");

        echo("&nbsp;<br>"); /* space between go up and next-forward arrows. Just remove this line if you want */

        echo("<a href=\"$PHP_SELF?bigimage=" . urlencode($prev) . "\">");
        if(file_exists($arrow_left))
                echo("<img src=\"$arrow_left\">");
        else
                echo("&lt;--");

        echo(" Previous</a>&nbsp;&nbsp;&nbsp;<a href=\"$PHP_SELF?bigimage=" . urlencode($next) . "\">Next ");
        if(file_exists($arrow_right))
                echo("<img src=\"$arrow_right\">");
        else
                echo("--&gt;");

        echo("</a>&nbsp;&nbsp;&nbsp;$bildnr<br>");

        echo("&nbsp;<br>"); /* space between next-forward arrows and bigimage. Just remove this line if you want */

        if($click_bigimage)
                echo("<a href=\"$backlink\">");

        echo("<img src=\"$bigimage\"></a><br>");

        if($click_bigimage)
                echo("</a>");
}
else {
        /* förhindra att man kan gå till underkataloger */
        if(substr($direc,0,1) == "/" || strstr($direc, "..") || substr($direc,-2) == ".." || substr($direc,1,1) == ":")
                $direc = "";

        $origdirec = $direc;
        $strdirec = $direc;
        if($strdirec)
                $strdirec .= "/";

        $totalsize = 0;
        $totalnum = 0;
        $totalnosupportsize = 0;
        $totalnosupportnum = 0;
                                /*        FOLDERS AND NOT SUPPORTED FILES        */

        $files = listFiles($direc, $order);
        while(list($val, $image) = each($files)) {

                $dirimage = $strdirec . $image;

                if(is_dir($dirimage)) {
                        if($image == "." || !$strdirec && $image == "..") {
                                /* omvänd if-sats :) */
                        }
                        else {
                        if($image == "..") {
                                $tmpstrdirec = substr($strdirec,0,strrpos(substr($strdirec,0,-1), "/")); /* up one level in tree */
                                $image = "";

                                        if($tmpstrdirec)
                                                echo("<a href=\"$PHP_SELF?direc=" . urlencode($tmpstrdirec) . "\">");
                                        else
                                                echo("<a href=\"$PHP_SELF\">");

                                        if(file_exists($folderupicon))
                                                echo("<img src=$folderupicon> ");

                                        echo("up</a><br>");
                          }
                          else {
                                        if(substr($image, 0, 1) != "." || $show_hidden_folders) {
                                                echo("<a href=\"$PHP_SELF?direc=" . urlencode($strdirec . $image) . "\">");

                                                if(file_exists($foldericon))
                                                                echo("<img src=$foldericon> ");
                                                echo("$image</a> <br> ");
                                        }
                          }
                    }
                }
                else if(strcasecmp(substr($image, -4),".jpg") != 0 && strcasecmp(substr($image, -5),".jpeg") != 0  && strcasecmp(substr($image, -6),".thumb") != 0 && strcasecmp($image, "index.php4") != 0 && strcasecmp(substr($image, -4),".png") != 0) {

                        if(!strcasecmp(substr($image, -4),".avi")) {
                                if(file_exists($aviicon)) echo("<img src=$aviicon> ");
                        }
                        elseif(!strcasecmp(substr($image, -4),".gif")) {
                                if(file_exists($gificon)) echo("<img src=$gificon> ");
                        }
                        elseif(!strcasecmp(substr($image, -4),".wmv")) {
                                if(file_exists($wmvicon)) echo("<img src=$wmvicon> ");
                    }

                        $totalnosupportsize += $filesize = filesize("$strdirec$image");
                        $totalnosupportnum++;

                        if(filesize("$strdirec$image") > 10000000) {
                                $filesize = round($filesize / (1024*1024));
                                $filesize .= " MB";
                        }
                        else {
                                $filesize = intval($filesize / 1024);
                                $filesize .= " KB";
                        }

                        if($include_include && $image == "include.php") { /* includes any file named include.php and does not show it in the list */

                                $path = pathinfo(__FILE__);
                                $path = $path["dirname"];
                                include($path . "/" . $strdirec . "/include.php");

                        }
                        elseif($image{0} == "." && !$show_hidden_files) {
                                /* hidden file */
                        }
                        else {
                                $filetype = substr("$image", -4);
                                switch (strtolower($filetype)) {
                                        case '.jpg':
                                        case 'jpeg':
                                        case '.gif':
                                        case '.png':
                                        case '.tif':
                                        case 'tiff':
                                        case '.bmp':
                                                echo("<a href=\"$PHP_SELF?bigimage=". urlencode($dirimage) . "\">$image $filesize</a><br>");
                                                break;
                                        default:
                                                echo("<a href=\"$dirimage\">$image $filesize</a><br>");
                                }
                        }
                }
        }

        echo("<br>");
        echo("<table><tr>"); /*                PICTURES        */

        $files = listFiles($direc, $order);
        while(list($val, $image) = each($files)) {

                $dirimage = $strdirec . $image;

                        /* Om det är en jpgbild (eller iaf slutar på .jpg/.jpeg) */
                if(($image{0} != "." || $show_hidden_images) && (strcasecmp(substr($image, -4),".jpg") == 0 || strcasecmp(substr($image, -5),".jpeg") == 0 || strcasecmp(substr($image, -4),".png") == 0)) {

                        $origimage = $dirimage;
                        $imagesize = getimagesize($dirimage);
                        if($imagesize[0] > $max_width || $imagesize[1] > $max_height) { /* bilden är för stor */

                          /* Kontrollerar om det redan finns en thumbnail, om den finns kollar den så att den har rätt storlek. */
                          /* eftersom det inte går att använda getimgsize($im)[0] måste man först lägga de i en variabel.. =( */
                                if(!file_exists($dirimage . ".thumb") || (($tempimagesize = getimagesize($dirimage . ".thumb")) && false) || !($tempimagesize[0] == $max_width || $tempimagesize[1] == $max_height) || $tempimagesize[0] > $max_width || $tempimagesize[1] > $max_height) {
                                        /* om den både är för bred och för hög så ska den skalas efter vilken som är mest över. */

                                        if($imagesize[0] > $max_width && $imagesize[1] > $max_height) {
                                                if(($imagesize[0]/$max_width) > ($imagesize[1]/$max_height)) {
                                                        resizeToFile("$dirimage", $max_width, intval($imagesize[1]/($imagesize[0]/$max_width)), $dirimage . ".thumb", $quality, $gd);
                                                }
                                                else {
                                                        resizeToFile("$dirimage", intval($imagesize[0]/($imagesize[1]/$max_height)), $max_height, $dirimage . ".thumb", $quality, $gd);
                                                }
                                                flush();
                                        }
                                        else if($imagesize[0] > $max_width) {

                                                resizeToFile("$dirimage", $max_width, intval($imagesize[1]/($imagesize[0]/$max_width)), $dirimage . ".thumb", $quality, $gd);
                                        }
                                        else {

                                                resizeToFile("$dirimage", intval($imagesize[0]/($imagesize[1]/$max_height)), $max_height, $dirimage . ".thumb", $quality, $gd);
                                        }
                                }

                                $dirimage = $dirimage . ".thumb";
                        }

                        $imagesize = getimagesize($dirimage);
                        $origimagesize = getimagesize($origimage);

                        $imagetitle = substr($image, -6) == ".thumb" ? substr($image, 0, -6) : $image;

                        $xoffset += $max_width + $imagespacing;
                        if($xoffset >= $screenwidth) {
                                echo("</tr><tr>");
                                $xoffset = $max_width + $imagespacing;
                        }

                        $totalsize += filesize($origimage);
                        $totalnumimages++;

                        echo("
                                <td width=$max_width><a href=\"$PHP_SELF?bigimage=" . urlencode($origimage) . "\">
                                <img src=\"$dirimage\" $imagesize[3] id=thumbnail><br></a></td>
                        ");

                }
        }

        if(!$totalnumimages)
                $totalnumimages = "No";

        if(!$totalnosupportnum)
                $totalnosupportnum = "No";

}

inlineTableFooter ( );

pageFooter ( );
?>
<!-- </body>
</html> -->
