DROP DATABASE a2;
CREATE DATABASE a2;
USE a2;

CREATE TABLE users (
    username	VARCHAR(20)		NOT NULL Primary Key,
    password	VARCHAR(40)		NOT NULL
	avatar		
);

CREATE TABLE posts (
	postID		INT(10)			NOT NULL Primary Key auto_increment,
	postText 	VARCHAR(1000)	NOT NULL,
	username 	VARCHAR(20)		NOT NULL,
	FOREIGN KEY (username) REFERENCES users(username)
);

CREATE TABLE avatars (
	username	VARCHAR(30),
	imgOID		BYTEA
	FOREIGN KEY (username) REFERENCES users(username)
);