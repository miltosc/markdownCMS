<!-- Text submission form -->	
<form action="<?echo $_SERVER['PHP_SELF'];?>" method="post" name="source_form" id="source_form"  class="edit_form">
	
<!-- hidden fields -->
			<input style="display:none" id="open_menu" name="open_menu" value="0"/>

			<input  style="display:none" id="editor_sel_start" name="editor_sel_start" value="<?echo $editor_sel_start_str;?>"/>
			<input  style="display:none" id="editor_sel_end" name="editor_sel_end" value="<?echo $editor_sel_end_str;?>"/>
			<input  style="display:none" id="editor_scrollTop" name="editor_scrollTop" value="<?echo $editor_scrollTop_str;?>"/>
			<input  style="display:none" id="editor_html_scrollTop" name="editor_html_scrollTop" value="<?echo $editor_html_scrollTop_str;?>"/>
						
			<input  style="display:none" id="textarea_sel_start" name="textarea_sel_start" value="<?echo $textarea_sel_start_str;?>"/>
			<input  style="display:none" id="textarea_sel_end" name="textarea_sel_end" value="<?echo $textarea_sel_end_str;?>"/>
			<input  style="display:none" id="textarea_scrollTop" name="textarea_scrollTop" value="<?echo $textarea_scrollTop_str;?>"/>
			<input  style="display:none" id="textarea_html_scrollTop" name="textarea_html_scrollTop" value="<?echo $textarea_html_scrollTop_str;?>"/>

<input  style="display:none" id="edit_here_or_last_pos" name="edit_here_or_last"/>


			<input style="display:none" id="processing_now_input_file" name="processing_now_input_file" value="<?echo $input_file;?>">

<!--<textarea autofocus="false" name="text" id="text" style="width: 100%;line-height: 22px;overflow: auto;" wrap="off">-->
<textarea autofocus="false" name="text" id="text" style="width: 100%;line-height: 22px;"  wrap="soft">
<?
//echo $input_file;
$file = file_get_contents($input_file, true);
echo $file;
?>
</textarea>

<div style="position: absolute; bottom: 0px; width: 100%;">
				<div style="position: relative;">
					<button class=button_save type="submit" id=submit_button>Save and Parse (ctrl/shift)+Enter or ctrl+S</button>						
				</div>
			</div>

</form>


<div style="position: absolute; bottom: 65px; width: 100%;">

<!-- try this https://jsfiddle.net/algometrix/fgrbyo4z/ -->
<form id="uploadForm" enctype="multipart/form-data">
    <input name="userImage" id="userImage" type="file" value="insert image" />
    <input name="output_html_filename" id="output_html_filename" value="<?echo $output_file?>" type="hidden" />    
</form>

<div id="confirmBox">
    <div>Toggle editor and ...</div>
    <span class="editortoggler" onclick="javascript:document.getElementById('edit_here_or_last_pos').value='edit_here';eAL.toggle('text');">Edit here</span> | 
    <span class="editortoggler" onclick="javascript:document.getElementById('edit_here_or_last_pos').value='last_pos';eAL.toggle('text');">Go to last edit position</span>
</div>

</div>

<script>
	

$(document).ready(function () {
	
	
jQuery.fn.extend({
insertAtCaret: function(myValue){
  return this.each(function(i) {
    if (document.selection) {
      //For browsers like Internet Explorer
      this.focus();
      var sel = document.selection.createRange();
      sel.text = myValue;
      this.focus();
    }
    else if (this.selectionStart || this.selectionStart == '0') {
      //For browsers like Firefox and Webkit based
      var startPos = this.selectionStart;
      var endPos = this.selectionEnd;
      var scrollTop = this.scrollTop;
      this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
      this.focus();
      this.selectionStart = startPos + myValue.length;
      this.selectionEnd = startPos + myValue.length;
      this.scrollTop = scrollTop;
    } else {
      this.value += myValue;
      this.focus();
    }
  });
}
});
	


var handleFileSelect = function(evt) {

		$.ajax({
		url: "upload.php",
		type: "POST",
		data:  new FormData($('#uploadForm')[0]),
		contentType: false,
		cache: false,
		processData:false,
		context: document.body,
    success: function(responseText) {
    		$('#text').insertAtCaret(responseText);

        /*
        $("#text").html(responseText);
        $("#text").find("script").each(function(i) {
            eval($(this).text());
        });
				*/
    },
		
    //beforeSend: function(result){ alert(name); },
    //error: errorHandler,
		
		error: function(){}
		//$('#text').insertAtCaret( "src='data:image/png;base64,"+btoa(binaryString) + "'>" );		
		});
		
};

document.getElementById('userImage').addEventListener('change', handleFileSelect, false);

})


</script>

