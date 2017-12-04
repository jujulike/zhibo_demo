<?php 


$filename = "亿世网络.url";
$ua = $_SERVER["HTTP_USER_AGENT"];
$encoded_filename = urlencode($filename);
$encoded_filename = str_replace("+", "%20", $encoded_filename);
header('Content-Type: application/octet-stream');
if (preg_match("/MSIE/", $ua)) {
    header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
} else if (preg_match("/Firefox/", $ua)) {
    header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
} else {
    header('Content-Disposition: attachment; filename="' . $filename . '"');
}


//文件的类型 
header('Content-type: application/octet-stream'); 
//下载显示的名字 

echo "[InternetShortcut]\n";
echo "URL=http://hosta52212.w215-e0.ezwebtest.com/index.php/live/room/26\n";
echo "IDList=\n";
echo "[{000214A0-0000-0000-C000-000000000046}]\n";
echo "Prop3=19,2\n";
exit(); 