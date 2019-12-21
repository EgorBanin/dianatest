<?php declare(strict_types=1);

return function(App $app, Request $rq, Response $rs)
{

	$id = $rq->getPathParam('id');
	$fields = [];
	$name = trim($rq->getBodyParam('name', ''));
	if (!empty($name)) {
		$fields['name'] = $name;
	}
	$isActive = $rq->getBodyParam('isActive');
	if ($isActive !== null) {
		$fields['isActive'] = $isActive;
	}
	/** @var \Mysql\Client $db */
	$db = $app->getContainer()->get('db');
	if (!empty($fields)) {
		$affectedRows = $db->table('customers')->set($id, $fields);
	} else {
		return Response::error(404, ["Нечего обновлять"]);
	}

	if ($affectedRows === 0) { // fixme
		return Response::error(404, ["Кастомер $id не найден"]);
	}

	return $rs->setData('ok');

};