@echo off
node-sass scss/ -o compiled/ || pause 
node-sass -w scss/ -o compiled/
start winscp.exe mktraum /keepuptodate D:\_WORK\tplanit\git\hdh /tplanit-dev/_hdh
