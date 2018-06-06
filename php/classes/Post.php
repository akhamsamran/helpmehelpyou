<?php
/**
 * Created by PhpStorm.
 * User: annakhamsamran
 * Date: 6/6/18
 * Time: 11:38 AM
 */

namespace Edu\Cnm\Helpmehelpyou;


class Post {

}


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