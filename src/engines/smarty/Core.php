<?php
namespace ntentan\honam\engines\smarty;

use ntentan\honam\factories\HelperFactory;
use ntentan\honam\TemplateRenderer;
use ntentan\utils\Filesystem;
use Smarty;

class Core extends Smarty
{
    private $temp = '.';
    private $helperFactory;

    public function __construct(HelperFactory $helperFactory, string $tempDirectory)
    {
        parent::__construct();
        $this->temp = $tempDirectory;
        $this->helperFactory = $helperFactory;
        $this->setCompileDir("{$this->temp}/smarty_compiled_templates");
    }
    
    public function __destruct() 
    {
        if($this->temp === '.' && file_exists("./smarty_compiled_templates")) {
            Filesystem::get("./smarty_compiled_templates")->delete();
        }
    }

    public function setData($data)
    {
        $this->clearAllAssign();
        $this->assign($data);
        $this->assign('honam', $this->helperFactory);
    }
}
