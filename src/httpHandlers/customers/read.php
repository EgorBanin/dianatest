<?php declare(strict_types=1);

return function(App $app, Request $rq, Response $rs)
{

	$id = $rq->getPathParam('id');
	/** @var \Mysql\Client $db */
	$db = $app->getContainer()->get('db');
	$customer = $db->table('customers')->get($id);
	if ($customer === null) {
		return Response::error(404, ["Кастомер $id не найден"]);
	}

	return $rs->setData($customer);

};