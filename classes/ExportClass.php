<?php
/**
 * Export Class, Manage and generate files
 * 
 * @author Manuel Irrazabal
 * @version 1.0
 */

class ExportClass
{
    /**
     * Public and private vars
     * 
     * @var
     */
    public $files;
    public $errors;
    public $csv_file_name;
    public $csv_path_to_export;
    private $csv_headers;

    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->csv_headers = array('Path and File name', 'Longitude', 'Latitude', 'Google Maps Link');
        $this->csv_file_name = 'LonLat_images_file' . date('YmdHis') . '.csv';
        $this->csv_path_to_export = 'exports/';
    }

    /**
     * Public function get Files
     * Returns an array of all files found it in the given directory
     * as a second option we can pass a extra directory to search
     * 
     * @param string $path
     * @param string $second_path
     * @return array
     */
    public function getFiles($path, $second_path = null)
    {
        if (!is_null($second_path)) {
            $this->getFiles($second_path);
        }

        if ($directory = opendir($path)) {
            while ($entry = readdir($directory)) {
                $new_path = $path . '/' . $entry;

                if (($entry == '.') || ($entry == '..') || ($entry == '.DS_Store')) {
                    continue;
                }

                if (is_dir($new_path)) {
                    $this->getFiles($new_path);
                } else {
                    $this->files[]['path'] = $path . '/' . $entry;
                }
            }
        }

        return $this->files;
    }

    /**
     * Public function Export to CSV
     * Returns a CSV File from the array given
     * 
     * @param array $files_to_export
     * @param string $file_name
     * @return boolean
     */
    public function exportToCSV($files_to_export, $file_name = null)
    {
        try {
            if (isset($file_name)) {
                if (strpos($file_name, '.csv') === false) {
                    $file_name .= '.csv';
                }
                $this->csv_file_name = $file_name;
            }

            $fp = fopen($this->csv_path_to_export . $this->csv_file_name, 'w');
            if ($fp === false) {
                $this->errors = 'We could not open the given directory' . PHP_EOL;
                return false; 
            }

            // Add Headers
            fputcsv($fp, $this->csv_headers);
    
            foreach ($files_to_export as $fields) {
                if (is_null($fields['latitude']) && is_null($fields['longitude'])) {
                    continue;
                }
    
                fputcsv($fp, $fields);
            }
    
            fclose($fp);
        } catch (Exception $e) {
            $this->errors = 'Exception = ' . $e->getMessage() . ' File = ' . $e->getFile() . ' Line = ' . $e->getLine() . PHP_EOL;
            return false;
        }   
        return true;
    }
}
?>