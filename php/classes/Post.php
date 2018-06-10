<?php
namespace Edu\Cnm\Helpmehelpyou;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;
/**
 *
 * This is the Post class for data about concurrences includes the why (description), what(foreign key for category),
 * where(google-maps compatible lat and long), who (owner of the post) and when (calendar compatible) it will happen.
 * @author Anna Khamsamran <akhamsamran1@cnm.edu>
 *
 **/



class Post implements \JsonSerializable {
	use ValidateUuid;


	/**
	 * id for this Post; this is the primary key
	 * @var Uuid $postId
	 **/
	private $postId;
	/**
	 * street address for this post
	 * @var string $postAddress
	 **/
	private $postAddress;
	/**
	 * category for this post
	 * @var Uuid $postCategory
	 **/
	private $postCategory;
	/**
	 * description for this post
	 * @var string $postDescription
	 **/
	private $postDescription;
	/**
	 * end date of this post(the date the activity ends)
	 * @var date $postEndDate
	 **/
	private $postEndDate;
	/**
	 * end time of this post
	 * @var \DateTime $postEndTime
	 **/
	private $postEndTime;
	/**
	 * latitude for the location of the post
	 * @var float $postLatitude
	 **/
	private $postLat;
	/**
	 * the location (descriptive) of the post
	 * @var string $postLocation
	 **/
	private $postLocation;
	/**
	 * longitude for the location of this post
	 * @var float $postLongitude
	 **/
	private $postLong;
	/**
	 * the profile of the owner of the post
	 * @var Uuid $postProfileId
	 **/
	private $postProfileId;
	/**
	 * the start date of the post(when does the activity actually happen?)
	 * @var \DateTime $postStartDate
	 **/
	private $postStartDate;
	/**
	 * post start time
	 * @var \DateTime $postStartTime
	 **/
	private $postStartTime;
	/**
	 * post time zone (in which time zone is this happening?)
	 * @var \DateTimeZone $postTimeZone
	 **/
	private $postTimeZone;

	/**
	 * the constructor for post class
	 *
	 * @param UUID|string $newPostId id of this Post or null if a new Post
	 * @param string $newPostAddress of this Post
	 * @param UUID|string $newPostCategory for this Post
	 * @param string $newPostDescription of this Post
	 * @param \DateTime $newPostEndDate for this Post
	 * @param \DateTime $newPostEndTime for this Post
	 * @param float $newPostLat for this Post
	 * @param string $newPostLocation for this Post
	 * @param float $newPostLong for this Post
	 * @param UUID|string $newPostProfileId the owner of this Post
	 * @param \DateTime $newPostStartDate for this Post
	 * @param \DateTime $newPostStartTime for this Post
	 * @param \DateTimeZone $newPostTimeZone for this Post
	 **/

	public function __construct($newPostId, $newPostDescription) {
	}


}


//CREATE TABLE post(
//	-- which: attribute for primary key
//									postId BINARY(16) NOT NULL,
//	-- why: description
//	postDescription VARCHAR(1000) NOT NULL,
//	-- what: attribute for foreign key for category
//														postCategoryId BINARY(16) NOT NULL,
//	-- when End: google calendar compatible
//	postEndDate DATE NOT NULL,
//	postEndTime DATETIME NOT NULL,
//	-- where: this must be compatible with google maps
//	postLat DECIMAL(12,9) NOT NULL,
//	postLocation VARCHAR(100) NOT NULL,
//	postLong DECIMAL(12,9) NOT NULL,
//	-- who: attribute for foreign key for profile
//													  postProfileId BINARY(16) NOT NULL,
//	-- when Start: Google calendar compatible
//	postStartDate DATE NOT NULL,
//	postStartTime DATETIME NOT NULL,
//	postTimeZone VARCHAR(12) NOT NULL,
//	-- set pk and fk
//	PRIMARY KEY (postId),
//	FOREIGN KEY (postProfileId) REFERENCES profile(profileId),
//	FOREIGN KEY (postCategoryId) REFERENCES category(categoryId)
//);