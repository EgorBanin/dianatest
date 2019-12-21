<?php declare(strict_types=1);

class App {

	private $routes;

	private $handlersDir;

	private $container;

	public function __construct(array $routes, string $handlersDir, Container $container)
	{
		$this->routes = $routes;
		$this->handlersDir = $handlersDir;
		$this->container = $container;
	}

	public function run(Request $rq): int
	{
		[$hanlderName, $params] = $this->route($rq->getLocator());
		if (empty($hanlderName)) {
			return Response::error(404, 'Not found')->send();
		}

		try {
			$handler = load($hanlderName, $this->handlersDir);
		} catch(\Throwable $e) {
			return Response::error(404, 'Not found')->send();
		}

		$rq->addPathParams($params);
		try {
			$rs = $handler($this, $rq, Response::ok());
		} catch(\Throwable $e) {
			return Response::error(500, $e->getMessage())->send();
		}

		return $rs->send();
	}

	public function getContainer(): Container
	{
		return $this->container;
	}

	/**
	 * @return array [$hanlderName, $params]
	 */
	private function route(string $locator): array
	{
		$params = [];
		$pattern = arr_usearch($this->routes, function ($pattern) use ($locator, &$params) {
			$matches = [];
			if (preg_match($pattern, $locator, $matches) === 1) {
				foreach ($matches as $name => $value) {
					if (is_string($name)) {
						$params[$name] = $value;
					}
				}
				return $pattern;
			}
		});
		if ($pattern !== false) {
			$handlerName = str_template($this->routes[$pattern], $params);
			return [$handlerName, $params];
		}

		return [null, []];
	}

}