<?php
/**
 * @author Manuel Irrazabal
 * @version 1.0
 */

include 'classes/ImagesClass.php';
include 'classes/ExportClass.php';

function wrapper()
{
    // initialize general variables
    $long_options = array('dir::', 'name::');
    $main_directory = 'images/gps_images';
    $images_list = array();

    $parametes = getopt('', $long_options);
    $second_directory = isset($parametes['dir']) ? $parametes['dir'] : null;
    $optional_name = isset($parametes['name']) ? $parametes['name'] : null;
    
    // Initialized Classes
    $export = new ExportClass;
    $images = new ImagesClass;

    // Get the array with all images found
    $images_list = $export->getFiles($main_directory, $second_directory);
    $images_list = $images->processImagesArray($images_list);

    // Generate the CSV File
    if ($export->exportToCSV($images_list, $optional_name)) {
        echo 'The file has been proceced, please check the directory ' . PHP_EOL . $export->csv_path_to_export . '. File name ' . $export->csv_file_name . PHP_EOL;
    } else {
        echo $export->errors;
    }
}

wrapper();


?>