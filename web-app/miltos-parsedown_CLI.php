<?
if ($argv[1]==''){
echo '
usage: php /mnt/htdocs_server/markdown-github/miltos-parsedown.php [input file] [output file]
ex.
php /mnt/htdocs_server/markdown-github/miltos-parsedown.php /mnt/useful/migration/miltos-migration-notes.txt /mnt/useful/migration/miltos-migration-notes_markdown.html

';

}else{
include (dirname(__FILE__)."/parsedown-master/Parsedown.php");
$Parsedown = new Parsedown();
$from_file=$argv[1];
$to_file=$argv[2];
$input_string = file_get_contents($from_file);

//echo $Parsedown->text('Hello _Parsedown_!'); # would print <p>Hello <em>Parsedown</em>!</p>
$output_string=$Parsedown->text($input_string); # would print <p>Hello <em>Parsedown</em>!</p>

file_put_contents($to_file, $output_string);
}
?>