<?php
namespace Edu\Cnm\Helpmehelpyou;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;
/**
 *
 * This is the Post class for data about concurrences includes the why (description), what(foreign key for category),
 * where(google-maps compatible lat and long), who (owner of the post) and when (calendar compatible?) it will happen.
 * @author Anna Khamsamran <akhamsamran1@cnm.edu>
 *
 **/



class Post implements \JsonSerializable {
	use ValidateUuid;



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