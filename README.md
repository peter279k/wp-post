# wp-post

## Introduction
This helper class helps you accessing WordPress functions to post the feed easily.

You can also check out the ```main.php``` and the PHP file which is in the ```src``` folder to know more details.

## The files introduction

You can see the ```main.php``` to know more details about using this classes.

- ```main.php```: The main functionality to call the calsses from ```src``` folder.
- ```Valid.php```: The class is to validate the post id and image id.
- ```Post.php``` is to post the feed via WordPress functions.
- ```UploadImg.php```: The class is to upload the images via WordPress functions.

## Usage

- using ssh to login your VPS or shared hosting server.
- ```cd /path/to/your-wodpress-root-installation.```
- using the ```git clone https://github.com/peter279k/wp-post``` to clone this repo.
- In ```main.php```, modify the title and content on line 27.
- using the ```php main.php``` to test the posting feed and uploading images.

