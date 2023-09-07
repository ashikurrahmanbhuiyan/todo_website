create database notes;
use notes;
create table note(
    sno int not null auto_increment,
    title varchar(255),
    description Text,
    tstamp datetime default current_timestamp,
    primary key(sno),
);