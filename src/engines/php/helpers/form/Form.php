<?php
namespace ntentan\honam\engines\php\helpers\form;

/**
 * The form class. This class represents the overall form class. This form represents the main form for collecting data
 * from the user.
 */
class Form extends Container
{
    protected $submitValues = array('Submit');
    protected $showSubmit = true;
    protected $method = "POST";
    private $action;

    public function __construct()
    {
        $this->action = filter_var($_SERVER["REQUEST_URI"], FILTER_VALIDATE_URL);
    }

    public function setAction($action)
    {
        $this->action = $action;
        return $this;
    }
    
    public function renderHead()
    {
        $this->setAttribute("method", $this->method);
        $this->setAttribute('action', $this->action);
        $this->setAttribute('accept-charset', 'utf-8');
        
        return $this->templateRenderer->render('form_head', ['element' => $this]);
    }

    public function renderFoot()
    {
        return $this->templateRenderer->render(
            'form_foot', ['show_submit' => $this->showSubmit, 'submit_values' => $this->submitValues]
        );
    }
    
    public function setShowSubmit($showSubmit)
    {
        $this->showSubmit = $showSubmit;
    }
    
    public function setSubmitValues($submitValues)
    {
        $this->submitValues = $submitValues;
    }
}
