/*select box*/
(function( $ ) {
$.widget( "custom.inputfile_dropdown", {
_create: function() {
this.wrapper = $( "<span>" )
.addClass( "custom-inputfile_dropdown" )
.insertAfter( this.element );
this.element.hide();
this._createAutocomplete();
this._createShowAllButton();
},
_createAutocomplete: function() {
var selected = this.element.children( ":selected" ),
value = selected.val() ? selected.text() : "";
this.input = $( "<input onclick=\"this.value=''\">" )
.appendTo( this.wrapper )
.val( value )
.attr( "title", "" )
.addClass( "custom-inputfile_dropdown-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
.autocomplete({
delay: 0,
minLength: 0,
source: $.proxy( this, "_source" )
})
.tooltip({
tooltipClass: "ui-state-highlight"
});
this._on( this.input, {
autocompleteselect: function( event, ui ) {
ui.item.option.selected = true;
this._trigger( "select", event, {
item: ui.item.option
});
},
autocompletechange: "_removeIfInvalid"
});
},
_createShowAllButton: function() {
var input = this.input,
wasOpen = false;
$( "<a>" )
.attr( "tabIndex", -1 )
.attr( "title", "Click inside selectbox for searching your favorites" )
.tooltip()
.appendTo( this.wrapper )
.button({
icons: {
primary: "ui-icon-triangle-1-s"
},
text: false
})
.removeClass( "ui-corner-all" )
.addClass( "custom-inputfile_dropdown-toggle ui-corner-right" )
.mousedown(function() {
wasOpen = input.autocomplete( "widget" ).is( ":visible" );
})
.click(function() {
input.focus();
// Close if already visible
if ( wasOpen ) {
return;
}
// Pass empty string as value to search for, displaying all results
input.autocomplete( "search", "" );
});
},
_source: function( request, response ) {
var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
response( this.element.children( "option" ).map(function() {
var text = $( this ).text();
if ( this.value && ( !request.term || matcher.test(text) ) )
return {
label: text,
value: text,
option: this
};
}) );
},
_removeIfInvalid: function( event, ui ) {
// Selected an item, nothing to do
if ( ui.item ) {
return;
}
// Search for a match (case-insensitive)
var value = this.input.val(),
valueLowerCase = value.toLowerCase(),
valid = false;
this.element.children( "option" ).each(function() {
if ( $( this ).text().toLowerCase() === valueLowerCase ) {
this.selected = valid = true;
return false;
}
});
// Found a match, nothing to do
if ( valid ) {
return;
}
// Remove invalid value
this.input
.val( "" )
.attr( "title", value + " didn't match any item" )
.tooltip( "open" );
this.element.val( "" );
this._delay(function() {
this.input.tooltip( "close" ).attr( "title", "" );
}, 2500 );
this.input.autocomplete( "instance" ).term = "";
},
_destroy: function() {
this.wrapper.remove();
this.element.show();
}
});
})( jQuery );


$(function() {
$( "#inputfile_dropdown" ).inputfile_dropdown();
$( "#toggle" ).click(function() {
$( "#inputfile_dropdown" ).toggle();
$( "#inputfile_dropdown" ).val('');
});
});

/*end jquery ui select*/

function open_menu(open_size){
if (document.getElementById('open_menu').value==0){
/*new up frame height*/
new_height=parseInt(document.getElementById('up_frame').style.height)+open_size;
document.getElementById('up_frame').style.height=new_height+'px';

/*new down frame height*/
new_height=parseInt(document.getElementById('down_frame').style.height)-open_size;
document.getElementById('down_frame').style.height=new_height+'px';

/*new horizontal splitter position*/
new_height=parseInt($('.hsplitter').css('top'))+open_size;
$('.hsplitter').css('top', new_height+'px');
document.getElementById('open_menu').value=1;

}else{

/*new up frame height*/
new_height=parseInt(document.getElementById('up_frame').style.height)-open_size;
document.getElementById('up_frame').style.height=new_height+'px';

/*new down frame height*/
new_height=parseInt(document.getElementById('down_frame').style.height)+open_size;
document.getElementById('down_frame').style.height=new_height+'px';

/*new horizontal splitter position*/
new_height=parseInt($('.hsplitter').css('top'))-open_size;
$('.hsplitter').css('top', new_height+'px');
document.getElementById('open_menu').value=0;
}

}


function change_select_box_to_textfield(){


		var dropDown = document.getElementById("inputfile_dropdown");
		var dropDownValue = dropDown.options[dropDown.selectedIndex];
/*
		var textBox = document.getElementById("inputfile_txt");
*/
		

	if (document.getElementById("inputfile_txt").style.display=='none'){
		
		$("#filelist").hide();		

		document.getElementById("inputfile_txt_div").style.display = 'inline-block';
		document.getElementById("inputfile_txt").style.display = 'inline';
		
		document.getElementById("inputfile_txt").value = dropDownValue.text;
    document.getElementById('other_file').text="Select file from Favorites";
   
  }else{ 	
  		

		document.getElementById("inputfile_txt_div").style.display = 'none';
		document.getElementById("inputfile_txt").style.display = 'none';
		
		document.getElementById("inputfile_txt").value ="";		
    document.getElementById('other_file').text="Type another file and add it to favorites";

		$("#filelist").show();
  	
  }
}

function delete_selected_favorite(){
	
if (document.getElementById("inputfile_txt").style.display!='none'){
change_select_box_to_textfield()
}

if (confirm('Are you sure you want to delete \n'+document.getElementById("inputfile_dropdown").value+ ' from favorites?')) {
	document.getElementById("delete_fav").value='yes';
	document.getElementById('LoadFileButtonhere').click();
}
	
}


function setdefault_selected_favorite(){
	
	document.getElementById("default_fav").value='yes';
	document.getElementById('LoadFileButtonhere').click();
	
}

