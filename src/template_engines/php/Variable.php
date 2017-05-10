<?php

namespace ntentan\honam\template_engines\php;

class Variable implements \ArrayAccess, \Iterator, \Countable {

    private $keys;
    private $position;
    private $data;
    private $iteratable = false;

    public static function initialize($data) {
        $type = gettype($data);
        switch ($type) {
            case 'object':
            case 'string':
                return new Variable($data);

            case 'array':
                return new Variable($data, array_keys($data));

            case 'NULL':
            case 'boolean':
            case 'integer':
            case 'double':
                return $data;

            default:
                throw new \ntentan\honam\ViewException("Cannot handle the $type type in templates");
        }
    }

    public function __construct($data, $keys = array()) {
        if ($data instanceof Variable) {
            $this->data = $data->getData();
            $this->keys = $data->getKeys();
        } else {
            $this->data = $data;
            $this->keys = $keys;
        }

        if ($this->data instanceof \Iterator) {
            $this->iteratable = true;
        }
    }

    public function __toString() {
        return Janitor::cleanHtml($this->data);
    }

    public function u() {
        return $this->unescape();
    }

    public function count() {
        return count($this->data);
    }

    public function unescape() {
        return $this->data;
    }

    public function rewind() {
        if ($this->iteratable) {
            $this->data->rewind();
        } else {
            $this->position = 0;
        }
    }

    public function valid() {
        if ($this->iteratable) {
            return $this->data->valid();
        } else {
            return @isset($this->data[$this->keys[$this->position]]);
        }
    }

    public function current() {
        if ($this->iteratable) {
            return $this->data->current();
        } else {
            return Variable::initialize($this->data[$this->keys[$this->position]]);
        }
    }

    public function key() {
        if ($this->iteratable) {
            return $this->data->key();
        } else {
            return $this->keys[$this->position];
        }
    }

    public function next() {
        if ($this->iteratable) {
            $this->data->next();
        } else {
            $this->position++;
        }
    }

    public function offsetExists($offset) {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset) {
        if (isset($this->data[$offset])) {
            return Variable::initialize($this->data[$offset]);
        } else {
            return null;
        }
    }

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetUnset($offset) {
        unset($this->data[$offset]);
    }

    public function __call($method, $arguments) {
        return Variable::initialize(call_user_func_array([$this->data, $method], $arguments));
    }

    public function __get($name) {
        return Variable::initialize($this->data->$name);
    }

    public function getData() {
        return $this->data;
    }

    public function getKeys() {
        return $this->keys;
    }

}
