<?php

namespace ntentan\honam\engines\php;


use ArrayAccess;
use Countable;
use Iterator;
use ntentan\honam\exceptions\HonamException;

class Variable implements ArrayAccess, Iterator, Countable
{

    private $keys;
    private $position;
    private $data;
    private $iteratable = false;
    private $janitor;

    /**
     * @param mixed $data
     * @param Janitor $janitor
     * @return mixed
     * @throws HonamException
     */
    public static function initialize(mixed $data, Janitor $janitor): mixed
    {
        $type = gettype($data);
        switch ($type) {
            case 'object':
            case 'string':
                return new Variable($janitor, $data);

            case 'array':
                return new Variable($janitor, $data, array_keys($data));

            case 'NULL':
            case 'boolean':
            case 'integer':
            case 'double':
                return $data;

            default:
                throw new HonamException("Cannot handle the $type type in templates");
        }
    }

    public function __construct(Janitor $janitor, mixed $data, array $keys = array())
    {
        $this->janitor = $janitor;

        if ($data instanceof Variable) {
            $this->data = $data->getData();
            $this->keys = $data->getKeys();
        } else {
            $this->data = $data;
            $this->keys = $keys;
        }

        if ($this->data instanceof Iterator) {
            $this->iteratable = true;
        }
    }

    public function __toString()
    {
        return $this->janitor->cleanHtml((string)$this->data);
    }

    public function u(): mixed
    {
        return $this->unescape();
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function unescape(): mixed
    {
        return $this->data;
    }

    public function rewind(): void
    {
        if ($this->iteratable) {
            $this->data->rewind();
        } else {
            $this->position = 0;
        }
    }

    public function valid(): bool
    {
        if ($this->iteratable) {
            return $this->data->valid();
        } else {
            return isset($this->keys[$this->position]) && isset($this->data[$this->keys[$this->position]]);
        }
    }

    public function current(): mixed
    {
        if ($this->iteratable) {
            return $this->data->current();
        } else {
            return Variable::initialize($this->data[$this->keys[$this->position]], $this->janitor);
        }
    }

    public function key(): mixed
    {
        if ($this->iteratable) {
            return $this->data->key();
        } else {
            return $this->keys[$this->position];
        }
    }

    public function next(): void
    {
        if ($this->iteratable) {
            $this->data->next();
        } else {
            $this->position++;
        }
    }

    public function offsetExists($offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function __invoke()
    {
        return Variable::initialize(call_user_func_array($this->data, func_get_args()), $this->janitor);
    }

    public function offsetGet($offset): mixed
    {
        if (isset($this->data[$offset])) {
            return Variable::initialize($this->data[$offset], $this->janitor);
        } else {
            return null;
        }
    }

    public function offsetSet($offset, $value): void
    {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetUnset($offset): void
    {
        unset($this->data[$offset]);
    }

    /**
     * @param $method
     * @param $arguments
     * @return mixed
     * @throws HonamException
     */
    public function __call($method, $arguments)
    {
        return Variable::initialize(call_user_func_array([$this->data, $method], $arguments), $this->janitor);
    }

    /**
     * @param $name
     * @return mixed
     * @throws HonamException
     */
    public function __get($name)
    {
        return Variable::initialize($this->data->$name, $this->janitor);
    }

    public function __debugInfo()
    {
        return is_array($this->data) ? $this->data : [$this->data];
    }

    public function getData()
    {
        return $this->data;
    }

    public function getKeys()
    {
        return $this->keys;
    }
}
