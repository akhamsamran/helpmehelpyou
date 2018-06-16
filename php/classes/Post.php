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
	 * @var Uuid $postCategory
	 **/
	private $postCategory;
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
	 * @param UUID|string $newPostCategory for this Post
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

	public function __construct($newPostId, $newPostAddress, $newPostCategory, string $newPostDescription, $newPostEnd = null, float $newPostLat, string $newPostLocation, float $newPostLong, $newPostProfileId, $newPostStart = null, $newPostTimeZone {
		try {
			$this->setPostId($newPostId);
			$this->setPostAddress($newPostAddress);
			$this->setPostCategory($newPostCategory);
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
	 * @throws \TypeError if $newPostId is not a uuid.e
	 **/
	public function setPostId( $newPostId) : void {
		try {
			$uuid = self::validateUuid($newPostId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}

		// convert and store the post id
		$this->PostId = $uuid;
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


