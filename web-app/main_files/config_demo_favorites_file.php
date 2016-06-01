<?php
// path for app to work with the demo content OR
// path to work with file-folders inside the app root folder
$path_to_app_root = dirname(dirname(dirname(__FILE__)));
// comment previous line and uncomment the line bellow to define a files-folder at the server document root folder level
// $path_to_app_root = $_SERVER['DOCUMENT_ROOT'];

$favorites_files_r_txt=array (
  'settings' =>
  array (
    'default_fav' => 0,
  ),
  'fav_files' =>
  array (
    0 => $path_to_app_root."/README.md",
    1 => $path_to_app_root."/demo-md-files/notes2.md",
    2 => $path_to_app_root."/demo-md-files/notes3.txt",
  ),
); ?>
