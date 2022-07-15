CREATE DATABASE task;
use task;
CREATE TABLE users (
	id int AUTO_INCREMENT,
    firstname VARCHAR(20),
    lastname VARCHAR(20),
    birthdate DATE,
    gender TINYINT(1),
    city varchar(12),
	PRIMARY KEY (id)
);