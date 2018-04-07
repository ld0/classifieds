#!/bin/bash

# Author: ld0
# Script to copy post from temporary database to permanent one, by the link from the temporary database.
# usage: ./confirmation $link 

if [ $# -ne 1 ]; then
	echo "Supply with link to confirm."
	exit
fi

# CD into the necessary directory. 
move () {
	cd /home/ichi2016/www/www.unoclassifieds.com/includes/db/
}

# Call the function to CD into the necessary directory.
move

# Get info from post to copy.

title=$(sqlite3 unoclasstemp.db "SELECT title FROM post WHERE link LIKE $1;")
# echo $title
descr=$(sqlite3 unoclasstemp.db "SELECT descr FROM post WHERE link LIKE $1;")
# echo $descr
datep=$(sqlite3 unoclasstemp.db "SELECT date FROM post WHERE link LIKE $1;")
# echo $datep
numreports=$(sqlite3 unoclasstemp.db "SELECT numreports FROM post WHERE link LIKE $1;") 
# echo $numreports
category=$(sqlite3 unoclasstemp.db "SELECT category FROM post WHERE link LIKE $1;") 
# echo $category
email=$(sqlite3 unoclasstemp.db "SELECT email FROM post WHERE link LIKE $1;")
# echo $email
price=$(sqlite3 unoclasstemp.db "SELECT price FROM post WHERE link LIKE $1;")
# echo $price

# Now put in the permanent database

sqlite3 unoclass.db "INSERT INTO post (title,descr,date,numreports,category,email,price) VALUES('$title','$descr','$datep','$numreports','$category','$email','$price');"

echo "Script completed"



