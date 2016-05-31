<? 
$cursor_position_file = '../tmp_backup_files/'.basename($input_file).'.cur';

$textarea_html_scrollTop_str=$textarea_cursor_position_r[3];


if (isset($_POST["text"])){

$editor_sel_start_str=$_POST["editor_sel_start"]-0;
$editor_sel_end_str=$_POST["editor_sel_end"]+3;
$editor_html_scrollTop_str=$_POST["editor_html_scrollTop"];
$editor_scrollTop_str=$_POST["editor_scrollTop"];

$textarea_sel_start_str=$_POST["textarea_sel_start"]-0;
$textarea_sel_end_str=$_POST["textarea_sel_end"]+3;
$textarea_html_scrollTop_str=$_POST["textarea_html_scrollTop"];
$textarea_scrollTop_str=$_POST["textarea_scrollTop"];


file_put_contents($cursor_position_file, $editor_sel_start_str.'--'.$editor_sel_end_str.'--'.$editor_scrollTop_str.'--'.$editor_html_scrollTop_str.PHP_EOL.$textarea_sel_start_str.'--'.$textarea_sel_end_str.'--'.$textarea_scrollTop_str.'--'.$textarea_html_scrollTop_str);

}elseif (file_exists($cursor_position_file)){

$cursor_position_txt = file_get_contents($cursor_position_file, true);
$cursor_position_r=explode(PHP_EOL,$cursor_position_txt);

/*editor positions*/
$editor_cursor_position_r=explode('--',$cursor_position_r[0]);

$editor_sel_start_str=$editor_cursor_position_r[0];
$editor_sel_end_str=$editor_cursor_position_r[1];
if (!is_numeric($editor_cursor_position_r[2])){$editor_scrollTop_str=0;}else{$editor_scrollTop_str=$editor_cursor_position_r[2];}
if (!is_numeric($editor_cursor_position_r[3])){$editor_html_scrollTop_str=0;}else{$editor_html_scrollTop_str=$editor_cursor_position_r[3];}

/*textarea positions*/
$textarea_cursor_position_r=explode('--',$cursor_position_r[1]);

$textarea_sel_start_str=$textarea_cursor_position_r[0];
$textarea_sel_end_str=$textarea_cursor_position_r[1];
if (!is_numeric($textarea_cursor_position_r[2])){$textarea_scrollTop_str=0;}else{$textarea_scrollTop_str=$textarea_cursor_position_r[2];}
if (!is_numeric($textarea_cursor_position_r[3])){$textarea_html_scrollTop_str=0;}else{$textarea_html_scrollTop_str=$textarea_cursor_position_r[3];}

}

?>