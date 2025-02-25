CREATE DATABASE IF NOT EXISTS `url`;
GRANT ALL ON `url`.* TO 'docker'@'%';
ALTER USER 'docker'@'localhost' IDENTIFIED WITH mysql_native_password BY 'secret';
ALTER USER 'docker'@'%' IDENTIFIED WITH mysql_native_password BY 'secret';
