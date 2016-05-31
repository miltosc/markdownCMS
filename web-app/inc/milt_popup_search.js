function use_editors_search_function(selectedText) {
	//search with editors search function
	/*open search temporarily*/
	editAreaLoader.execCommand('text', 'show_search', !editAreaLoader.execCommand('text', 'show_search'));
	/*set search string*/
	window.frames["frame_text"].document.getElementById("area_search").value=selectedText;
	/*submit search*/
	editAreaLoader.execCommand('text','area_search','search');
	/*close search window*/
	editAreaLoader.execCommand('text',"hidden_search",1);
}

		$(document).ready(function() {
			$(".output").highlighter({"selector": ".holder",'complete': function (data) { selectedText = data; }});    

		    $('.holder').mousedown(function(){
		        return false;
		    });

		    $('#edithere').click(function(){
		        //alert(selectedText);

//if editor does not exist search left div with my function
if ( editor_is_not_in_use() ) {


//https://developer.mozilla.org/en-US/docs/Web/API/Window/find
//http://software.hixie.ch/utilities/js/live-dom-viewer/?%3C!DOCTYPE%20HTML%3E%0A%3Ctitle%3Ewindow.find%28%29%20testing%20kitchen%3C%2Ftitle%3E%0A%3Cform%3E%0A%3Cp%3ESome%20text%20before.%20Cats%2C%20cat%2C%20and%20CATALOGUES%20are%20here.%3C%2Fp%3E%0A%3Cfieldset%3E%0A%20%3Clegend%3Ewindow.find%28%29%3C%2Flegend%3E%0A%20%3Cp%3E%3Clabel%3EaString%20%3Cinput%20name%3DaString%3E%3C%2Flabel%3E%0A%20%3Cp%3E%3Clabel%3EaCaseSensitive%20%3Cinput%20name%3DaCS%20type%3Dcheckbox%3E%3C%2Flabel%3E%0A%20%3Cp%3E%3Clabel%3EaBackwards%20%3Cinput%20name%3DaB%20type%3Dcheckbox%3E%3C%2Flabel%3E%0A%20%3Cp%3E%3Clabel%3EaWrapAround%20%3Cinput%20name%3DaWA%20type%3Dcheckbox%3E%3C%2Flabel%3E%0A%20%3Cp%3E%3Clabel%3EaWholeWord%20%3Cinput%20name%3DaWW%20type%3Dcheckbox%3E%3C%2Flabel%3E%0A%20%3Cp%3E%3Clabel%3EaSearchInFrames%20%3Cinput%20name%3DaSIF%20type%3Dcheckbox%3E%3C%2Flabel%3E%0A%20%3Cp%3E%3Clabel%3EaShowDialog%20%3Cinput%20name%3DaSD%20type%3Dcheckbox%3E%3C%2Flabel%3E%0A%20%3Cp%3E%3Cinput%20type%3Dbutton%20onclick%3D%22window.find%28aString.value%2C%20aCS.checked%2C%20aB.checked%2C%20aWA.checked%2C%20aWW.checked%2C%20aSIF.checked%2C%20aSD.checked%29%22%20value%3D%22search%22%3E%0A%3C%2Ffieldset%3E%0A%3Cp%3Esearch%20text%3A%20vacation%20contains%20cat%20cat%20cat%3C%2Fp%3E%0A%3Cp%3E%3Ciframe%20src%3Ddata%3Atext%2Fplain%2Cas%2520does%2520this%2520cat%3E%3C%2Fp%3E%0A%3C%2Fform%3E%0A


var gotoText = function(text,textarea_id) {
//window.find(aString, aCaseSensitive, aBackwards, aWrapAround, aWholeWord, aSearchInFrames, aShowDialog);
	var target = document.getElementById(textarea_id);
	//the following commented because FF gives NS_ERROR_ILLEGAL_VALUE
	//target.focus();	
	console.log('aaaaa') ;
	

/*
    function iefind(string,textarea_id) {
        var txt = document.body.createTextRange();         
        var txt = target.createTextRange();
        console.log('bbbbb') ;
        if (txt.findText(string)) { 
            txt.scrollIntoView();
            txt.collapse(false);
        }
    }

    if(!window.find) { // ie    	
    	console.log('ccc') ;
        iefind(text,textarea_id);
        return;
    }
*/
    // a double window.find() for backwards and forward search
    //if not found backwards search forward
    if(!window.find(text, false, true)){
    	console.log('dddd') ;
       window.find(text, false, false);
       scrollIntoView();
    }

};

//alert(selectedText);
gotoText(selectedText,"text");


//$('.holder').hide();
		    
}else{//editor is open use editor's search function

use_editors_search_function(selectedText);
}
		        return false;
		    });

		    $('.btn-right').click(function(){
		        $('.holder').hide();
		        return false;
		    });

/*

//See more at: http://www.steamdev.com/zclip/#sthash.j6WUoN5N.dpuf
//old look for ZeroClipboard in jQuery
$('#copy-description').click(function(){

//alert(selectedText);
$('#copy-description').zclip({
path:'../inc/zclip/ZeroClipboard.swf',
//copy:selectedText

copy:function(){		
	alert(selectedText);
    return "dddddddddd";
    }

});

// The link with ID "copy-description" will copy
// the text of the paragraph with ID "description"

		        return false;
		    });

*/

		});







