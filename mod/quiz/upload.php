<?php

/**
 * This page creates a temperoray pdf file in server , which it gets from javascript
 * then create / update that annotated pdf in moodle database
 * @author Tausif , Vishal
 */
require_once('../../config.php');
require_once('locallib.php');

// create a temporary pdf file
if(!empty($_FILES['data'])) 
{
    $data = file_get_contents($_FILES['data']['tmp_name']);
    $fname = "temp.pdf";  // TODO name it properly   and check something like draft area
    $file = fopen("./" .$fname, 'w'); 
    fwrite($file, $data); 
    fclose($file);
} 


$contextID = $_REQUEST['contextID'];
$attemptID = $_REQUEST['attemptID'];
$filename = $_REQUEST['filename'];

$component = 'question';
$filearea = 'response_attachments';
$filepath = '/';
$itemid = $attemptID;
$temppath = "./temp.pdf"; // TODO name it properly  "./"+$fname;

$fs = get_file_storage();

// Prepare file record object
$fileinfo = array(
    'contextid' => $contextID, 
    'component' => $component,     
    'filearea' => $filearea,     
    'itemid' => $itemid,     
    'filepath' => $filepath,           
    'filename' => $filename);  

// Create file 
$doesExists = $fs->file_exists($contextID, $component, $filearea, $itemid, $filepath, $filename);
if($doesExists === true)
{
    $storedfile = $fs->get_file($contextID, $component, $filearea, $itemid, $filepath, $filename);
    $storedfile->delete();
    $fs->create_file_from_pathname($fileinfo, $temppath);
}
else
{
    $fs->create_file_from_pathname($fileinfo, $temppath);
}

?>