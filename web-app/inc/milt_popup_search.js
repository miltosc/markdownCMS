function use_editors_search_function(selectedText) {
  //search with editors search function
  /*open search temporarily*/
  editAreaLoader.execCommand('text', 'show_search', !editAreaLoader.execCommand('text', 'show_search'));
  /*set search string*/
  window.frames["frame_text"].document.getElementById("area_search").value = selectedText;
  /*submit search*/
  editAreaLoader.execCommand('text', 'area_search', 'search');
  /*close search window*/
  editAreaLoader.execCommand('text', "hidden_search", 1);
}

$(document).ready(function() {
  $(".output").highlighter({
    "selector": ".holder",
    'complete': function(data) {
      selectedText = data;
    }
  });

  $('.holder').mousedown(function() {
    return false;
  });

/**
 * this is draft jQuery solution --
 * click edit here button to find text in textarea and
 * force chrome and webkit browsers to scroll at text
 */

  var clicks = 0;

  $('#edithere').click(function() {
    // alert(selectedText);

    //if editor does not exist search left div with my function
    if (editor_is_not_in_use()) {

      //https://developer.mozilla.org/en-US/docs/Web/API/Window/find
      //http://software.hixie.ch/utilities/js/live-dom-viewer/?%3C!DOCTYPE%20HTML%3E%0A%3Ctitle%3Ewindow.find%28%29%20testing%20kitchen%3C%2Ftitle%3E%0A%3Cform%3E%0A%3Cp%3ESome%20text%20before.%20Cats%2C%20cat%2C%20and%20CATALOGUES%20are%20here.%3C%2Fp%3E%0A%3Cfieldset%3E%0A%20%3Clegend%3Ewindow.find%28%29%3C%2Flegend%3E%0A%20%3Cp%3E%3Clabel%3EaString%20%3Cinput%20name%3DaString%3E%3C%2Flabel%3E%0A%20%3Cp%3E%3Clabel%3EaCaseSensitive%20%3Cinput%20name%3DaCS%20type%3Dcheckbox%3E%3C%2Flabel%3E%0A%20%3Cp%3E%3Clabel%3EaBackwards%20%3Cinput%20name%3DaB%20type%3Dcheckbox%3E%3C%2Flabel%3E%0A%20%3Cp%3E%3Clabel%3EaWrapAround%20%3Cinput%20name%3DaWA%20type%3Dcheckbox%3E%3C%2Flabel%3E%0A%20%3Cp%3E%3Clabel%3EaWholeWord%20%3Cinput%20name%3DaWW%20type%3Dcheckbox%3E%3C%2Flabel%3E%0A%20%3Cp%3E%3Clabel%3EaSearchInFrames%20%3Cinput%20name%3DaSIF%20type%3Dcheckbox%3E%3C%2Flabel%3E%0A%20%3Cp%3E%3Clabel%3EaShowDialog%20%3Cinput%20name%3DaSD%20type%3Dcheckbox%3E%3C%2Flabel%3E%0A%20%3Cp%3E%3Cinput%20type%3Dbutton%20onclick%3D%22window.find%28aString.value%2C%20aCS.checked%2C%20aB.checked%2C%20aWA.checked%2C%20aWW.checked%2C%20aSIF.checked%2C%20aSD.checked%29%22%20value%3D%22search%22%3E%0A%3C%2Ffieldset%3E%0A%3Cp%3Esearch%20text%3A%20vacation%20contains%20cat%20cat%20cat%3C%2Fp%3E%0A%3Cp%3E%3Ciframe%20src%3Ddata%3Atext%2Fplain%2Cas%2520does%2520this%2520cat%3E%3C%2Fp%3E%0A%3C%2Fform%3E%0A

      var gotoText = function(text, textarea_id) {


        //window.find(aString, aCaseSensitive, aBackwards, aWrapAround, aWholeWord, aSearchInFrames, aShowDialog);
        var target = document.getElementById(textarea_id);
        var txtarea = $(target).val(); // the whole textarea
        var last_position = txtarea.lastIndexOf(selectedText); // position of the last found word in the text

        target.focus(); // maybe commented because FF gives NS_ERROR_ILLEGAL_VALUE ?
        // console.log(clicks); // dev testing
        console.log('aaaaa');

        if (clicks == 0) {
          var position = txtarea.indexOf(selectedText); // position of the first found word in the text
          clicks++;
          next_instance = position + 2;
          // console.log('position', position); // dev testing
          // console.log('next instance', next_instance); // dev testing

        } else {

          var position = txtarea.indexOf(selectedText, next_instance); // position of the next found word in the text
          clicks++;
          next_instance = position + 2;
          // console.log('position', position); // dev testing
          // console.log('next instance', next_instance); // dev testing

        };

        // console.log('last position', last_position); // dev testing

        if (position != -1) {
          // select the textarea and the word
          target.focus();
          if (target.setSelectionRange)
            target.setSelectionRange(position, position + selectedText.length);
          else {
            var r = target.createTextRange();
            r.collapse(true);
            r.moveEnd('character', position + selectedText);
            r.moveStart('character', position);
            r.select();
          }
          var objDiv = document.getElementById('text');
          var sh = objDiv.scrollHeight; //height in pixel of the textarea (n_rows*line_height)
          var line_ht = 22; //height in pixel of each row
          var linesbefore = txtarea.substring(0, position).match(/^[ \t]*$/gm).length; // this is the number of void lines before the found word
          var n_lines = sh/line_ht;//+linesbefore); // the total amount of lines
          var char_in_line = txtarea.length / n_lines; // amount of chars for each line
          var height = Math.floor(position / char_in_line) - 20; // amount of lines in the textarea
          var scrollto = height * line_ht;
          $(target).scrollTop(scrollto); // scroll to the selected line

          // console.log('empty lines', linesbefore); // dev testing
          // console.log('chars lines', char_in_line); // dev testing
          // console.log('area height', sh); // dev testing
          // console.log('scrollto', scrollto); // dev testing

          if (position >= last_position) {
            next_instance = 0;
            clicks = 0;
            position = -1;
          }

        };

      };

      gotoText(selectedText, "text");

      //$('.holder').hide();

    } else { //editor is open use editor's search function

      use_editors_search_function(selectedText);
    }
    return false;
  });

  $('.btn-right').click(function() {
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
