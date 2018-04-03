ALTER DATABASE helpmehelpyou CHARACTER SET utf8 COLLATE utf8_unicode_ci;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS response;
DROP TABLE IF EXISTS rate;

-- table for profile/users
CREATE TABLE profile (
	-- attribute for primary key
	profileId BINARY(16) PRIMARY KEY,
	-- other attributes
	profileActivationToken CHAR(32),
	-- profile email is unique (each user must have their own email)
	profileEmail VARCHAR (100) UNIQUE NOT NULL,
	profileFirstName VARCHAR (50) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileLastName VARCHAR (50) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	profileUserName VARCHAR (100) NOT NULL
);

-- table for posts
CREATE TABLE post(
	-- primary key
	postID BINARY(16) PRIMARY KEY,
	postProfileID BINARY(16) NOT NULL,

)