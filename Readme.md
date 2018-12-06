INSTALL:
Impport Database.sql
Configure inc/Configuration.php
CREATE USER 'fh_2018_web4'@'localhost' IDENTIFIED BY 'fh_2018_web4';
GRANT Insert,select,update,update ON fh_2018_web4.* TO 'fh_2018_web4'@'localhost';
login with user:admin, pw:admin
