# Lendesk Coding Challenge

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

**Adding an additional directory to read:**
```
php app.php --dir="newdirectory/to-read"
```

**Adding an optional name for the CSV File:**
```
php app.php --name="new_file_name.csv"
```

**Adding both parameters:**
```
php app.php --dir="newdirectory/to-read" --name="new_file_name.csv"
```

## Files

All files are located in the folder called exports

# Code Explanation

Most of the functions have their own comments, but here is a brief explanation about the classes and functions used in this project. 

The main reason the project is split into classes is that it makes the project more scalable and easy to expand. I decided not to use any library available in composer to demonstrate that I can generate the code in a simple way.

### File app.php 

Is the one who calls all classes in the system, basically, this file set up the main variables to be used, receive the optional parameters given by console and process the info to later generates the CSV file.

### Class Export

This class is responsible to read the folders, parse this info into an array, and also export the processed array into a CSV file.

### Class Images

This class receive the array given by the class export and get the image location using the function exif_read_data native from PHP. After the longitude and latitude is recover from the image, the function added to the array,  an additional function retrieves the google map link in the array.





