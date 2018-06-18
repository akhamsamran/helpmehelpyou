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
	use ValidateDate;


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
	 * @var Uuid $postCategoryId
	 **/
	private $postCategoryId;
	/**
	 * description for this post
	 * @var string $postDescription
	 **/
	private $postDescription;
	/**
	 * end time and date of this post
	 * @var \DateTime $postEnd
	 **/
	private $postEnd;
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
	 * post start time and date
	 * @var \DateTime $postStart
	 **/
	private $postStart;
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
	 * @param UUID|string $newPostCategoryId for this Post
	 * @param string $newPostDescription of this Post
	 * @param \DateTime $newPostEnd for this Post
	 * @param float $newPostLat for this Post
	 * @param string $newPostLocation for this Post
	 * @param float $newPostLong for this Post
	 * @param UUID|string $newPostProfileId the owner of this Post
	 * @param \DateTime $newPostStart for this Post
	 * @param \DateTimeZone $newPostTimeZone for this Post
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php
	 **/

	public function __construct($newPostId, string $newPostAddress, $newPostCategoryId, string $newPostDescription, $newPostEnd = null, float $newPostLat, string $newPostLocation, float $newPostLong, $newPostProfileId, $newPostStart = null, $newPostTimeZone {
		try {
			$this->setPostId($newPostId);
			$this->setPostAddress($newPostAddress);
			$this->setPostCategoryId($newPostCategoryId);
			$this->setPostDescription($newPostDescription);
			$this->setPostEnd($newPostEnd);
			$this->setPostLat($newPostLat);
			$this->setPostLocation($newPostLocation);
			$this->setPostLong($newPostLong);
			$this->setPostProfileId($newPostProfileId);
			$this->setPostStart($newPostStart);
			$this->setPostTimeZone($newPostTimeZone);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for post id
	 *
	 * @return Uuid value of post id
	 **/
	public function getPostId() : Uuid {
		return($this->postId);
	}
	/**
	 * mutator method for post id
	 *
	 * @param Uuid/string $newPostId new value of post id
	 * @throws \RangeException if $newPostId is not positive
	 * @throws \TypeError if $newPostId is not a uuid
	 **/
	public function setPostId( $newPostId) : void {
		try {
			$uuid = self::validateUuid($newPostId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the post id
		$this->postId = $uuid;
	}

	/** accessor method for post address
	 *
	 * @return string value of post address
	 **/
	public function getPostAddress(): string {
		return ($this->postAddress);
	}
	/** mutator method for the post address
	 *
	 * @param string $newPostAddress new value of post address
	 * @throws \InvalidArgumentException if $newPostAddress is not a string or insecure
	 * @throws \RangeException if $newPostAddress is > 100 characters
	 * @throws \TypeError if $newPostAddress is not a string
	 **/
	public function setPostAddress(string $newPostAddress): void {
// verify the address content is secure
		$newPostAddress = trim($newPostAddress);
		$newPostAddress = filter_var($newPostAddress, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPostAddress) === true) {
			throw(new \InvalidArgumentException("address content is empty or insecure"));
		}
		// verify the address will fit in the database
		if(strlen($newPostAddress) > 140) {
			throw(new \RangeException("address too large"));
		}
		// store the tweet content
		$this->postAddress = $newPostAddress;
	}
	/**
	 * accessor method for the post categoryId
	 *
	 * @return Uuid value of the category id for this post
	 **/
	public function getPostCategoryId(): Uuid {
		return ($this->postCategoryId);
	}
	/**
	 * mutator method for the post category id
	 *
	 * @param Uuid/string $newPostCategoryId for the value of the new post category
	 * @throws \RangeException if the post category is not positive
	 * @throws \TypeError if the post category Id is not a uuid
	 **/
	public function setPostCategoryId( $newPostCategoryId) : void {
		try {
			$uuid = self::validateUuid($newPostCategoryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the post category id
		$this->postCategoryId = $uuid;
	}

	/**
	 * accessor method for post description
	 *
	 * @return string value of the post description
	 **/
	public function getPostDescription(): string {
		return ($this->postDescription);
	}
	/**
	 * mutator method for post description
	 * @param string $newPostDescription new value for the description
	 * @throws \InvalidArgumentException if $newPostDescription is not a string or insecure
	 * @throws \RangeException if $newPostDescription is > 1000 characters
	 * @throws \TypeError if $newPostDescription is not a string
	 **/
	public function setPostDescription(string $newPostDescription): void {
// verify the description content is secure
		$newPostDescription = trim($newPostDescription);
		$newPostDescription = filter_var($newPostDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPostDescription) === true) {
			throw(new \InvalidArgumentException("description content is empty or insecure"));
		}
		// verify the address will fit in the database
		if(strlen($newPostDescription) > 1000) {
			throw(new \RangeException("description too large"));
		}
		// store the description content
		$this->postDescription= $newPostDescription;
	}

	/**
	 * accessor method for post end
	 * @returns \DateTime $postEnd the time and date the activity will end
	 **/
	public function getPostEnd(): \DateTime {
		return ($this->postEnd);
	}
	/**
	 * mutator method for the post end
	 *
	 * @param \DateTime $newPostEnd new value for the post end
	 * @throws \InvalidArgumentException if $newPostEnd is not a valid object or string
	 * @throws \RangeException if $newPostEnd is a date that does not exist
	 **/
	public function setPostEnd($newPostEnd = null) : void {

		// store the post end using the ValidateDate trait
		try {
			$newPostEnd = self::validateDateTime($newPostEnd);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->postEnd = $newPostEnd;
	}









	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() : array {
		$fields = get_object_vars($this);
		$fields["postId"] = $this->postId->toString();
		return($fields);
	}
}


