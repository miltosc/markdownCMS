/*set editors cursors and scroll positions on load*/	
editAreaLoader.init({
	id: "text"	// id of the textarea to transform		
	//,start_highlight: true	// if start with highlight			
	,allow_resize: "both"
	,allow_toggle: false
	,allow_resize: "y"
	,display: "later" //load at the beginning or later if pressed toggle comment for immediate editor load
	,word_wrap: true
	//,debug:false
	,font_size: 12
	
//if disable the following you can edit in here in browser toggle else change position to last edit state
	//,EA_load_callback: "set_cursor_and_scroll_position_from_hidden_fields_to_editor"
	,EA_toggle_on_callback: "rich_editor_after_toggle_on"
	,EA_toggle_off_callback: "rich_editor_after_toggle_off"
	//,language: "en"
	//,syntax: "bash"	
});

function rich_editor_after_toggle_on(){

	//document.getElementById('edit_here_or_last').value='edit_here'
	if (document.getElementById('edit_here_or_last_pos').value=='edit_here'){
		
//	editAreaLoader.setSelectionRange(id, <?echo $editor_sel_start_str;?>, <?echo $editor_sel_end_str;?>);
editAreaLoader.setSelectionRange('text', document.getElementById('textarea_sel_start').value, document.getElementById('textarea_sel_end').value);

//    window.frames["frame_text"].document.getElementById("result").scrollTop = <?echo $editor_scrollTop_str;?>;
window.frames["frame_text"].document.getElementById("result").scrollTop = document.getElementById('textarea_scrollTop').value;

//	document.getElementById('right_frame_container').scrollTop = <?echo $editor_html_scrollTop_str;?>;
document.getElementById('right_frame_container').scrollTop = document.getElementById('textarea_html_scrollTop').value;

		
	
	}else if (document.getElementById('edit_here_or_last_pos').value=='last_pos'){
		set_cursor_and_scroll_position_from_hidden_fields_to_editor('text');
	}

}

function rich_editor_after_toggle_off(){

	//document.getElementById('edit_here_or_last').value='edit_here'
	if (document.getElementById('edit_here_or_last_pos').value=='edit_here'){
	
	
	}else if (document.getElementById('edit_here_or_last_pos').value=='last_pos'){
		set_cursor_and_scroll_position_from_hidden_fields_to_textarea();
	}

}


//set textarea cursors and scroll positions after page is fully loaded for editor only
function set_cursor_and_scroll_position_from_hidden_fields_to_textarea() {
	
setInputSelection(document.getElementById("text"), document.getElementById('textarea_sel_start').value , document.getElementById('textarea_sel_end').value);

//Console.log(document.getElementById('textarea_scrollTop').value);
//Console.log(document.getElementById('textarea_html_scrollTop').value);

document.getElementById("text").scrollTop = document.getElementById('textarea_scrollTop').value;

document.getElementById('right_frame_container').scrollTop = document.getElementById('textarea_html_scrollTop').value;
}


//set editor cursors and scroll positions after page is fully loaded for editor only
function set_cursor_and_scroll_position_from_hidden_fields_to_editor(id){

//set editors position on load

//	editAreaLoader.setSelectionRange(id, <?echo $editor_sel_start_str;?>, <?echo $editor_sel_end_str;?>);
editAreaLoader.setSelectionRange(id, document.getElementById('editor_sel_start').value, document.getElementById('editor_sel_end').value);

//    window.frames["frame_text"].document.getElementById("result").scrollTop = <?echo $editor_scrollTop_str;?>;
window.frames["frame_text"].document.getElementById("result").scrollTop = document.getElementById('editor_scrollTop').value;

//	document.getElementById('right_frame_container').scrollTop = <?echo $editor_html_scrollTop_str;?>;
document.getElementById('right_frame_container').scrollTop = document.getElementById('editor_html_scrollTop').value;
}

//jquery way to submit form on ctrl+s
							$(document).bind('keydown', function(e) {
								if(e.ctrlKey && (e.which == 83)) {
									e.preventDefault();
									alert('Ctrl+S');
									//the .submit() function does not run the form onsubmit action 
									//so use the click submit button call
									document.getElementById('submit_button').click();
									return false;
								}
							});
							
//other way using keymaster for shortcut but i couldn make ctrl_s to work							
							key.setScope('all');
							key.filter = function(event){
						  var tagName = (event.target || event.srcElement).tagName;
						  key.setScope(/^(INPUT|TEXTAREA|SELECT)$/.test(tagName) ? 'input' : 'other');
						  return true;
							}
							key.setScope('all');
							//the .submit() function does not run the form onsubmit action 
							//so use the click submit button call
							key('shift+enter, ctrl+enter','all', function(){ document.getElementById('submit_button').click(); });
		

function cursor_and_scroll_position_to_hidden_fields() {

/*textarea*/
if ( editor_is_not_in_use() ) {

/*textarea cursor*/
document.getElementById('textarea_sel_start').value = getInputSelection(document.getElementById("text")).start;
document.getElementById('textarea_sel_end').value = getInputSelection(document.getElementById("text")).end;

//alert('textarea_sel_start='+document.getElementById('textarea_sel_start').value+'textarea_sel_end='+document.getElementById('textarea_sel_end').value);

/*textarea scroll*/	
	document.getElementById('textarea_html_scrollTop').value = document.getElementById('right_frame_container').scrollTop;
	document.getElementById('textarea_scrollTop').value = document.getElementById("text").scrollTop;

//alert('textarea_scrollTop='+document.getElementById('textarea_scrollTop').value+" textarea_html_scrollTop"+document.getElementById('textarea_html_scrollTop').value);	

/*editor */
}else{

/*editor cursor*/
var editor_sel = editAreaLoader.getSelectionRange('text');
document.getElementById('editor_sel_start').value = editor_sel.start;
document.getElementById('editor_sel_end').value = editor_sel.end;

//alert('editor_sel_start='+document.getElementById('editor_sel_start').value+'editor_sel_end='+document.getElementById('editor_sel_end').value);

/*editor scroll*/	
	document.getElementById('editor_html_scrollTop').value = document.getElementById('right_frame_container').scrollTop;
	document.getElementById('editor_scrollTop').value = window.frames["frame_text"].document.getElementById("result").scrollTop;
  
//alert('editor_scrollTop='+document.getElementById('editor_scrollTop').value+" editor_html_scrollTop"+document.getElementById('editor_html_scrollTop').value);
}

}


function editor_is_not_in_use(){
	if ( ! ($('#frame_text').length) || document.getElementById("frame_text").style.display == "none") {
	return true
	}
}

/* save cursor position on click and mouseout of teaxtarea*/
$('#text').on('click mouseout', function() {cursor_and_scroll_position_to_hidden_fields();});


/* save cursor position on mouseleave of editor if exists*/
//http://stackoverflow.com/questions/14002714/trigger-event-when-an-element-exists
var check_constantly_for_visible_editors = setInterval(function(){
  if ($("div.input iframe").length > 0 && document.getElementById("frame_text").style.display != "none"){ // Check if element has been found
    // There is an iframe element in here!!
    //console.log($("div.input iframe"));
    var iframeDoc = $('#frame_text').contents().get(0);
		$(iframeDoc).bind('click mouseout', function( event ) { cursor_and_scroll_position_to_hidden_fields(); return false;});
  }
},1000);//miliseconds

