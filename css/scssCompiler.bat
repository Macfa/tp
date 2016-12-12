@echo off
start winscp.exe mktraum /keepuptodate D:\_WORK\tplanit\git\chy /home/www/tplanit/develop/_chy -transfer="automatic" -filemask="sftp-config.json; .git/"  -delete
:RETURN
node-sass scss/ -o compiled/ & node-sass -w scss/ -o compiled/ || goto RETURN
