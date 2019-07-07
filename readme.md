
## Lendesk Coding Challenge

This program will execute a command line application that recursively reads all of the images from the supplied directory of images, extracts their EXIF GPS data (longitude and latitude), and then writes the name of that image and any GPS coordinates it finds to a CSV file.

This documentation will include how to install it, how to run it and how to get the files.

## How to install it

Please use the next command to pull this repository to your local environment. If you don't know how to clone a remote repository check this documentation (https://www.git-tower.com/learn/git/commands/git-clone)

clone:
    ```
    git clone https://github.com/manuirrazabal/lendesk-test.git
    ```

## How run it

To run this program please open your console and run:
    ```
    php app.php
    ```

Additionally, this function accepts two optional parameters which add a new directory to read, and also a second parameter to change the name of the CSV file to export. 

Please make sure to follow this standard in order to get the proper response. 

Adding an additional directory to read:
    ```
    php app.php --dir="newdirectory/to-read"
    ```

Adding an optional name for the CSV File:
    ```
    php app.php --name="new_file_name.csv"
    ```

Adding both parameters:
    ```
    php app.php --dir="newdirectory/to-read" --name="new_file_name.csv"
    ```

## Files

All files are located in the folder called exports




