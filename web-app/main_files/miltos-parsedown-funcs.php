<?
include ("../parsedown-master/Parsedown.php");
include ("../parsedown-extra-master/ParsedownExtra.php");

function convert_markdownfile2html($input_file){

$output_file='../html-output/'.basename($input_file).'_'.md5(pathinfo($input_file, PATHINFO_DIRNAME)).'.html';

$input_string = file_get_contents($input_file);
if (CREATE_MENU_BOOL){
//the function create_navigation_menu_markdown returns array markdown menu and input string with links
list($menu_string, $input_string)=create_navigation_menu_markdown($input_string,$output_file);
}else{
$menu_string='';
}

//convert markdown to html
//to use br for each new line
$Parsedown = new ParsedownExtra();
$Parsedown->setBreaksEnabled(1);
$html_file_menu=$Parsedown->text($menu_string);
$output_string=$Parsedown->text($menu_string.$input_string); # would print <p>Hello <em>Parsedown</em>!</p>

file_put_contents($output_file, START_OF_MAIN_NAVIGATION_MENU.$output_string.END_OF_MAIN_NAVIGATION_MENU);

return $html_file_menu;
}//end func



/////////////////////functions//////////////////////////////////////

//process only html file NAVIGATION_MENU_FILE no markdown code
//get an array with the html menu of all existing favorites files
//change main navigation menu of the updated file
function update_main_navigation_menu($html_file_menu,$input_file){
global $favorites_files_r;

if (file_exists(NAVIGATION_MENU_FILE)) {
$main_navigation_contents = file_get_contents(NAVIGATION_MENU_FILE, true);
}

$menu_str_r=array();
for($i=0;$i<count($favorites_files_r);$i++){

//if recreate menu re read and remake html files
if ($html_file_menu=='' && $input_file==''){

$html_file_menu=convert_markdownfile2html($favorites_files_r[$i]);

$output_file='../html-output/'.basename($favorites_files_r[$i]).'_'.md5(pathinfo($favorites_files_r[$i], PATHINFO_DIRNAME)).'.html';

$html_file_menu=str_replace('#HEADER_ANCHOR_','./'.$output_file.'#HEADER_ANCHOR_',$html_file_menu);

$menu_str_r[$i]=$html_file_menu;
$html_file_menu='';
$input_file='';

//if update one file
}else{


	//change only updated favorite's navigation main menu or all if recreate menu is true
	
	if ($favorites_files_r[$i]==$input_file){
		
		$output_file='../html-output/'.basename($input_file).'_'.md5(pathinfo($input_file, PATHINFO_DIRNAME)).'.html';
		$html_file_menu=str_replace('#HEADER_ANCHOR_','./'.$output_file.'#HEADER_ANCHOR_',$html_file_menu);
		$menu_str_r[$i]=$html_file_menu;
	}else{
		
			$start='<p>'.$favorites_files_r[$i].'</p>';
		//the rest existing favorites unchanged
			$next_file=$i+1;			
			$last_array_index=count($favorites_files_r);
	
			if ($next_file==$last_array_index){//last element
			$end=END_OF_MAIN_NAVIGATION_MENU_TAG;			
			}else{
			$end='<p>'.$favorites_files_r[$next_file].'</p>';			
			}
		
		$menu_str_r[$i]=get_string_between($main_navigation_contents,$start, $end);

	}

}//end if update one file

}//end for each favorite

//echo $html_file_menu .'======'.$input_file;
//new menu in array
//print_r($menu_str_r);
//exit;

$new_main_navigation_menu='';
for($i=0;$i<count($menu_str_r);$i++){
$new_main_navigation_menu.='<p>'.$favorites_files_r[$i].'</p>'.$menu_str_r[$i];
}

//file_put_contents had problem with large files
file_put_contents(NAVIGATION_MENU_FILE, START_OF_MAIN_NAVIGATION_MENU.$new_main_navigation_menu.END_OF_MAIN_NAVIGATION_MENU_TAG.END_OF_MAIN_NAVIGATION_MENU);

//		echo 'html_file_menu= '.$html_file_menu.' fav='.$favorites_files_r[$i].'=='. $input_file;exit ;


/*
$string_to_write = START_OF_MAIN_NAVIGATION_MENU.$new_main_navigation_menu.END_OF_MAIN_NAVIGATION_MENU_TAG.END_OF_MAIN_NAVIGATION_MENU;

$stream = fopen('php://temp','r+');
fwrite($stream, $string_to_write);
rewind($stream);
$buffer_size = 1024;

//echo stream_get_contents($stream);
while (!feof($stream)) {
$buffer = fread($stream, $buffer_size); // Read big file/data source/etc. in small chunks
fwrite($tmp, $buffer); // Write in small chunks
}

*/


/*
// Copy big file from somewhere else
$src_filepath = 'http://example.com/all_the_things.txt'; $src = fopen($src_filepath, 'r');
$tmp_filepath = '...'; $tmp = fopen($tmp_filepath, 'w');
$buffer_size = 1024;
 
while (!feof($src)) {
$buffer = fread($src, $buffer_size); // Read big file/data source/etc. in small chunks
fwrite($tmp, $buffer); // Write in small chunks
}
 
fclose($tmp_filepath); // Clean up
fclose($src_filepath);
 
rename($tmp_filepath, '/final/path/to/file.txt'); 
*/


}//end func 




