<?
ini_set('memory_limit', '-1');

//check if runs locally
$local_dname='.l';

define("IS_LOCAL", substr_compare($_SERVER["SERVER_NAME"], $local_dname, strlen($_SERVER["SERVER_NAME"])-strlen($local_dname), strlen($local_dname)));

if (IS_LOCAL === 0){
define("CONFIG_FAVORITES_FILE", 'config_personal_favorites_file.php');
}else{
define("CONFIG_FAVORITES_FILE", 'config_demo_favorites_file.php');
}

include(CONFIG_FAVORITES_FILE);

$indx=$favorites_files_r_txt['settings']['default_fav'];
define("DEFAULT_OPEN_FILE", $favorites_files_r_txt['fav_files'][$indx]);

//print_r($favorites_files_r_txt);exit;
//echo DEFAULT_OPEN_FILE;
// problem with $ in path ========================================
foreach ($favorites_files_r_txt['fav_files'] as $value) {
	if (stristr($value,'$')){eval("\$value=$value;");} //for php variables path $_SERVER etc.
	$favorites_files_r[]=$value;
}





define("SLASH", stristr($_SERVER['SERVER_SOFTWARE'], "win") ? "\\" : "/"); // slash for win or unix

define("START_OF_MAIN_NAVIGATION_MENU", '<!--START OF MAIN NAVIGATION MENU-->


<script>

//if html output loads standalone
if(typeof jQuery == "undefined"){
document.write("<!DOCTYPE html><html lang=\"en\"><head><title>markdownCMS</title><meta content=\"text/html; charset=UTF-8\" http-equiv=\"Content-Type\"></head><body>");
document.write("<script type=\"text/javascript\" src=\"../inc/jquery.min.js\"></"+"script>");
document.write("<link href=\"../inc/reset.css\" rel=\"stylesheet\" type=\"text/css\">");
document.write("<link href=\"../inc/miltos.css\" rel=\"stylesheet\" type=\"text/css\">");

var output_runs_standalone="yes";
}
document.write("<script src=\"../inc/milt_copy_text.js\" type=\"text/javascript\"></"+"script>");

</script>


<script>

//if html outupt loads standalone
if (output_runs_standalone=="yes"){

// fade in #back-top
$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $(".back-top").fadeIn();
        } else {
            $(".back-top").fadeOut();
        }

        if ($(this).scrollTop() < $(document).height()-$(window).height() - 300) {
            $(".back-bottom").fadeIn();
        } else {
            $(".back-bottom").fadeOut();
        }
        
        
    });

    // scroll body to 0px on click
    $(".back-top").click(function () {
        $("body,html").animate({
            scrollTop: 0
        }, 400);
        return false;
    });
    
    $(".back-bottom").click(function () {        
        $("body,html").animate({
            scrollTop: $(document).height()-$(window).height()
        }, 400);
        return false;
    });    
    
    
});

//if runs inside frameset
}else{

// fade in #back-top
$(function () {
    $("#right_frame_container").scroll(function () {
        if ($("#right_frame_container").scrollTop() > 300) {
            $(".back-top").fadeIn();
        } else {
            $(".back-top").fadeOut();
        }
        

        if ($("#right_frame_container").scrollTop() < $("#right_frame_container").prop("scrollHeight")-$("#right_frame_container").height() - 300) {
            $(".back-bottom").fadeIn();
        } else {
            $(".back-bottom").fadeOut();
        }
        
    });

    // scroll body to 0px on click
    $(".back-top").click(function () {
        $("#right_frame_container").animate({
            scrollTop: 0
        }, 400);
        return false;
    });
    
    $(".back-bottom").click(function () {        
        $("#right_frame_container").animate({
            scrollTop: $("#right_frame_container").prop("scrollHeight")-$("#right_frame_container").height()
        }, 400);
        return false;
    });    
    
    
});

}//end running in frameset

</script>

<div class="back-top" title="Top of Page" align=center><a href="#MENU_ANCHOR_TOP_TOP">Top<img src="../inc/arrow-top-top.png" alt="Go to top" title="Go to top" /></a></div>

<div class="back-bottom" title="Bottom of Page" align=center><a href="#MENU_ANCHOR_TOP_TOP"><img src="../inc/arrow-top-bottom.png" alt="Go to bottom" title="Go to bottom" />Bottom</a></div>

<!-- copy code block -->
<div class="copy-code" title="Copy this code block" align=center><img style="vertical-align:middle" src="../inc/copy.png" alt="Copy this code block" title="Copy this code block" />&nbsp;Copy this code block</div>
<!-- END copy code block -->

<div id="output" class="output"><hr>
<a name="MENU_ANCHOR_TOP_TOP"></a>
');


define("END_OF_MAIN_NAVIGATION_MENU_TAG", '<!--END OF MAIN NAVIGATION MENU-->');

define("END_OF_MAIN_NAVIGATION_MENU", '

</div>

<script>

//if html outupt loads standalone
if (output_runs_standalone=="yes"){
document.write("</body></html>");
}
</script>

');


define("NAVIGATION_MENU_FILE", "../html-output/navigation_menu.html");

define("CREATE_MENU_BOOL", 1);

?>
