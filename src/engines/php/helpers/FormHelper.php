<?php

namespace ntentan\honam\engines\php\helpers;

use ntentan\honam\engines\php\Helper;
use ntentan\honam\engines\php\helpers\form\Container;
use ntentan\honam\engines\php\helpers\form\ElementFactory;
use ntentan\honam\exceptions\HonamException;

/**
 * A helper for rendering forms.
 *
 * @method Container open_form()
 * @method Container close_form($submit = 'Submit')
 */
class FormHelper extends Helper
{

    use ElementFactory;

    /**
     * An instance of the container for the Form.
     * @var array
     */
    private array $containers = [];

    /**
     * An instance of the first container added to the form.
     * This is saved so that methods that need to access the first container can still work after the form is closed.
     */
    private Container $baseContainer;

    /**
     * Data to be rendered into the form.
     * @var array
     */
    private array $data = [];

    /**
     * Any errors that should be rendered with the form.
     */
    private array $errors = [];

    /**
     * Renders the form when the value is used as a string
     * @return string
     */
    public function __toString()
    {
        $this->baseContainer->setData($this->data);
        $this->baseContainer->setErrors($this->errors);
        return (string) $this->baseContainer;
    }

    /**
     * Set the ID of the form.
     */
    public function setId($id): void
    {
        $this->getContainer()->setId($id);
    }

    /**
     * @return Container
     */
    public function open(): Container
    {
        return $this->open_form();
    }

    public function close($submit = 'Submit')
    {
        return $this->close_form($submit);
    }

    public function pushContainer(string $name, Container $container): void
    {
        if (empty($this->containers)) {
            $this->baseContainer = $container;
        }
        $this->containers[] = ['name' => $name, 'instance' => $container];
    }

    public function popContainer(string $name)
    {
        $container = array_pop($this->containers);
        if ($name === $container['name']) {
            // Add this container to a parent if containers are nested in any way.
            $currentContainer = end($this->containers);
            if ($currentContainer !== false) {
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
