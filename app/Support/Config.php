<?php

namespace App\Support;

use Exception;

class Config
{
    /**
     * @var array
     */
    protected array $configs = [];

    public function __construct()
    {
        $this->massSet($this->readFromFile());
    }

    /**
     * @param array $items
     * @return $this
     */
    public function massSet(array $items = []): static
    {
        foreach ($items as $key => $value) {
            $this->set($key, $value);
        }

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function set($key, $value): static
    {
        $this->configs[$key] = $value;

        return $this;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function readFromFile(): mixed
    {
        if (!file_exists(BASE_DIR . "/config/app.php"))
            throw new Exception("Core `app.php` config file does not exist.");

        return require BASE_DIR . "/config/app.php";
    }

    /**
     * @param $key
     * @return mixed
     */
    public function get($key): mixed
    {
        return $this->configs[$key];
    }
}