ALTER DATABASE helpmehelpyou CHARACTER SET utf8 COLLATE utf8_unicode_ci;
DROP TABLE IF EXISTS profile;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS postCategory;
DROP TABLE IF EXISTS rate;
DROP TABLE IF EXISTS response;

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

-- junction/intersection table for posts to category (there can be more than one category per post and more than one post per category)
CREATE TABLE postCategory(
	-- both these foreign keys make 1 primary key
	postCategoryPostId BINARY(16) NOT NULL,
	postCategoryCategoryId BINARY(16) NOT NULL,

	PRIMARY KEY (postCategoryPostId, postCategoryCategoryId),
	FOREIGN KEY (postCategoryPostId) REFERENCES post(postId),
	FOREIGN KEY (postCategoryCategoryId) REFERENCES category(categoryId)
);

-- table for ratings. This is a junction/intersection table for posts and profiles from a 2nd profile rating the post of a first profile.
CREATE TABLE rate(
	-- both these foreign keys make 1 primary key
	ratePostId BINARY(16) NOT NULL,
	-- this profile is the one submitting the rating
	rateProfileId BINARY(16) NOT NULL,
	rate INT(1) NOT NULL,
	PRIMARY KEY (ratePostId, rateProfileId),
	FOREIGN KEY (ratePostId) REFERENCES post(postId),
	FOREIGN KEY (rateProfileId) REFERENCES profile(profileId)
);

-- table for response. This is a response to the post
CREATE TABLE response (
	-- primary key
	responseID  BINARY(16)  NOT NULL,
	-- other
	responseContent   VARCHAR(1000) NOT NULL,
	-- foreign key
	responsePostId BINARY(16) NOT NULL,
	INDEX (responsePostId),
	FOREIGN KEY (responsePostId) REFERENCES post(postId),
	PRIMARY KEY (responseId)
);