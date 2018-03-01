DROP DATABASE a2;
CREATE DATABASE a2;
\c a2;

CREATE TABLE users (
    username		VARCHAR(20)		NOT NULL Primary Key,
    password		VARCHAR(40)		NOT NULL,
	email			VARCHAR(100)	NOT NULL,
    avatar			VARCHAR(40)		NOT NULL,
	bio				VARCHAR(100),
	adminRole   	BOOLEAN			NOT NULL,
	approved		BOOLEAN			NOT NULL,
	accountLock 	BOOLEAN			NOT NULL,
	failedAttempts	INTEGER,
	activated	 	BOOLEAN			NOT NULL
);

CREATE TABLE posts (
    postID			serial primary key,
    postText		VARCHAR(1000)	NOT NULL,
    username		VARCHAR(20)		NOT NULL,
    FOREIGN KEY (username) REFERENCES users(username)

);

CREATE TABLE logs (
	logID			serial primary key,
	logText			VARCHAR(200)	NOT NULL,
	username		VARCHAR(20)		NOT NULL,
    FOREIGN KEY (username) REFERENCES users(username)
);