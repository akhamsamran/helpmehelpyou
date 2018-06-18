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
		// store the post content
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
	 * accessor method for post latitude
	 *
	 * @returns float $postLat value of the post latitude
	 **/
	public function getPostLat(): float {
		return ($this->postLat);
	}
	/**
	 * mutator method for post latitude
	 *
	 * @param float $newPostLat new value for the new post latitude
	 * @throws \InvalidArgumentException if $newPostLat is not a float or insecure
	 * @throws \RangeException if $newPostLat is not within -90 to 90
	 * @throws \TypeError if $newPostLat is not a float
	 **/
	public function setPostLat(float $newPostLat) : void {
		// verify the latitude exists on earth
		if(floatval($newPostLat) > 90) {
			throw(new \RangeException("post latitude is not between -90 and 90"));
		}
		if (floatval($newPostLat) < -90) {
			throw(new \RangeException("post latitude is not between -90 and 90"));
		}
		// store the latitude
		$this->postLat = $newPostLat;
	}


	/**
	 * accessor method for post location
	 *
	 * @return string value of post location
	 **/
	public function getPostLocation() : string {
		return($this->PostLocation);
	}
	/**
	 * mutator method for post location
	 *
	 * @param string $newPostLocation new value of post location
	 * @throws \InvalidArgumentException if $newPostLocation is not a string or insecure
	 * @throws \RangeException if $newPostLocation is > 200 characters
	 * @throws \TypeError if $newPostLocation is not a string
	 **/
	public function setPostLocation(string $newPostLocation) : void {
		// verify the post location is secure
		$newPostLocation = trim($newPostLocation);
		$newPostLocation = filter_var($newPostLocation, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newPostLocation) === true) {
			throw(new \InvalidArgumentException("post location is empty or insecure"));
		}
		// verify the location will fit in the database
		if(strlen($newPostLocation) > 200) {
			throw(new \RangeException("post location too large"));
		}
		// store the artist
		$this->postLocation = $newPostLocation;
	}

	/** accessor method for post longitude
	 *
	 *
	 * @return float value of post longitude
	 **/
	public function getPostLong() : float {
		return($this->PostLong);
	}
	/** mutator method for post longitude
	 *
	 * @param float $newPostLong new value of post longitude
	 * @throws \InvalidArgumentException if $newPostLong is not a float or insecure
	 * @throws \RangeException if $newPostLong is not within -180 to 180
	 * @throws \TypeError if $newPostLong is not a float
	 **/
	public function setPostLong(float $newPostLong) : void {
		// verify the latitude exists on earth
		if(floatval($newPostLong) > 180) {
			throw(new \RangeException("post longitude is not between -180 and 180"));
		}
		if (floatval($newPostLong) < -180) {
			throw(new \RangeException("post longitude is not between -180 and 180"));
		}
		// store the latitude
		$this->postLong = $newPostLong;
	}

	/**
	 * accessor method for the post profileId
	 *
	 * @return Uuid value of the profile id for the owner of this post
	 **/
	public function getPostProfileId(): Uuid {
		return ($this->postProfileId);
	}
	/**
	 * mutator method for the post profile id
	 *
	 * @param Uuid/string $newPostprofileId for the value of the new post profile
	 * @throws \RangeException if the post profile id is not positive
	 * @throws \TypeError if the post profile Id is not a uuid
	 **/
	public function setPostProfileId( $newPostProfileId) : void {
		try {
			$uuid = self::validateUuid($newPostProfileId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		// convert and store the post profile id
		$this->postProfileId = $uuid;
	}

	/**
	 * accessor method for post start date and time
	 * @returns \DateTime $postStart the time and date the activity will end
	 **/
	public function getPostStart(): \DateTime {
		return ($this->postStart);
	}
	/**
	 * mutator method for the post start date and time
	 *
	 * @param \DateTime $newPostStart new value for the post start
	 * @throws \InvalidArgumentException if $newPostStart is not a valid object or string
	 * @throws \RangeException if $newPostStart is a date that does not exist
	 **/
	public function setPostStart($newPostStart = null) : void {

		// store the post start using the ValidateDate trait
		try {
			$newPostStart = self::validateDateTime($newPostStart);
		} catch(\InvalidArgumentException | \RangeException $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		$this->postStart = $newPostStart;
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


