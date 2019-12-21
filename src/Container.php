<?php declare(strict_types=1);

class Container
{

	private $objects = [];

	public function put(string $key, $obj)
	{
		if (array_key_exists($key, $this->objects)) {
			throw new \Exception("Объект $key уже зарегистрирован в контейнере");
		}

		$this->objects[$key] = $obj;
	}

	public function get($key)
	{
		return array_key_exists($key, $this->objects)? $this->objects[$key] : null;
	}

}