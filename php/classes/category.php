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
	/**
	 * inserts this Category into mySQL
	 *
	 * @param \PDO $pdp PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function insert(\PDO $pdo) : void {
		//create query template
		$query = "INSERT INTO category(categoryId, categoryName) VALUES(:categoryId, :categoryName)";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place-holders on the template
		$parameters = ["categoryId" => $this->categoryId->getBytes(), "categoryName" => $this->categoryName];
		$statement->execute($parameters);
	}
	/**
	 * deletes this Category from mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function delete(\PDO $pdo) : void {
		//create query template
		$query = "DELETE FROM category WHERE categoryId = :categoryId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place holder in the template
		$parameters =["categoryId" => $this->categoryId->getBytes()];
		$statement->execute($parameters);
	}
	/**
	 * updates this Category in mySQL
	 *
	 * @param \PDO $pdo PDO connection object
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError if $pdo is not a PDO connection object
	 **/
	public function update(\PDO $pdo) : void {
		//create query template
		$query = "UPDATE category SET categoryName = :categoryName WHERE categoryId = :categoryId";
		$statement = $pdo->prepare($query);
		//bind the member variables to the place-holder in the template
		$parameters = ["categoryId" => $this->categoryId->getBytes(), "categoryName" => $this->categoryName];
		$statement->execute($parameters);
	}
	/**
	 * gets the Category by categoryId
	 *
	 * @param \PDO $pdo PDO connection objct
	 * @param Uuid|string $categoryId category id to search for
	 * @return Category|null Category found or null if not found
	 * @throws \PDOException when mySQL related error occurs
	 * @throws \TypeError when a variable is not correct data type
	 **/
	public static function getCategoryByCategoryId(\PDO $pdo, $categoryId) : ?Category {
		//sanitize the string before searching
		try{
			$categoryId = self::validateUuid($categoryId);
		} catch(\InvalidArgumentException | \RangeException | \Exception | \TypeError $exception) {
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		//create query template
		$query = "SELECT categoryId, categoryName FROM category WHERE categoryId = :categoryId";
		$statement = $pdo->prepare($query);
		//bind the category id to the place holder in the template
		$parameters = ["categoryId" => $categoryId->getBytes()];
		$statement->execute($parameters);
		//grab the category from mySQL
		try {
			$category = null;
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			$row = $statement->fetch();
			if($row !== false) {
				$category = new Category($row["categoryId"], $row["categoryName"]);
			}
		} catch(\Exception $exception) {
			//if the row couldn't be converted, then rethrow it
			throw(new \PDOException($exception->getMessage(), 0, $exception));
		}
		return($category);
	}
	/**
	 * gets the category by categoryName
	 *
	 * @param |PDO $pdo PDO connection object
	 * @param string $categoryName category name to search by
	 * @return \SplFixedArray SplFixedArray of categories found
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 */
	public static function getCategoryByCategoryName(\PDO $pdo, $categoryName) : \SplFixedArray {
		//saintize the strin before searching
		$categoryName = trim($categoryName);
		$categoryName = filter_var($categoryName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
		if(empty($categoryName) === true) {
			throw(new \PDOException("not a valid name"));
		}
		// create query template
		$query = "SELECT categoryId, categoryName FROM category WHERE categoryName = :categoryName";
		$statement = $pdo->prepare($query);
		//bind the category name to the place holder in the template
		$parameters = ["categoryName" => $categoryName];
		$statement->execute($parameters);
		//build an array of categories
		$categories = new \SplFixedArray($statement->rowCount());
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$category = new Category($row["categoryId"], $row["categoryName"]);
				$categories[$categories->key()] = $category;
				$categories->next();
			} catch(\Exception $exception) {
				//if the row could not be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
		}
		return($categories);
	}
	/**
	 * gets all Categories
	 *
	 * @param \PDO $pdo PDO connection object
	 * @return \SplFixedArray SplFixedArray of Categories found or null if not fund
	 * @throws \PDOException when mySQL related errors occur
	 * @throws \TypeError when variables are not the correct data type
	 **/
	public static function getAllCategories(\PDO $pdo) : \SPLFixedArray {
		//create query template
		$query = "SELECT categoryId, categoryName FROM category";
		$statement = $pdo->prepare($query);
		$statement->execute();
		//built and array of categories
		$categories = new \SplFixedArray(($statement->rowCount()));
		$statement->setFetchMode(\PDO::FETCH_ASSOC);
		while(($row = $statement->fetch()) !== false) {
			try {
				$category= new Category ($row["categoryId"], $row["categoryName"]);
				$categories[$categories->key()] = $category;
				$categories->next();
			} catch(\Exception $exception) {
				//if the row couldn't be converted, rethrow it
				throw(new \PDOException($exception->getMessage(), 0, $exception));
			}
			return ($categories);
		}
	}
	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array result in state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		$fields["categoryId"] = $this->categoryId->toString();
		return($fields);
	}






}
?>