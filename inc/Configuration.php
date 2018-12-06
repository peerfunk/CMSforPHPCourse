<?php
namespace Settings;
class Configuration{
	private static $default_view='welcome';
	private static $sitename='MyCMS';
	private static $dbtype='mysql';
	private static $host='localhost';
	private static $user='fh_2018_web4';
	private static $pass='fh_2018_web4';
	private static $dbName='fh_2018_web4';
	
	public static function getDefault_view() { return self::$default_view; }
	public static function getSitename() { return self::$sitename; }
	public static function getDbtype() { return self::$dbtype; }
	public static function getHost() { return self::$host; }
	public static function getUser() { return self::$user; }
	public static function getPass() { return self::$pass; }
	public static function getDbName() { return self::$dbName; }
	public static function createDB(){
		//CREATE USER 'fh_2018_web4'@'localhost' IDENTIFIED BY 'fh_2018_web4';
		//GRANT Insert,select,update,update ON fh_2018_web4.* TO 'fh_2018_web4'@'localhost';

	}
}