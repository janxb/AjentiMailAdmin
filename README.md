# AjentiMailAdmin
This PHP application allows your mail users to manage
their mail settings by themselves. The following features are available (based on configuration):

- Edit Mail forwarders (add/remove addresses)
- Change Mail Account Password
- Password-Forgotten (Send Password to Forwarders)

## Requirements
You have to create a new SSH user who has privileges to execute
the files in the _ssh_-folder as root (via _sudo_) and (important!)
without having sudo ask for a password.

Example sudoers entry: _{USERNAME} ALL=(ALL:ALL) NOPASSWD:/var/www/ajentiMailAdmin/ssh/*_


You also need a PHP enabled webserver to execute the scripts.. ;)

##Config Properties
```
// Path to mail.json file from Ajenti
"mailconfig": "/etc/ajenti/mail.json",

// SSH host for API connection
"ssh_host": "localhost:22",

// API ssh user
"ssh_user": "root",

// API ssh password
"ssh_pass": "YOURSSHPASSWORD",

// Minimal Password length
"password_minlength": 5,

// Sender address for password mails
"passwordmail_from": "postmaster@example.org",

// Every password mail is also sent to this address
"passwordmail_bcc": null,

// Subject of password mail
"passwordmail_subject": "Your Mail Password",

// Content of password mail
// Placeholders are {{email}} and {{password}}
"passwordmail_content": "Your Password: {{password}}",

// If you forward every mail to a second account (archiving), you can protect it here, so that it cant be deleted.
"protected_forwarders": []
```