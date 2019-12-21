<?php declare(strict_types=1);

// Офигенские функции из 00-х!

/**
 * Загрузка (return require $file) из директории
 * @param string $file
 * @param string $dir
 * @return mixed
 */
function load(string $file, string $dir)
{
	$baseDir = realpath($dir);
	if ($baseDir === false) {
		throw new \Exception("Директория $dir не найдена");
	}

	$path = realpath($baseDir . '/' . $file);
	if ($path === false) {
		throw new \Exception("Файл $file не найден в $dir");
	}
	$isSafe = (strpos($path, $baseDir) === 0);
	if (!$isSafe) {
		throw new \Exception("Файл $file за пределами директории $dir");
	}
	if (!is_file($path) || !is_readable($path)) {
		throw new \Exception("Файл $file не является файлом доступным для чтения");
	}

	return require $path;
}

/**
 * Пользовательский поиск по массиву
 * @param array $array
 * @param callable $func
 * @return mixed ключ найденого значения или false, если значение не найдено
 */
function arr_usearch(array $array, callable $func)
{
	$result = false;
	foreach ($array as $k => $v) {
		if (call_user_func($func, $k, $v)) {
			$result = $k;
			break;
		}
	}
	return $result;
}

/**
 * Заменить вхождения строки '{varName}' на соответствующее значение из массива
 * @param string $template
 * @param array $vars
 * @return string
 */
function str_template(string $template, array $vars): string
{
	$replaces = [];
	foreach ($vars as $name => $value) {
		$replaces['{' . $name . '}'] = $value;
	}
	return strtr($template, $replaces);
}