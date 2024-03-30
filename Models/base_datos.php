<?php

class Base_datos
{
	private static $host = 'localhost';
	private static $db = 'testsapp';
	private static $user = 'root';
	private static $password = '';
	private static $charset = "utf8";

	public static function connect()
	{
		try {

			$con = new PDO("mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=" . self::$charset, self::$user, self::$password);

			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

			return $con;
		} catch (PDOException $e) {
			print_r("Error de conexion: " . $e->getMessage());

			echo "Linea del error" . $e->getLine();
		}
	}
}
