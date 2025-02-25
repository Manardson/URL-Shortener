CREATE DATABASE IF NOT EXISTS `lesgo`;
GRANT ALL ON `lesgo`.* TO 'docker'@'%';
ALTER USER 'docker'@'localhost' IDENTIFIED WITH mysql_native_password BY 'secret';
ALTER USER 'docker'@'%' IDENTIFIED WITH mysql_native_password BY 'secret';
