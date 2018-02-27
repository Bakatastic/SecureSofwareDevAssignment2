DROP DATABASE a2;
CREATE DATABASE a2;
\c a2;

CREATE TABLE users (
    username	VARCHAR(20)			NOT NULL Primary Key,
    password	VARCHAR(40)			NOT NULL,
	email		VARCHAR(100)		NOT NULL,
    avatar		bytea,
	bio			VARCHAR(100)
);

CREATE TABLE posts (
    postID		serial primary key,
    postText	VARCHAR(1000)		NOT NULL,
    username	VARCHAR(20)			NOT NULL,
    FOREIGN KEY (username) REFERENCES users(username)

);