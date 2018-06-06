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
}