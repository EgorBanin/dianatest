<?php declare(strict_types=1);

return  [
	'~^post /(?<dir>[^/]+)$~' => '{dir}/create.php',
	'~^get /(?<dir>[^/]+)$~' => '{dir}/index.php',
	'~^get /(?<dir>[^/]+)/(?<id>[^/]+)$~' => '{dir}/read.php',
	'~^put /(?<dir>[^/]+)/(?<id>[^/]+)$~' => '{dir}/update.php',
	'~^delete /(?<dir>[^/]+)/(?<id>[^/]+)$~' => '{dir}/delete.php',
];