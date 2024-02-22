# Project Name CSCI4140 WebInstagram by Pak Yik Ki (SID: 1155157022)

This is a readme file to provide information about the project file structure and setup configuration.

## Website Link

The project's website is hosted on Render at the following URL:
https://one155157022.onrender.com/

## Directory Structure and Functionality

- `/web` - Contains all the source code files for showing the website.
- The root directory contains the configuration of Dockerfile and other configurations for hosting the website on Render.

## System Building Procedure

- The website is built using PostgreSQL and Docker on Render. To build the website, you should add new Web Service on Render and select Docker as the image. Then, you should add new PostgreSQL configuration on Render, and then change the database configuration in db_connect.php after creating your own database.

- To set up the project in Render, you may encounter the building error during building the imagick module:

solution: Clear build cache & deploy the website multiple times until it is deployed successfully.

## Accomplishments and Bonus Request

1. (bonus) Implemented System Initialization for admin account.
2. (bonus) Implemented File type checking for photo uploading.
3. (bonus) Input validation: The system can display an error message if a user clicks on the "Upload"
   button when no file is chosen to be uploaded.
4. The system will prompt error when login is failed.
5. (bonus) Input validation: Validate login username and password using htmlspecialchars() to avoid code injection.
6. Displaying resized version of uploaded photos and linking those resized photos to the
   original photos in index page.

## Task 1 and Task 2 and Task 4 are done completely

## Task 3 is not done completely

1. Failed to implement black and white filter
