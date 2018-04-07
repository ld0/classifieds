#!/bin/bash

#Author: ld0
# Purpose of this script is to delete a record from the permanent database once its expiration period of 30 days has been reached. 
# Usage: Put into cron and schedule it every day.

# CD into the necessary directory. 
move () {
	cd /home/ichi2016/www/www.unoclassifieds.com/includes/db/
}

# Call the function to CD into the necessary directory.
move

####

# Get every database entry, and process line by line. 
# The format is postDate|link
# Where postDate is the full date of posting, 
# and link is the unique identifier. 

sqlite3 unoclass.db "SELECT date, link FROM post;" | while read -r line ; do
	# Use "cut" with delimiters to get the date 
	postDate=$(echo $line | cut -d '|' -f1)
	# Use "cut" with delimiters to get the link
	link=$(echo $line | cut -d '|' -f2)

	days=$(( ( $(date +%s) - $(date -d "$postDate" +%s) ) /(24 * 60 * 60 ) ))
	echo $days
	# If 30 days or more have passed
	if [ $days -ge 30 ] ; then 
		echo "Post is scheduled for deletion."
		email=$(sqlite3 unoclass.db "SELECT email FROM post WHERE link LIKE $link;")
		# echo "Email $email"
		printf "To: $email\nFrom: unoclassifieds@gmail.com\nSubject: Your posting has expired.\n\nYour posting has expired on UNO Classifieds. Thank you for posting." | msmtp $email
		sqlite3 unoclass.db "DELETE FROM post WHERE link LIKE $link;"
		echo "Post is deleted."
	fi
done
