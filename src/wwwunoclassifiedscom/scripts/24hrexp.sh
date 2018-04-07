#!/bin/bash

# Author: ld0
# Purpose of this script is to delete a record from the temporary database once its expiration period of 24 hrs has been reached. 
# Usage: Put into cron and schedule it every hour.

# CD into the directory for the database. 
moveToDB () {
	cd /home/ichi2016/www/www.unoclassifieds.com/includes/db/
}

# CD into the directory for images. 
moveToImages () { 
	cd /home/ichi2016/www/www.unoclassifieds.com/includes/images/temp/
}

# Call the function to CD into the necessary directory.
moveToDB

####

# Get every database entry, and process line by line. 
# The format is postDate|link
# Where postDate is the full date of posting, 
# and link is the unique identifier. 
sqlite3 unoclasstemp.db "SELECT date, link FROM post;" | while read -r line ; do
	# Use "cut" with delimiters to get the date 
	postDate=$(echo $line | cut -d '|' -f1)
	# Use "cut" with delimiters to get the link
	link=$(echo $line | cut -d '|' -f2)

	# Trim the post date to get just the time.
	postTime=$(echo $postDate | tail -c 9)
	# echo "Post time $postTime"

	# Trim again to get just the hour.
	postHour=$(echo $postTime | cut -c 1-2)
	# echo "Post hour $postHour"

	# Trim the date to get just the day.
	postDay=$(echo $postDate | cut -c 9-10)
	# echo "Post day $postDay"

	#####

	# Get current system hour.
	nowHour=`date +%H`
	# echo "Now hour $nowHour"

	# Get current system day of the week
	nowDay=`date +%W`
	# echo "Now day $nowDay"

	#####

	# If the day is NOT the same but the hour is, delete
	if [ $nowDay != $postDay ] && [ $nowHour = $postHour ]; then
		# echo "Post is scheduled for deletion."
		sqlite3 unoclasstemp.db "DELETE FROM post WHERE link LIKE $link;"
		# echo "Post is deleted."
		# Delete its accompanying photo from disk, if it exists. 
		moveToImages
		# If the image exists, remove it. 
		if [ -f $j ] ; then
			rm -f $j
		fi
		# Go back.
		moveToDB
		
	fi

done
