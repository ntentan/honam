<?php
namespace ntentan\honam\engines\php\helpers\form;

use ntentan\honam\engines\php\Variable;

/**
 * A selection list class for the forms helper. This class renders an HTML
 * select form object with its associated options.
 */
class Select extends Field
{
    /**
     * An array of options to display with this selection list
     * @var array
     */
    protected $options = array();

    /**
     * When set true, this selection list would allow multiple selections
     * @var boolean
     */
    protected $multiple;
    
    protected $default;

    /**
     * Constructs a new selection list. This constructor could be invoked through
     * the form helper's $this->form->get_* method as $this->form->get_selection_list().
     *
     * @param string $label The label for the selection list
     * @param string $name The name of the selection list
     * @param string $description A brief description for the selection list
     */
    // public function __construct($label="", $name="", $options=[])
    // {
    //     Field::__construct($name);
    //     Element::__construct($label);
    //     $this->setOptions($options);
    // }

    /**
     * Sets whether multiple selections are allowed. This method automatically
     * appends the array symbol '[]' to the name of the selection list object.
     * @param boolean $multiple
     * @return SelectionList
     */
    public function setMultiple($multiple)
    {
        $this->name.="[]";
        $this->multiple = $multiple;
        return $this;
    }

    /**
     * Add an option to the selection list.
     * @param string $label
     * @param string $value
     * @return SelectionList
     */
    public function addOption($label="", $value="")
    {
        if($value==="") $value=$label;
        $this->options[$value] = $label;
        return $this;
    }

    /**
     * An alias for SelectionList::addOption
     * @param string $label
     * @param string $value
     * @return SelectionList
     */
    public function option($label='', $value='')
    {
        $this->addOption($label, $value);
        return $this;
    }
    
    public function initial($default)
    {
        $this->default = $default;
        return $this;
    }

    public function render()
    {
        $keys = array_keys($this->options);
        array_unshift($keys, '');
        array_unshift($this->options, $this->default);
        $this->options = array_combine($keys, $this->options) ?? [];
        
        $this->setAttribute('name', $this->name);
        
        if($this->multiple)
        {
            $this->setAttribute('multiple', 'multiple');
        }
        
        return $this->templateRenderer->render('select_element.tpl.php', ['element' => $this]);
    }

    /**
     * Set the options using a key value pair datastructure represented in the form of
     * a structured array.
     *
     * @param array|Variable $options An array of options
     * 
     * @return SelectionList
     */
    public function setOptions(array|Variable $options = []): Select
    {
        if(is_a($options, Variable::class))
        {
            $options = $options->unescape();
        }
        $this->options += $options;
        return $this;
    }

    /**
     * Return the array of options
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
