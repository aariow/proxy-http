<?php

namespace App\Container;

use App\Support\Config;
use App\Support\Traits\Singleton;
use Exception;
use JsonException;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    /**
     * @var array
     */
    protected array $instances = [];

    /**
     * Initialize.
     */
    public function __construct()
    {
        $this->initPaths();
        $this->boot();
    }

    use Singleton;

    /**
     * @return void
     */
    protected function initPaths(): void
    {
        $this->bind('path', BASE_DIR . '/');
        $this->bind('path.app', BASE_DIR . '/app/');
        $this->bind('path.config', BASE_DIR . '/config/');
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @return void
     */
    public function bind(mixed $key, mixed $value): void
    {
        $this->{$key} = $value;
    }

    /**
     * Boot prerequisites objects before any actions.
     *
     * @return void
     */
    protected function boot(): void
    {
        foreach ($this->getCoreAbstracts() as $instance => $value) {
            $this->bind($instance, $value);
        }

        foreach ($this->getAppAbstracts() as $instance => $value) {
            $this->bind($instance, $value);
        }
    }

    /**
     * Get core abstracts which are required for application.
     *
     * @return array
     */
    protected function getCoreAbstracts(): array
    {
        return [
            'config' => new Config(),
        ];
    }

    /**
     * Get class instances introduces in `config/app.php` file.
     *
     * @return mixed
     */
    protected function getAppAbstracts(): mixed
    {
        return $this->resolve('config')->get('abstracts');
    }

    /**
     * @inheritDoc
     *
     * @param string $id
     * @return mixed
     * @throws JsonException
     */
    public function get(string $id): mixed
    {
        try {
            return $this->resolve($id);
        } catch (Exception $exception) {

            if ($this->has($id))
                throw new JsonException($exception->getMessage());

            throw new JsonException("$id not found.");
        }
    }

    /**
     * Return bound abstracts and values.
     *
     * @param $abstract
     * @return mixed
     */
    public function resolve($abstract): mixed
    {
        return $this->{$abstract};
    }

    /**
     * @inheritDoc
     *
     * @param string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->{$id});
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function __get(string $name)
    {
        return $this->instances[$name];
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, mixed $value): void
    {
        $this->instances = array_merge_recursive($this->instances, [$name => $value]);
    }
}