// create menu
//returns 2 values 
function create_navigation_menu_markdown($input_string){
	global $output_file,$input_file;
//convert markdown to html temporarily to create menu
$pd = new ParsedownExtra();
$html = $pd->text($input_string);

$dom = new DOMDocument();
//use @ to suppress errors delete @ for debugging
@$dom->loadHTML($html);
$k=0;
foreach ($dom->getElementsByTagName('h1') as $heading) {
			$heading_str_r[$k]=$heading->textContent;
			$k++;
}

$menu_string='';
for($i = 0; $i < count($heading_str_r); $i++) {



$anchor_str=rawurlencode($heading_str_r[$i]);
$menu_string.= '![Alt text](../inc/orange-arrow-right.png){.arrowstyle} <a name="MENU_ANCHOR_'.$anchor_str.'"></a> ['.$heading_str_r[$i].'](#HEADER_ANCHOR_'.$anchor_str.")\n\n";
$escape_string_for_pattern=preg_quote($heading_str_r[$i], '/');

//an brei sthn arxh ths grammhs mono 1 # oxi parapanw kai meta osa spaces 8elei as exei kai meta ton idio titlo kai osa space 8elei meta mexri to telos ths grammhs kane replace me link
$pattern = '/^[#]{1}([\s|\t]*'.$escape_string_for_pattern.')[\s|\t]*$/m';
//$replacement = '#[Top ![Go to top](../inc/arrow-top-top.png "Go to top") ](#MENU_ANCHOR_TOP_TOP)[Menu ![Go to menu](../inc/arrow-top.png "Go to menu") ](#MENU_ANCHOR_'.$anchor_str.') <a name="HEADER_ANCHOR_'.$anchor_str.'"></a> ${1}';


$rand_str=md5(uniqid(rand(), true));

$copy_link_str = '<form><input style="display:none" id="copylinktoanchor_'.$rand_str.'" value=\'<!-- begin of internal link code--><form target="_blank" action="index.php" method="post" name="file_selection_form" style="display: inline;"><input style="display:none" id="inputfile" name="inputfile" value="'.$input_file.'"/><input style="display:none" id="anchor" name="anchor" value="HEADER_ANCHOR_'.$anchor_str.'"/><input type="submit" name="btn" class="LoadFileButtonnewtab" value="'.$heading_str_r[$i].'"/></form><!-- end of internal link code-->\'><input type="button" name="copylink" class="LoadFileButtonnewtab" value="copy this section link" onclick="$(\'#copylinktoanchor_'.$rand_str.'\').show();$(\'#copylinktoanchor_'.$rand_str.'\').select();copySelectionText();$(\'#copylinktoanchor_'.$rand_str.'\').hide();"/></form>';



$replacement = '#[![Go to top](../inc/arrow-top-top.png "Go to top"){.arrowstyle } ](#MENU_ANCHOR_TOP_TOP) [![Go to menu](../inc/arrow-top.png "Go to menu"){.arrowstyle } ](#MENU_ANCHOR_'.$anchor_str.') <a name="HEADER_ANCHOR_'.$anchor_str.'"></a> ${1} '.$copy_link_str.' ';

$input_string = preg_replace($pattern, $replacement, $input_string);

//$input_string = str_replace('</h1>', $copy_link_str, $input_string);
//echo $input_string;exit;

//for debugging
//file_put_contents("./$i", $pattern.$input_string);
}//end for each header

//$input_string="#<a name=MENU_ANCHOR></a>NAVIGATION\n___\n".$menu_string."\n___\n".$input_string;

$menu_string="\n___\n".$menu_string."\n___\n";

return array($menu_string, $input_string);
}//end func


function get_string_between($string, $start, $end){
    $string = " ".$string;
    $ini = strpos($string,$start);
    if ($ini == 0) return "";
    $ini += strlen($start);
    $len = strpos($string,$end,$ini) - $ini;
    return substr($string,$ini,$len);
}



	
	function check_and_clean_deleted_images($output_file,$text){
		
		
		$f_r=explode('.html',$output_file);
		$output_file=$f_r[0];
		$img_list=$output_file.'.imglst';
			
		if (file_exists($img_list)){
			
			$handle = @fopen($img_list,'r');
			if ($handle) {
					$new_imglst_str='';

		    	while (($line = fgets($handle, 4096)) !== false) {

			        // process the line read.
			        //if ( strstr($text,$line) === FALSE){
			        //if (strpos($text, $line) === false) {
			        $line=trim($line);
			        if (strpos($text, $line) === false) {

			        	unlink("../html-output/".$line);			        

			        }else{
								$new_imglst_str.=$line.PHP_EOL;								
			        }
			     
			    }//end while reading imglst file

	    		if (!feof($handle)) {
  	      	echo "Error: unexpected fgets() fail\n";
			    }

			    fclose($handle);
			    unlink($img_list);

			    	if ($new_imglst_str!=''){
			    		file_put_contents($img_list,$new_imglst_str);
			    	}
			    	
			} else {
			    echo "error opening the file.";
			} 			
			
		}//end if file exists
	
	}//end func check_and_clean_deleted_images
?>
