<?php declare(strict_types=1);

class Request {

	private $ip;

	private $protocol;

	private $method;

	private $headers;

	private $url;

	private $queryParams;

	private $bodyParams;

	private $body;

	private $cookies;

	private $files;

	private $pathParams = [];

	public function __construct(
		?string $ip,
		?string $protocol,
		?string $method,
		array $headers,
		?string $url,
		array $queryParams,
		array $bodyParams,
		string $body,
		array $cookies,
		array $files
	)
	{
		$this->ip = $ip;
		$this->protocol = $protocol;
		$this->method = $method;
		$this->headers = $headers;
		$this->url = $url;
		$this->queryParams = $queryParams;
		$this->bodyParams = $bodyParams;
		$this->body = $body;
		$this->cookies = $cookies;
		$this->files = $files;
	}

	public static function fromGlobals(
		array $server,
		array $get,
		array $post,
		array $files,
		array $cookie,
		$phpinput
	)
	{
		$method = $server['REQUEST_METHOD'] ?? null;
		$body = file_get_contents($phpinput);
		$bodyParams = $post;
		if ($method !== 'POST' && empty($post)) { // fixme
			parse_str($body, $bodyParams);
		}
		return new self(
			$server['REMOTE_ADDR'] ?? null,
			$server['SERVER_PROTOCOL'] ?? null,
			$method,
			self::makeHeaders($server),
			$server['REQUEST_URI'] ?? null,
			$get,
			$bodyParams,
			$body,
			$cookie,
			$files
		);
	}

	public function getLocator(): string
	{
		$path = parse_url($this->url, PHP_URL_PATH);
		$method = strtolower($this->method);

		return "$method $path";
	}

	public function addPathParams(array $params)
	{
		$this->pathParams = array_merge($this->pathParams, $params);
	}

	public function getQueryParam(string $name, $default = null)
	{
		return array_key_exists($name, $this->queryParams)? $this->queryParams[$name] : $default;
	}

	public function getPathParam(string $name, $default = null)
	{
		return array_key_exists($name, $this->pathParams)? $this->pathParams[$name] : $default;
	}

	public function getBodyParam(string $name, $default = null)
	{
		return array_key_exists($name, $this->bodyParams)? $this->bodyParams[$name] : $default;
	}

	private static function makeHeaders(array $server): array
	{
		$headers = [];
		foreach ($server as $key => $value) {
			if (strpos($key, 'HTTP_') === 0) {
				$name = implode('-', array_map(function ($v) {
					return ucfirst(strtolower($v));
				}, explode('_', substr($key, 5))));
				$headers[$name] = $value;
			}
		}

		return $headers;
	}

	// todo

}