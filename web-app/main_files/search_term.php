<?
include ('config.php');

echo START_OF_MAIN_NAVIGATION_MENU;
?>

<style>
body    {
/*
overflow-x:scroll;
overflow-y:scroll;
*/
overflow:scroll;
}
</style>

<? if ($_POST["search_term"]!=''){ //////////////////////////search all mini site

    $results = php_grep($_POST["search_term"], '../html-output');
    $results = str_replace(START_OF_MAIN_NAVIGATION_MENU,'',$results);
    echo "$results";

?>

<script src="../inc/jquery.highlight-5.closure.js" type="text/javascript"></script>
<script>
$('#output').highlight('<?echo $_POST["search_term"];?>');
</script>

<?
}//end if search submited

/*
   +--------------------------------------------------------------+
   |                         PHP-GREP.php                         |
   +--------------------------------------------------------------+
   |	By Jan Zumwalt - Net-Wrench.com - 2012-11-17                |
   |  Function concept by cafewebmaster.com                       |
   |  1) added input form                                         |
   |  2) file line numbers                                        |
   |  3) matched line output                                      |
   |  4) Stats count                                              |
   |	                                                            |
   |  notes: I have not found an easy way to highlite the match   |
   |         text in the result. If someone finds a simple way,   |
   |         please send code from the message form located at    |
   |         net-wrench.com/email      Thank you - Jan Zumwalt    |
   +--------------------------------------------------------------+   
*/


	function php_grep($search, $path){            // entry point for recursive search
		global $total;                              // make stat vars available outside function
    global $occurance;
    global $filesearched;
    global $dirsearched;
    global $favorites_files_r_txt;

		$fp = opendir($path);
		$H1_num=0;
		while($f = readdir($fp)){
			if( preg_match("#^\.+$#", $f) ) continue; // ignore symbolic links
        if ($f == "." || $f == ".." || strtolower(substr($f, strrpos($f, '.') + 1)) != 'html') continue; // ignore other than html files
			
			$file_full_path = $path.SLASH.$f;         // insert win/unix slash in proper direction
      $filesearched++;                          // assume path is a file for stat count
      
			if(is_dir($file_full_path)) {             // if path is directory, search recursively
				$ret .= php_grep($search, $file_full_path);
        $filesearched--;                        // path is directory, so subtract from file count
        $dirsearched++;                         // inc directory count
        
			} else if( stristr(strip_tags(file_get_contents($file_full_path)), $search) ) { // quick check for match in entire file 
        // match found in file so process each line of file
        $fh = fopen("$file_full_path", "r");
        $linect = 0;
       	$search_term_found='no';
       	$tmp_section='';
        while (!feof($fh)) {                    // search each line of file

        	$line = fgets($fh);	        	
          $line_stripped = trim(strip_tags($line));					

//in case you search for markdown avoid my project title<title>markdownCMS</title>
if ($line_stripped!='' && !stristr($line,'<title>markdownCMS</title>') ){
          if(preg_match($pattern,$line_stripped)) {      // if match found in this line show line number and line text content
            $search_term_found='yes';
            
        		//echo 'aaaaaaaaaaa'. $search_term_found.$tmp_section;
            //$ret .= "<span style='color:acf;'><a target='_blank' href=\"$file_full_path\">$file_full_path</a></span> <span style='color:#ffc;'>[$linect]</span> <i><xmp>$line</xmp></i>\n";            
            $occurance++;
            //echo 'aaaaaa'.$line.'bbbbbbbbb';
          }
}


/* first i create blocks between h1 and if search string found in block i append it to results variable $ret */
$H1_num++;
        		if (stristr($line,'<h1>')  ) {								

        			
        			if ($search_term_found=='yes'){ //term found
        				
$file_full_path_encoded_r=explode('_',$file_full_path);
end($file_full_path_encoded_r);
$file_full_path_plain = prev($file_full_path_encoded_r);

$file_fname_plain_r=explode('/',$file_full_path_plain);
$file_fname_plain=end($file_fname_plain_r);
foreach ($favorites_files_r_txt["fav_files"] as $value) {
	
		if (stristr($value,$file_fname_plain)){ 

			if ($file_full_path=='../html-output/'.basename($value).'_'.md5(pathinfo($value, PATHINFO_DIRNAME)).'.html'){			
				$file_to_edit=$value;
			}
		}
}


// <a href="#MENU_ANCHOR_parked%20domains%20fere%20kinhsh">
//<a href="#MENU_ANCHOR_TOP_TOP">

// $tmp_section keeps the <h1> block that contains the searched word
// get all anchors hrefs name= from the block 

$hrefs = array();
$dom = new DOMDocument();
libxml_use_internal_errors(true);
$dom->loadHTML($tmp_section);
libxml_clear_errors();

$tags = $dom->getElementsByTagName('a');
foreach ($tags as $tag) {
       $hrefs[] =  $tag->getAttribute('name');
}
//the third href is the anchor pointing to the block to use it for the edit here button
//print_r($hrefs);
//echo $hrefs[2];


            $ret .= "<br><hr><h2>Found at: $file_to_edit <br> Preview \"html only\" in new Tab : <a target='_blank' href=\"$file_full_path#".$hrefs[2]."\"><span style='color:acf;'>$file_full_path</span></a> <span style='color:#ffc;'>[$linect]</span>\n";
            
$ret .= '<br><form action="index.php" method="post" name="file_selection_form" style="display: inline;"><input style="display:none" id="inputfile" name="inputfile" value="'.$file_to_edit.'"/><input style="display:none" id="anchor" name="anchor" value="'.$hrefs[2].'"/><input style="display:none" id="search_term" name="search_term" value="'.$_POST["search_term"].'"/><br><input type="submit" name="btn" class="LoadFileButtonnewtab" value="Go here with editor in new Tab" onclick="this.form.target=\'_blank\';return true;" /><script>$( ".open-in-new-tab" ).submit();</script></form></h2><br>';



            $ret .= $tmp_section;
								$tmp_section=$line;
	        			$search_term_found='no';	        			
	        		}else{//if term not found	        			
	        			$tmp_section=$line;	        			
	        		}
	        		
	        		$tmp_section=$line;
	        		
        		}else{//while no <h1> found        			
        			$tmp_section.=$line;
							

        		}

          $pattern = "/$search/";
          
/*
          if(preg_match($pattern,$line_stripped)) {      // if match found in this line show line number and line text content
            $search_term_found='yes';
            
        		//echo 'aaaaaaaaaaa'. $search_term_found.$tmp_section;
            //$ret .= "<span style='color:acf;'><a target='_blank' href=\"$file_full_path\">$file_full_path</a></span> <span style='color:#ffc;'>[$linect]</span> <i><xmp>$line</xmp></i>\n";            
            $occurance++;
          }
*/        
          $linect++;
        }//end while each line
        			
        						

        
        fclose($fh);        
				$total++;
			}//end search  for match in entire file
		}//end for each favorite file
		closedir($fp); 
		
		
		

									        $ret = str_replace('</h1>','</h1><div id=show_hide>',$ret,$replaces_count);
									        
									        for ($replaces_i = 1; $replaces_i <= $replaces_count; $replaces_i++) {
									        	$ret = preg_replace('/<div id=show_hide>/', '<script>$(document).ready(function () {$("#show_hide_'.$replaces_i.'").hide();$(document).click(function(){$("#show_hide_'.$replaces_i.'").toggle();});});</script><div class="output" id=show_hide_'.$replaces_i.'>', $ret, 1);
									        	
   												//	$ret=str_replace('<div id=show_hide','<script>$(document).click(function(){$("show_hide_'.$replaces_i.'").toggle();});</script><div id=show_hide_'.$replaces_i.'>',$ret);
									        }
													$ret = str_replace('<hr>','</div><hr>',$ret);


/*													
									        $ret = str_replace('</h1>','</h1><div id=show_hide>',$ret,$replaces_count);
									        
									        for ($replaces_i = 1; $replaces_i <= $replaces_count; $replaces_i++) {
									        	$ret = preg_replace('/<div id=show_hide>/', '<script>$(document).ready(function () {$("#show_hide_'.$replaces_i.'").hide();$(document).click(function(){$("#show_hide_'.$replaces_i.'").toggle();});});</script><div id=show_hide_'.$replaces_i.'>', $ret, 1);
									        	
   												//	$ret=str_replace('<div id=show_hide','<script>$(document).click(function(){$("show_hide_'.$replaces_i.'").toggle();});</script><div id=show_hide_'.$replaces_i.'>',$ret);
									        }
													$ret = str_replace('<hr>','</div><hr>',$ret);

*/		
		    
		return $ret;
	}//end function

//i do it so instead of initialising it less because i might need the data in future
$total=$total-1;
$occurance=$occurance-1;
echo "<hr><span style='color: #ff8c00;'>
          Files searched = $filesearched<br>   
          Files matched  = $total<br>
          Occurences     = $occurance<br>
        </span>";

echo END_OF_MAIN_NAVIGATION_MENU;
?>