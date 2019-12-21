<?php declare(strict_types=1);

class Response
{
	private $code;

	private $headers;

	private $body;

	public function __construct(int $code, array $headers, string $body)
	{
		$this->code = $code;
		$this->headers = $headers;
		$this->body = $body;
	}

	public static function ok(array $headers = [], string $body = '')
	{
		return new self(200, $headers, $body);
	}

	public static function error(int $code, $message)
	{
		$self = new self($code, [], '');
		$self->setData($message);

		return $self;
	}

	public function send()
	{
		if (!headers_sent()) {
			http_response_code($this->code);
			foreach ($this->headers as $name => $value) {
				if (is_string($name)) {
					$header = $name . ': ' . $value;
				} else {
					$header = $value;
				}
				header($header, true);
			}
			echo $this->body;
		} else {
			throw new \Exception('Ошибка при отправке ответа');
		}

		return 0;
	}

	public function addHeader($name, $value, $replace = true): Response
	{
		if ($replace || !array_key_exists($name, $this->headers)) {
			$this->headers[$name] = $value;
		}

		return $this;
	}

	public function setData($data): Response
	{
		$this->body = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

		return $this;
	}

	// todo

}