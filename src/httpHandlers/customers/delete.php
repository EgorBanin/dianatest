<?php declare(strict_types=1);

return function(App $app, Request $rq, Response $rs)
{

	$id = $rq->getPathParam('id');
	/** @var \Mysql\Client $db */
	$db = $app->getContainer()->get('db');
	$affectedRows = $db->table('customers')->rm($id);
	if ($affectedRows === 0) {
		return Response::error(404, ["Кастомер $id не найден"]);
	}

	return $rs->setData($affectedRows);

};