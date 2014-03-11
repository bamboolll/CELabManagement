CELabManagement
===============

database: database model
website: php web service

QUICK SETUP

Setup Database:
create database celabdb;
grant usage on *.* to celabroot@localhost identified by 'celabpassroot';
grant all privileges on celabdb.* to celabroot@localhost;

mysql -u celabroot -p < ./database/celabdb<version>.sql

