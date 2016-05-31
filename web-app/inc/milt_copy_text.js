

var tooltip, // global variables oh my! Refactor when deploying!
	hidetooltiptimer

function createtooltip(){ // call this function ONCE at the end of page to create tool tip object
	tooltip = document.createElement('div')
	tooltip.style.cssText = 
		'position:absolute; background:black; color:white; padding:4px;z-index:10000;'
		+ 'border-radius:2px; font-size:16px;box-shadow:3px 3px 3px rgba(0,0,0,.4);'
		+ 'opacity:0;transition:opacity 0.3s'
	tooltip.innerHTML = 'Copied!'
	document.body.appendChild(tooltip)
}

function showtooltip(e){
	var evt = e || event
	clearTimeout(hidetooltiptimer)
	tooltip.style.left = evt.pageX - 10 + 'px'
	tooltip.style.top = evt.pageY + 15 + 'px'
	tooltip.style.opacity = 1
	hidetooltiptimer = setTimeout(function(){
		tooltip.style.opacity = 0
	}, 500)
}

function copySelectionText(){
	var copysuccess // var to check whether execCommand successfully executed
	try{
		copysuccess = document.execCommand("copy") // run command to copy selected text to clipboard
	} catch(e){
		copysuccess = false
	}
return copysuccess
}

function getSelectionText(){
	var selectedText = ""
	if (window.getSelection){ // all modern browsers and IE9+
		selectedText = window.getSelection().toString()
	}
	return selectedText
}




$(function() {
	
//http://jsfiddle.net/yDsPB/3/	
//http://stackoverflow.com/questions/985272/selecting-text-in-an-element-akin-to-highlighting-with-your-mouse

jQuery.fn.selText = function(ev) {
	$(".copy-code").hide();	
	//$('.copy-code').css({'pointer-events' : 'none'});
    		var obj = document.elementFromPoint(ev.clientX, ev.clientY);
    		//console.log(document.elementFromPoint(ev.clientX, ev.clientY));
        var selection = obj.ownerDocument.defaultView.getSelection();        
        var range = obj.ownerDocument.createRange();
        range.selectNodeContents(obj);
        selection.removeAllRanges();
        selection.addRange(range);
	//$(".copy-code").show();
    		return this;
}
	

$('.copy-code').click(function(ev) {
copy_to_clipboard(ev);
})
      
	
		$('.copy-code').mouseover(function() {		
			$(".copy-code").show();
		});

    $("pre").mouseout(function() {    	
  		$(".copy-code").hide();
	  });


//http://stackoverflow.com/questions/21394835/how-to-center-a-new-div-based-on-mouse-cursor
//http://jsfiddle.net/fxd8b/2/

  $('pre').mousemove(function(e) {
    //$(".copy-code").css('top', e.clientY + moveDown).css('left', e.clientX + moveLeft).show();
    
	 //var w = $(".copy-code").width()/2
	 //h = $(".copy-code").height()
	 
   var h = $(".copy-code").height()/2   
   //var x = e.clientX - w  //- $(this).offset().left;
   var y = e.clientY - h  //- $(this).offset().top;
   //$(".copy-code").css({top: y, left: x, 'transform': 'scale(.2)'})
   $(".copy-code").css({top: y, right: 20}).show();
		});	


});

function copy_to_clipboard(ev) {
					//$(".copy-code").css({pointer-events: none;})	
//				$(".copy-code").hide();
        	$(this).selText(ev).addClass("selected");

//        	alert (JSON.stringify($(this).selText())); 

//Demo (select any text inside the paragraph below to copy it to clipboard):
//http://www.javascriptkit.com/javatutors/copytoclipboard.shtml        
					createtooltip() // create tooltip by calling it ONCE per page. See "Note" below        
		    	var selected = getSelectionText() // call getSelectionText() to see what was selected
    			if (selected.length > 0){ // if selected text length is greater than 0
        	var copysuccess = copySelectionText() // copy user selected text to clipboard
    	$(".copy-code").hide();    	
        	showtooltip(ev)
	
        	}
			//$(".copy-code").show();

}    

