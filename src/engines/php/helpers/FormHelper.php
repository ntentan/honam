<?php

namespace ntentan\honam\engines\php\helpers;

use ntentan\honam\engines\php\Helper;
use ntentan\honam\engines\php\helpers\form\Container;
use ntentan\honam\engines\php\helpers\form\ElementFactory;
use ntentan\honam\exceptions\HonamException;

/**
 * A helper for rendering forms.
 */
class FormHelper extends Helper
{

    use ElementFactory;

    /**
     * An instance of the container for the Form.
     * @var array
     */
    private $containers = [];

    /**
     * An instance of the first container added to the form.
     * This is saved so that methods that need to access the first container can still work after the form is closed.
     */
    private $baseContainer;

    /**
     * Data to be rendered into the form.
     * @var array
     */
    private $data = [];

    /**
     * Any errors that should be rendered with the form.
     */
    private $errors = [];

    /**
     * Renders the form when the value is used as a string
     * @return string
     */
    public function __toString()
    {
        $this->baseContainer->setData($this->data);
        $this->baseContainer->setErrors($this->errors);
        $rendered = (string) $this->baseContainer;
        $this->baseContainer = null;
        return $rendered;
    }

    /**
     * Set the ID of the form.
     * @return string
     */
    public function setId($id)
    {
        $this->getContainer()->setId($id);
    }

    public function open()
    {
        return $this->open_form();
    }

    public function close($submit = 'Submit')
    {
        return $this->close_form($submit);
    }

    public function pushContainer(string $name, Container $container)
    {
        if ($this->baseContainer === null && empty($this->containers)) {
            // If a container is opened and there is no base container, we can assume its the base container.
            $this->baseContainer = $container;
        } else if ($this->baseContainer !== null && empty($this->containers)) {
            // If the container is stack is empty while we still have a base container, something is wrong.
            throw new HonamException("Cannot add a container to a form that has already been closed.");
        }
        array_push($this->containers, ['name' => $name, 'instance' => $container]);
    }

    public function popContainer(string $name)
    {
        $container = array_pop($this->containers);
        if ($name === $container['name']) {
            // Add this container to a parent if containers are nested in any way.
            $currentContainer = end($this->containers);
            if ($currentContainer === false) {
                $this->baseContainer = null;
            } else {
                $currentContainer['instance']->add($container['instance']);
            }
            return $container['instance'];
        } else {
            throw new HonamException("You cannot close the $name container while {$container['name']} is open.");
        }
    }

    public function getActiveContainer(): Container
    {
        return end($this->containers)['instance'];
    }

    public function hasActiveContainer(): bool
    {
        return !empty($this->containers);
    }
}
