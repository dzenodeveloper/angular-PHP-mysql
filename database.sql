create database company;
use company;

create table people (
  username  int(11) auto_increment primary key,
  Password varchar(30) not null,
  Ime varchar(30) not null,
  Prezime varchar(30) not null
  Adresa varchar(30) not null
  PostanskiBR varchar(30) not null
  Grad varchar(30) not null
);
