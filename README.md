# AjentiMailAdmin
This PHP application allows your mail users to manage
their mail settings by themselves. The following settings
can be changed with this application.

- Mail forwarders (add/remove addresses)
- Mail password

## Requirements
You have to create a new SSH user who has privileges to execute
the files in the _ssh_-folder as root (via _sudo_) and (important!)
without having sudo ask for a password.

Example sudoers entry: _{USERNAME} ALL=(ALL:ALL) NOPASSWD:/var/www/ajentiMailAdmin/ssh/*_


You also need a PHP enabled webserver to execute the scripts.. ;)