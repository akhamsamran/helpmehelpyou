ALTER DATABASE helpmehelpyou CHARACTER SET utf8 COLLATE utf8_unicode_ci;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS response;
DROP TABLE IF EXISTS rate;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS postCategory;

-- table for profile/users
CREATE TABLE profile (
	-- attribute for primary key
	profileId BINARY(16) NOT NULL,
	-- other attributes
	profileActivationToken CHAR(32),
	-- profile email is unique (each user must have their own email)
	profileEmail VARCHAR (100) NOT NULL,
	profileFirstName VARCHAR (50) NOT NULL,
	profileHash CHAR(128) NOT NULL,
	profileLastName VARCHAR (50) NOT NULL,
	profileSalt CHAR(64) NOT NULL,
	profileUserName VARCHAR (100) NOT NULL,
	UNIQUE (profileEmail),
	INDEX (profileEmail),
	PRIMARY KEY (profileId)
);

-- table for posts
CREATE TABLE post(
	-- primary key
	postID BINARY(16) NOT NULL,
	-- other attributes
	postContent VARCHAR(1000) NOT NULL,
	postTitle VARCHAR(128) NOT NULL,
		-- foreign key
	postProfileID BINARY(16) NOT NULL,
	INDEX (postProfileId),
	FOREIGN KEY (postProfileId) REFERENCES profile(profileId),
	PRIMARY KEY (postId)
);

-- table for categories (these are the tags to classify the type of posts)
CREATE TABLE category(
	-- primary key
	categoryId INT AUTO_INCREMENT NOT NULL ,
	category VARCHAR (30) NOT NULL,
	PRIMARY KEY (categoryId)
);

-- junction/join/index table for posts to category (there can be more than one category per post and more than one post per category)
CREATE TABLE postCategory(
	-- both these foreign keys make 1 primary key
	postId BINARY(16) NOT NULL,
	profileId BINARY(16) NOT NULL,
	PRIMARY KEY (postId, categoryId),
	FOREIGN KEY (postId) REFERENCES post(postId),
	FOREIGN KEY (categoryId) REFERENCES category(categoryId)
);