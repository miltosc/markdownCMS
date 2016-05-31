<?
/* *************************** */
/* HEADER form submit acctions */
/* *************************** */


$output_file='../html-output/'.basename($input_file).'_'.md5(pathinfo($input_file, PATHINFO_DIRNAME)).'.html';


//print_r($_POST);exit;
if ($_GET["recreate_outputs_and_main_nav_menu"]=='yes'){

	//if both func arguments are empty recreate all html files and the main nav menu
	update_main_navigation_menu('','');
	$input_file=DEFAULT_OPEN_FILE;

}elseif ($_POST["inputfile_txt"]!=''){ //////////////////////////new favorite file added form submitted

/*manage favorites with ajax*/
		array_push($favorites_files_r_txt['fav_files'], $_POST["inputfile_txt"]);

		file_put_contents(CONFIG_FAVORITES_FILE, '<?php  $favorites_files_r_txt=' . var_export($favorites_files_r_txt,true) .'; ?>');

		sleep (3);//because of problem with locking conf file because it is read immidiately after writing stupid solution i have no time to solve it elegantly

		header('Location: index.php');
		exit;
		
}elseif (isset($_POST["inputfile"])){ //////////////////////////file selection from drop down form submitted

	$input_file=$_POST["inputfile"];


	//delete favorite
	if ($_POST["delete_fav"]=='yes'){

		$indx = array_search($input_file, $favorites_files_r);
		
		//do not assign the return value of array_splice back just on line and returns the array without the elemnt you deleted
		//This works because the array is passed by reference to the function.
		array_splice($favorites_files_r, $indx,1);
		$favorites_files_r_txt['fav_files']=$favorites_files_r;
		
		//decrement by 1 the default indx
		if ($indx<=$favorites_files_r_txt['settings']['default_fav']){
		--$favorites_files_r_txt['settings']['default_fav'];
		}

		file_put_contents(CONFIG_FAVORITES_FILE, '<?php  $favorites_files_r_txt=' . var_export($favorites_files_r_txt,true) .'; ?>');
		sleep (3);//because of problem with locking conf file because it is read immidiately after writing stupid solution i have no time to solve it elegantly
		

		header('Location: index.php');		
		//die();
		exit;
		
	}
	
	
	//set default favorite
	if ($_POST["default_fav"]=='yes'){

		//change only default_fav
		$favorites_files_r_txt['settings']['default_fav'] = array_search($input_file, $favorites_files_r);

		file_put_contents(CONFIG_FAVORITES_FILE, '<?php  $favorites_files_r_txt=' . var_export($favorites_files_r_txt,true) .'; ?>');
		
		header('Location: index.php');
		exit;
	}

	
}elseif (isset($_POST["text"])){ ///////////////////////////text processing form submitted
	//save text file
	$input_file=$_POST["processing_now_input_file"];	
	file_put_contents($input_file, $_POST["text"]);
	
	$output_file='../html-output/'.basename($input_file).'_'.md5(pathinfo($input_file, PATHINFO_DIRNAME)).'.html';
		
	check_and_clean_deleted_images($output_file,$_POST["text"]);
	
	//echo $input_file;exit;
	//create html file from markdown
	$html_file_menu=convert_markdownfile2html($input_file);	
	//run this after showing data to user at the end of index.php because it slows down the user
	update_main_navigation_menu($html_file_menu,$input_file);
	
	
}else{ ////////////////////////////////at first run load default file
  $input_file=DEFAULT_OPEN_FILE;
}

$output_file='../html-output/'.basename($input_file).'_'.md5(pathinfo($input_file, PATHINFO_DIRNAME)).'.html';
//backup file before edit
$timestamp = date('d-m-Y-H-i-s');
$backup_file = '../tmp_backup_files/'.basename($input_file).'-'.$timestamp.'.bak';
if (!copy("$input_file", "$backup_file")){echo 'ERROR copying '.$input_file.' to '.$backup_file.'<br><br><br>'; }


//delete 30days before files
  $files_in_backup = glob('../tmp_backup_files/*.bak');
  $time  = time();
  foreach ($files_in_backup as $file_in_backup)
    if (is_file($file_in_backup))
      if ($time - filemtime($file_in_backup) >= 60*60*24*7) // 7 days
        unlink($file_in_backup);


?>