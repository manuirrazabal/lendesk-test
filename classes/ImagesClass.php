<?php
/**
 * Images Class, Main purpouse get the image location
 * 
 * @author Manuel Irrazabal
 * @version 1.0
 */

class ImagesClass
{
    /**
     * Public function process Images Array
     * Return a sort array with latitude and longitude of all images found
     * 
     * @param array $images_list
     * @return array
     */
    public function processImagesArray($images_list)
    {
        if (empty($images_list)) {
            return $images_list;
        }

        foreach ($images_list as $image_key => $image) {
            $response = $this->getImageLocation($image['path']);
            $images_list[$image_key]['latitude'] = isset($response['latitude']) ? $response['latitude'] : null;
            $images_list[$image_key]['longitude'] = isset($response['longitude']) ? $response['longitude'] : null;
            
            //Adding las parameter google maps route
            if (isset($response['latitude']) && isset($response['longitude'])) {
                $images_list[$image_key]['maps_link'] = $this->getGoogleMap($response['latitude'], $response['longitude']);
            }
        }

        return $images_list;
    }
    
    /**
     * Public function get Image Location
     * Returns an array of latitude and longitude from the Image file
     * 
     * @param string $image file path
     * @return multitype:array|boolean
     */
    private function getImageLocation($image = '')
    {
        $exif = exif_read_data($image, 0, true);

        if ($exif && isset($exif['GPS'])) {
            $gps_latitude_ref = $exif['GPS']['GPSLatitudeRef'];
            $gps_latitude = $exif['GPS']['GPSLatitude'];
            $gps_longitude_ref = $exif['GPS']['GPSLongitudeRef'];
            $gps_longitude = $exif['GPS']['GPSLongitude'];
            
            $lat_degrees = count($gps_latitude) > 0 ? $this->gpsToNumber($gps_latitude[0]) : 0;
            $lat_minutes = count($gps_latitude) > 1 ? $this->gpsToNumber($gps_latitude[1]) : 0;
            $lat_seconds = count($gps_latitude) > 2 ? $this->gpsToNumber($gps_latitude[2]) : 0;
            
            $lon_degrees = count($gps_longitude) > 0 ? $this->gpsToNumber($gps_longitude[0]) : 0;
            $lon_minutes = count($gps_longitude) > 1 ? $this->gpsToNumber($gps_longitude[1]) : 0;
            $lon_seconds = count($gps_longitude) > 2 ? $this->gpsToNumber($gps_longitude[2]) : 0;
            
            $lat_direction = ($gps_latitude_ref == 'W' or $gps_latitude_ref == 'S') ? -1 : 1;
            $lon_direction = ($gps_longitude_ref == 'W' or $gps_longitude_ref == 'S') ? -1 : 1;
            
            $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60*60)));
            $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60*60)));

            return array('latitude' => $latitude, 'longitude' => $longitude);
        } else {
            return false;
        }
    }

    /**
     * Public function get Image Location
     * Returns an array of latitude and longitude from the Image file
     * 
     * @param array $coord_part
     * @return float
     */
    private function gpsToNumber($coord_part)
    {
        $parts = explode('/', $coord_part);
        if (count($parts) <= 0)
            return 0;

        if (count($parts) == 1)
            return $parts[0];

        return floatval($parts[0]) / floatval($parts[1]);
    }

    /**
     * Example of getting a google map from 
     * @param float $lat latitude
     * @param float $long longitude
     * @param int $width width of the google map
     * @param int $height height of the google map
     * @return string
     */
    private function getGoogleMap($lat, $long, $width = 600, $height = 350) {
        return 'http://maps.google.com/?ie=UTF8&amp;hq=&amp;t=h&amp;ll=' . $lat . ',' . $long . '&amp;spn=0.016643,0.036478&amp;z=14&amp;output=embed';
    }
}
?>