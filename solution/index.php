<?
$stringToDisplay = "this should also be displayed.";
?>







<?php
const WEB_ADDRESS_FOR_IP = "http://fetchip.com";

### logic and processing ###
$dateFormat = 'l \t\h\e jS \o\f F Y - H:i:s';
$dateTimeObject = new DateTime("now");

# open the current file
$currentFile = fopen(__FILE__, 'r');
$currentFileContents = htmlentities(fread($currentFile, filesize(__FILE__)));

# get your public ip address
$curlHandle = curl_init(WEB_ADDRESS_FOR_IP);
curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
$pageResponse = curl_exec($curlHandle);
$ipAddress = '';
if (!empty($pageResponse)) {
    $domHandler = new DOMDocument();
    $domHandler->loadHTML($pageResponse);

    $nodes = $domHandler->getElementsByTagName('div');

    $ipAddress = trim($nodes->item(0)->nodeValue);
}

### display formatting ###

$bodyTop = <<<'BODYTOP'
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div>
BODYTOP;

$bodyBottom = <<<"BODYBOTTOM"
    </body>
    </html>
BODYBOTTOM;

$bodyMiddle = <<<"BODYMIDDLE"
    </div>
    <p>My source code is </p>
    <textarea style="width: 800px; height: 750px">$currentFileContents</textarea><br/>
BODYMIDDLE;

### display output ###

echo $bodyTop;
echo "The current date and time is ".PHP_EOL.PHP_EOL;
echo !empty($dateFormat) ? $dateTimeObject->format($dateFormat) : '&lt;DATE FORMAT HERE&gt;';
echo "Your ip address is ".PHP_EOL.PHP_EOL;
echo !empty($ipAddress) ? $ipAddress : '&lt;IP ADDRESS&gt;';
echo $bodyMiddle;
echo '&nbsp;';
echo $stringToDisplay;
echo $bodyBottom;

