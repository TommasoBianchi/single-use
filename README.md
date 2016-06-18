# Single use download script

## Demo
[https://tommasobianchi.github.io/single-use/](https://tommasobianchi.github.io/single-use/)

## Brief

The original script (by joshpangell) was written to be a very easy way for non-programmers to be able to create a secure way to share a single file, like for bands looking to give a single song to a single person, and invalidating the link once the song has been downloaded (it will work for any type of file). This is an enhanced version that requires a little longer setup but that gives the possibility to have different keys pointing at different files, a more solid approach to invalid keys after an expiration time and more options while generating keys.

## Description

This script allows you to generate a unique key to download a file. This file will only be allowed to download a fixed amount of times. This key will also have an expiration date set on it.

For instance, if you wanted to sell a song for your band. You sold the song on your website for $1, you could use this script to allow that person to download your song only one time. It would only give them a limited number of hours/days/weeks/years to claim their download.

You can also mask the name of the file being downloaded, for further protection. For example, if your song was called "greatsong.zip", you could set the download link as "Band_Awesome-Awesome_Song.zip" (it is not a good idea to leave spaces in URL titles)

## Usage

All files must be uploaded to a directory on your server. 
This directory's permissions MUST be `chmod 755` 
(Also known as) 
`User: read/write/execute`
`Group: read/execute`
`World: read/execute`

The directory called `secret` must also have the same permissions set as the parent directory. 

You will need to modify the `variables.php` file to set your file specific info and the `dbconnect.php` to setup the connection with your own database.

Once this is in place, you are ready to generate a new download key. To do this, you will need to use the password you set in the variables file. By default, that is `1234` (it is suggested to change it as soon as you setup).

Navigate to `yoursite.com/yourfolder/generate.php?pw=1234&num=3&path=/secret/file&expire=2016-06-30%2012:00:00&key_amount=20`, where pw is your password previously set, num is the number of downloads available to these keys (if you omit it that's 1 by default), path is where to find the file to download (from yourfolder), expire is the expiration date (if you omit it the system will use the EXPIRATION_DATE variable in `variables.php`) and key_amount is the number of keys to add with these settings (if you omit it that's 1 by default).

Copy the key that is generated (or download a txt file listing all newly created keys) and send it off. Voila! Done.
