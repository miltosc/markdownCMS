<?php

$f_r=explode('/',$_POST["output_html_filename"]);
$f_r2=explode('.html',end($f_r));
$output_filename=$f_r2[0];
$img_list=$output_filename.'.imglst';
//$img_file = uniqid(rand(), true) . '-'.$output_filename.'.js';
$mtime=str_replace(".",'',microtime());
$mtime=str_replace(" ",'',$mtime);
$img_file =  $mtime . '-'.$output_filename.'.js';


$path = $_FILES['userImage']['tmp_name'];

$type = pathinfo($path, PATHINFO_EXTENSION);
$data = file_get_contents($path);
$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);


$img_file_parsed_dots_for_jquery=str_replace(".",'\\\\.',$img_file);

$img_file_contents='$(document).ready(function () {
$("#'.$img_file_parsed_dots_for_jquery.'").attr("src", "'.$base64.'");
})';

file_put_contents("../html-output/".$img_file, $img_file_contents);
file_put_contents("../html-output/".$img_list,$img_file.PHP_EOL,FILE_APPEND);



?>
<script src="../html-output/<?php echo $img_file;?>"  type="text/javascript"></script>
<img id="<?php echo $img_file;?>">
