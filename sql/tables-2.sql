ALTER DATABASE helpmehelpyou CHARACTER SET utf8 COLLATE utf8_unicode_ci;
DROP TABLE IF EXISTS category;
DROP TABLE IF EXISTS post;
DROP TABLE IF EXISTS profile;



-- table for categories (these are the tags to classify the type of posts)
CREATE TABLE category(
	-- primary key
	categoryId INT AUTO_INCREMENT NOT NULL ,
	categoryName VARCHAR (30) NOT NULL,
	PRIMARY KEY (categoryId)
);

-- table for post (which, who, what, where, why)
CREATE TABLE post(
	-- which: attribute for primary key
	postId BINARY(16) NOT NULL,
	-- why: description
	postDescription VARCHAR(1000) NOT NULL,
	-- what: attribute for foreign key for category
	postCategoryId BINARY(16) NOT NULL,
	-- where: this must be compatible with google maps
	postLat DECIMAL(12,9) NOT NULL,
	postLocation VARCHAR(100) NOT NULL,
	postLong DECIMAL(12,9) NOT NULL,
	-- who: attribute for foreign key for profile
	postProfileId BINARY(16) NOT NULL,
	-- when: this can be compared to a calendar, data type must be compatible
	postTime DATETIME NOT NULL,
	-- set pk and fk
	PRIMARY KEY (postId),
	FOREIGN KEY (postProfileId) REFERENCES profile(profileId),
	FOREIGN KEY (postCategoryId) REFERENCES category(categoryId)
);

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
	profilePrivilege TINYINT UNSIGNED,
	profileSalt CHAR(64) NOT NULL,
	profileUsername VARCHAR (100) NOT NULL,
	UNIQUE (profileEmail),
	INDEX (profileEmail),
	PRIMARY KEY (profileId)
);



