<?php
namespace Edu\Cnm\Helpmehelpyou;
require_once("autoload.php");
require_once(dirname(__DIR__, 2) . "/vendor/autoload.php");
use Ramsey\Uuid\Uuid;
/**
 * Category
 *
 * This is the category for posts(concurrences) and these are pre-defined for all users.
 * This sets the "name" for categorization of types of posts to help sort them into specific, predefined categories, for example: transportation, home repair, childcare, etc.
 *
 * @author Anna Khamsamran <akhamsamran1@cnm.edu>
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @version 4.0.0
 * @package Edu\Cnm\DataDesign
 **/
class Profile implements \JsonSerializable {
	use ValidateUuid;
	/**
	 * id for this category: primary key
	 * @var Uuid $categoryId
	 **/
	private $categoryId;
	/**
	 * description of the category or name of the category
	 * @var string $categoryName
	 **/
	private $categoryName;
	/**
	 * name/description of the category this is a unique index
	 * @var string $categoryName
	 **/

	/**
	 * constructor for this Category
	 *
	 * @param Uuid|string $newCategoryId id of this Category or null if new Category
	 * @param string $newCategoryName the Name of this Category
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds(ie strings too long, integers negative)
	 * @throws \TypeError if data types violates type hints
	 * @throws \Exception if some other exception occurs
	 * @Documentation https://php.net/manual/en/language.oop5.decon.php (constructors and destructors)
	 **/
	public function __construct($newCategoryId, string $newCategoryName) {
		try {
			$this->setCategoryId($newCategoryId);
			$this->setCategoryName($newCategoryName);
		}
			//determine what exception type was thrown
		catch(\InvalidArgumentException | \RangeException | \TypeError | \Exception $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
	}
	/**
	 * accessor method for category id
	 *
	 * @return Uuid value of the category id
	 **/
	public function getCategoryId() : Uuid {
		return($this->categoryId);
	}
	/**
	 * mutator method for category id
	 *
	 * @param Uuid|string $newCategoryId
	 * @throws \RangeException if $newCategoryId is not positive
	 * @throws \TypeError if $newCategoryId is not a uuid or string
	 **/
	public function setCategoryId($newCategoryId) : void {
		try {
			$uuid = self::validateUuid($newCategoryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			$exceptionType = get_class($exception);
			throw(new $exceptionType($exception->getMessage(), 0, $exception));
		}
		//convert and store the category id
		$this->categoryId = $uuid;
	}
	/**
	 * accessor method for category name
	 * @return string value of category name
	 **/
	public function getCategoryName() : string {
		return($this->categoryName);
	}
	/**
	 * mutator method for category name
	 *
	 * @param string $newCategoryName new value of category name
	 * @throws \InvalidArgumentException if $newCategoryName is not a string or insecure
	 * @throws \RangeException if $newCategoryName is >64 characters
	 * @throws \TypeError if $newCategoryName is not a string
	 **/
	public function setCategoryName(string $newCategoryName) : void {
		//verify the category name is secure
		$newCategoryName = trim($newCategoryName);
		$newCategoryName = filter_var($newCategoryName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($newCategoryName) === true) {
			throw(new \InvalidArgumentException("category name is empty or insecure"));
		}
		//verify the category name will fit in the database
		if(strlen($newCategoryName) > 64) {
			throw(new \RangeException("category name too long"));
		}
		//store the category name
		$this->categoryName = $newCategoryName;
	}






}