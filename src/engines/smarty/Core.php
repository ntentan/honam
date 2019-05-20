<?php
namespace ntentan\honam\engines\smarty;

use ntentan\honam\factories\HelperFactory;
use ntentan\honam\TemplateRenderer;
use Smarty;

class Core extends Smarty
{
    private $temp;
    private $helperFactory;
    private $templateRenderer;
    
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
            $files = scandir("./smarty_compiled_templates");
            foreach($files as $file) {
                if($file == "." | $file == "..") {
                    continue;
                }
                unlink("./smarty_compiled_templates/$file");
            }
            rmdir("./smarty_compiled_templates");
        }
    }

    public function setData($data)
    {
        $this->clearAllAssign();
        $this->assign($data);
        $this->assign('honam', $this->helperFactory);
    }
}
