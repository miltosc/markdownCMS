<style>

.custom-inputfile_dropdown {
position: relative;
display: inline-block;
}
.custom-inputfile_dropdown-toggle {
position: absolute;
top: 0;
bottom: 0;
/*margin-left: 100%;*/
padding: 0;
}
.custom-inputfile_dropdown-input {
margin: 0px;
/*padding: 5px 10px;*/
width: 600px;
}

.ui-widget {	
  font-size: inherit !important;
}

.ui-button#LoadFileButtonhere{
	margin: 0px;
/*	position: absolute;*/
	padding:  0px 5px 2px 5px !important;	
}


.ui-button#LoadFileButtonnewtab{
	margin: 0px;
/*	position: absolute;*/
	padding:  0px 5px 2px 5px !important;
}


.ui-button#SavefiletofavButton{
	margin: 0px;
/*	position: absolute;*/
	padding:  0px 5px 2px 5px !important;
}

#search_term{
  margin-left: 80px;
  margin-top: 0px;
  background-color: white;
  border: solid 1px #6E6E6E;
  height: 25px;
  font-size: 18px;
  /*vertical-align: 10px;*/

}

#inputfile_txt{
  margin-left: 80px;
  margin-top: 0px;
  background-color: white;
  border: solid 1px #6E6E6E;
  height: 25px;
  font-size: 18px;
  /*vertical-align: 10px;*/

}

.ui-button#search_termButton{
	margin-left: -5px;
/*	position: absolute;*/
	padding:  0px 5px 2px 5px !important;
	
}


.menu_img {
		position:absolute;
    opacity: 1.0;
    margin-right: 0px;
} 

.menu_img:hover {
    opacity: 0.4;
}

</style>
		<form action="<?echo $_SERVER['PHP_SELF'];?>" method="post" name="file_selection_form" id="file_selection_form"  style="display: inline;">
<div id="filelist" align=center style="display: inline-block;float:center;"><!--file list-->
<div class="ui-widget" style="display: inline">
<select name=inputfile id=inputfile_dropdown>
<?php
foreach ($favorites_files_r as $value) {
	if ($value==$input_file){$str_sel=' selected ';}else{$str_sel='';}
    echo '<option value="'.$value.'" '. $str_sel.'>'.$value.'</option>';
}
?> 
</select>			

<span style="margin-left:40px;">Load File:</span>

<input id="LoadFileButtonhere" type="submit" value="Here">
<input id="LoadFileButtonnewtab" type="submit" value="New tab" onclick="this.form.target='_blank';return true;">
<script>
//initialise jquery ui buttons need to be after button
$( "#LoadFileButtonhere" ).button();
$( "#LoadFileButtonnewtab" ).button();
</script>

	</div>
</div>


<div id="inputfile_txt_div" align=center style="display: none;float:center;">
<!-- text field and drop down have same name for data submission but different id for javascript manipulation -->
<input type=text name=inputfile_txt id=inputfile_txt value="" style="display: none;width: 700px;">
<input id="SavefiletofavButton" type="submit" value="Save file to favorites">
<script>
//initialise jquery ui buttons need to be after button
$( "#SavefiletofavButton" ).button();
</script>

</div>

<!-- hidden fields -->
<input style="display:none" id="delete_fav" name="delete_fav" value=""/>
<input style="display:none" id="default_fav" name="default_fav" value=""/>

</form>


<div align=right style="display: inline-block;margin-right:70px;float:right;"><!--search form-->
<form action="search_term.php" method="post" name="file_selection_form" target="_blank" style="display: inline;">
<input id="search_term" name="search_term" title="type "a"" value=""/>  &nbsp;

<script>
/*for autocmplete*/
/*
var availableTags = [
	"BASIC",
	"C",
	"C++",
	"Clojure",
];
*/

var availableTags = [];

$( "#search_term" ).autocomplete({
	source: availableTags
});
</script>

<input id="search_termButton" type="submit" value="Search">
<script>
//initialise jquery ui buttons need to be after button
$( "#search_termButton" ).button();	
</script>
<img class=menu_img src=../inc/menu-button.png height=30 onclick="open_menu(60);">  &nbsp;
</form>
</div><!--search form-->

<div style="padding-top:5px;font-size: 16px;">
|
<a href="#" id=other_file onclick="change_select_box_to_textfield();">Type another file and add it to favorites</a>
|
<a href="#" id=other_file onclick="setdefault_selected_favorite();">Set as Default selected file</a>
|
<a href="#" id=other_file onclick="delete_selected_favorite();">Delete selected file from favorites</a>
| 
<a href="<? echo $_SERVER['PHP_SELF'].'?recreate_outputs_and_main_nav_menu=yes'; ?>" >Recreate all html files and main menu</a>
|
<a href="<?echo NAVIGATION_MENU_FILE;?>"  target="_blank">Main Navigation menu</a> 
|
</div>

<div style="padding-top:10px;font-size: 16px;position:relative;">
|
SYNTAX HELP :
<a href="#" onclick="window.open('../Daring Fireball  Markdown Syntax Documentation.htm', 'newwindow', 'width=800, height=1000'); return false;">MARKDOWN,</a>
<a href="#" onclick="window.open('http://parsedown.org/tests/', 'newwindow', 'width=800, height=1000'); return false;">BETTTER MARKDOWN,</a>
<a href="#" onclick="window.open('../Michel Fortin - PHP Markdown Extra.htm', 'newwindow', 'width=800, height=1000'); return false;">MARKDOWN EXTRA</a>
|
</div>
