<?php
namespace Edu\Cnm\Helpmehelpyou\Test;
use Edu\Cnm\Helpmehelpyou\{Category};
//grab the class under scrutiny: Category
require_once(dirname(__DIR__) . "/autoload.php");
//grab the uuid generator
require_once(dirname(__DIR__, 2) . "/lib/uuid.php");
/**
 * Full PHPUnit text for the Category class. It is complete
 * because *ALL* mySQL/PDO enabled methods are tested for both
 * invalid and valid inputs.
 *
 * @see Category
 * @author Dylan McDonald <dmcdonald21@cnm.edu>
 * @author Anna Khamsamran <akhamsamran1@cnm.edu>
 **/
class CategoryTest extends Helpmehelpyou {

	 /**
	 * name of the Category
	 * @var string $VALID_CATEGORYNAME
	 **/
	protected $VALID_CATEGORYNAME = "PHPUnit test passing";
	/**
	 * name of the updated Category
	 * @var string $VALID_CATEGORYNAME2
	 **/
	protected $VALID_CATEGORYNAME2 = "PHPUnit test still passing";

	/**
	 * test inserting a valid Category and verify that the actual mySQL data matches
	 **/
	public function testInsertValidCategory() : void {
		// count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("category");
		// create a new Category and insert to into mySQL
		$categoryId = generateUuidV4();
		$category = new Category($categoryId, $this->VALID_CATEGORYNAME);
		$category->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$pdoCategory = Category::getCategoryByCategoryId($this->getPDO(), $categoryId);
		$this->assertEquals($pdoCategory->getCategoryId(), $categoryId);
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertEquals($pdoCategory->getCategoryName(), $this->VALID_CATEGORYNAME);
	}
	/**
	 * test inserting a Category, editing it, and then updating it
	 **/
	public function testUpdateValidCategory() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("category");
		// create a new Category and insert to into mySQL
		$categoryId = generateUuidV4();
		$category = new Category($categoryId, $this->VALID_CATEGORYNAME);
		$category->insert($this->getPDO());
		//edit the Category and update it in mySQL
		$category->setCategoryName($this->VALID_CATEGORYNAME2);
		$category->update($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$pdoCategory = Category::getCategoryByCategoryId($this->getPDO(), $category->getCategoryId());
		$this->assertEquals($pdoCategory->getCategoryId(), $categoryId);
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("category"));
		$this->assertEquals($pdoCategory->getCategoryName(), $this->VALID_CATEGORYNAME2);
	}
	/**
	 * test creating a Category and then deleting it
	 **/
	public function testDeleteValidCategory() : void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("category");
		// create a new Category and insert to into mySQL
		$categoryId = generateUuidV4();
		$category = new Category($categoryId, $this->VALID_CATEGORYNAME);
		$category->insert($this->getPDO());
		//delete the Category from mySQL
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$category->delete($this->getPDO());
		//grab the data from mySQL and enforce the Category does not exist
		$pdoCategory = Category::getCategoryByCategoryId($this->getPDO(), $category->getCategoryId());
		$this->assertNull($pdoCategory);
		$this->assertEquals($numRows, $this->getConnection()->getRowCount("category"));
	}
	/**
	 * test grabbing a Category that does not exist
	 **/
	public function testGetInvalidCategoryByCategoryId() : void {
		//grab a category id that exceeds the maximum allowable category id
		$category = Category::getCategoryByCategoryId($this->getPDO(), generateUuidV4());
		$this->assertNull($category);
	}

	/**
	 * test grabbing a Category by category name
	 **/
	public function testGetValidCategoryByCategoryName() : void {
		//count the number of rows and save for later
		$numRows = $this->getConnection()->getRowCount("category");
		// create a new Category and insert to into mySQL
		$categoryId = generateUuidV4();
		$category = new Category($categoryId, $this->VALID_CATEGORYNAME);
		$category->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$results = Category::getCategoryByCategoryName($this->getPDO(), $category->getCategoryName());
		$this->assertEquals($numRows + 1, $this->getConnection()->getRowCount("category"));
		$this->assertCount(1, $results);
		//enforce no other objects are bleeding into the test
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Helpmehelpyou\Category", $results);
		//grab the result from the array and validate it
		$pdoCategory = $results[0];
		$this->assertEquals($pdoCategory->getCategoryId(), $categoryId);
		$this->assertEquals($pdoCategory->getCategoryName(), $this->VALID_CATEGORYNAME);
	}
	/**
	 * test grabbing a Category by name that does not exist
	 **/
	public function testGetInvalidCategoryByCategoryName() : void {
		//grab a category by name that does not exist
		$category = Category::getCategoryByCategoryName($this->getPDO(), "purple peanuts");
		$this->assertCount(0, $category);
	}
	/**
	 * test grabbing all Categories
	 **/
	public function testGetAllValidCategories(): void {
		//count the number of rows and save it for later
		$numRows = $this->getConnection()->getRowCount("category");
		// create a new Category and insert to into mySQL
		$categoryId = generateUuidV4();
		$category = new Category($categoryId, $this->VALID_CATEGORYNAME);
		$category->insert($this->getPDO());
		//grab the data from mySQL and enforce the fields match our expectations
		$results = Category::getAllCategories($this->getPDO());
		$this->assertEquals($numRows +1, $this->getConnection()->getRowCount("category"));
		$this->assertCount(1, $results);
		$this->assertContainsOnlyInstancesOf("Edu\\Cnm\\Helpmehelpyou\\Category", $results);
		//grab the result from the array and validate it
		$pdoCategory = $results[0];
		$this->assertEquals($pdoCategory->getCategoryId(), $categoryId);
		$this->assertEquals($pdoCategory->getCategoryName(), $this->VALID_CATEGORYNAME);
	}
}
?>