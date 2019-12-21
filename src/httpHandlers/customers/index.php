<?php declare(strict_types=1);

return function(App $app, Request $rq, Response $rs)
{

	/** @var \Mysql\Client $db */
	$db = $app->getContainer()->get('db');
	$rows = $db->table('customers')->select(['isActive' => true]);

	return $rs->setData($rows);

};