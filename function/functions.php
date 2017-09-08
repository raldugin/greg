<?php
	/**
	 * @param string $name
	 * @param string $surname
	 * @param string $family
	 * @return string
	 */
	function getFullName($name, $surname, $family = '')
	{
		$fullname_constract = $name . " " . $surname . " " . $family . "<hr>";
		return $fullname_constract;

		// или возвращаем без переменной
		//return $name." ".$surname." ".$family."<hr>";
	}


	/**
	 * @param string $fullname
	 * @param string $stringHash
	 * @return void
	 *
	 * после выполнения изменяет $fullname в глобальной области видимости global scope (или namespase)
	 * т.к. &$fullname - это линк (&) на переменную которая лежит в глобальной области видимости
	 */
	function addHash(&$fullname, $stringHash)
	{
		$hash = md5($stringHash);
		$fullname = $fullname . " :hash=" . $hash;
		//var_dump($fullname);
	}