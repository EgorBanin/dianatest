drop database if exists `dianatest`;

create database `dianatest`
default character set = 'utf8'
default collate = 'utf8_general_ci';

create user 'dianatest'@'localhost'
identified by 'passw0rd';

grant select, insert, update, delete, lock tables
on `dianatest`.*
to 'dianatest'@'localhost';