<?php declare(strict_types=1);

return function(App $app, Request $rq, Response $rs)
{

	$errors = [];
	$name = trim($rq->getBodyParam('name', ''));
	if (empty($name)) {
		$errors[] = 'Обязательно укажите имя';
	}

	if (!empty($errors)) {
		return Response::error(400, $errors);
	}

	/** @var \Mysql\Client $db */
	$db = $app->getContainer()->get('db');
	$id = $db->table('customers')->insert([
		'name' => $name,
		'isActive' => true,
		'ct' => time(),
	]);

	return $rs->setData([
		'id' => $id,
	]);

};