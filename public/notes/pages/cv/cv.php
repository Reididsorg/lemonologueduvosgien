<?php
$filePath = 'C:/wamp64/www/lemonologueduvosgien/documents/cv_bruno_grosdidier.pdf';
if (!file_exists($filePath)) {
		echo "Le fichier $filePath n\'existe pas";
		die();
}
$filename="cv_bruno_grosdidier.pdf";
header('Content-type:application/pdf');
header('Content-disposition: inline; filename="'.$filename.'"');
header('content-Transfer-Encoding:binary');
header('Accept-Ranges:bytes');
readfile($filePath);
?>