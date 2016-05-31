<?include ('config.php');
include('miltos-parsedown-funcs.php');
?>
<!DOCTYPE html>
<html lang="en"><head>
	
		<title>markdownCMS</title>
		<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
		<meta content="Quickly edit your markdown files and create a small static html site from multiple markdown files for easy reading, editing and portability." name="description">

		<link href="../inc/reset.css" rel="stylesheet" type="text/css">
		<link href="../inc/miltos.css" rel="stylesheet" type="text/css">		
		
		<script src="../inc/prettify.js" type="text/javascript"></script>		
		<script src="../inc/jquery.min.js" type="text/javascript"></script>
		<script src="../inc/jquery-ui-custom/jquery-ui.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="../inc/jquery-ui-custom/jquery-ui.min.css">
		<script src="../inc/jquery.highlight-5.closure.js" type="text/javascript"></script>

<!-- <script type="text/javascript" src="../inc/zclip/jquery.zclip.min.js"></script> -->

    <script src="../jquery.splitter-master/js/jquery.splitter-0.14.0.js"></script>
    <link href="../jquery.splitter-master/css/jquery.splitter.css" rel="stylesheet"/>

<script>
jQuery(function($) {
   $('#frameset').width('100%').height('100%').split({orientation:'horizontal', limit:35, position:35});
   $('#down_frame').split({orientation:'vertical', limit:10, position:'30%'});

});

</script>

		<script type="text/javascript" src="../editarea_0_8_2/edit_area/edit_area_full.js"></script>
		<script src="../keymaster-master/keymaster.js" type="text/javascript"></script>
		
		<script src="../inc/jQuery.highlighter.js" type="text/javascript"></script>
		<link href="../inc/jQuery.highlighter.css" rel="stylesheet"/>

<style>
.splitter_panel .hsplitter {
	  height: 8px !important;	  
	  z-index: 8 !important;
	  margin-top: 7px !important;
}
.splitter_panel .vsplitter{
	  	width: 8px !important;
	    z-index: 8 !important;
}

#up_frame {
	margin-top: 2px;
}

.submenu{
	margin-top: 3px;	
}

</style>


	</head>
	<body onload="prettyPrint();">



<div id="frameset">

<!--************* file selection form *******************-->
	<div id="up_frame" align=center>
<script src="../inc/header_form.js" type="text/javascript"></script>
<?include('header_form_actions.php');?>
<?include('header_form.php');?>

		</div><!-- END up_frame-->

	<div id="down_frame" >	

<!--************* edit area form *******************-->
		<div class="input" id="input">

<?include('edit_area_form_actions.php');?>
<?include('edit_area_form.php');?>
<script src="../inc/miltos-cursor-position.js" type="text/javascript"></script>
<script src="../inc/edit_area.js" type="text/javascript"></script>


<?//if coming from search results
if (isset($_POST['anchor'])){?>

<script>
//set html to found anchor after page is fully loaded
window.onload = function () {
    window.location.hash = "<?echo $_POST['anchor'];?>";
    $('#right_frame_container').highlight('<?echo $_POST["search_term"];?>');
}
</script>


<?}else{//if not coming from search results
?>

<script>
//set scroll and cursor position based on .cur file
window.onload = function () {
set_cursor_and_scroll_position_from_hidden_fields_to_textarea();
}
</script>

<?}?>

			</div><!-- end left frame-->

<div class="right_frame_container" id="right_frame_container">
	
<!--************* html output area *******************-->

<?

if (file_exists($output_file)) {
	$file = file_get_contents($output_file, true);echo $file;
}
?>

</div><!-- right_frame_container-->


	</div><!-- end down_frame-->
</div><!-- end frameset-->

<!-- search popup on selected text-->



	<span class='holder'>
		<div class='share-highlight-btn'>
			<div class='btn-caret'>
			</div>
			<div class='btn-left'  id="edithere">Edit here</div>			
			<div class='btn-right'>&times;</div>
		</div>
	</span>

		

<script src="../inc/milt_popup_search.js" type="text/javascript"></script>

<!-- END search popup on selected text-->



</body></html>