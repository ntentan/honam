<?php
namespace ntentan\honam\template_engines\smarty;

use ntentan\honam\TemplateEngine;
use Smarty;

class Engine extends Smarty
{
    private $temp;
    
    public function __construct() 
    {
        parent::__construct();
        $this->temp = TemplateEngine::getTempDirectory();
        $this->setCompileDir("{$this->temp}/smarty_compiled_templates");
    }
    
    public function __destruct() 
    {
        if($this->temp === '.' && file_exists("./smarty_compiled_templates"))
        {
            $files = scandir("./smarty_compiled_templates");
            foreach($files as $file)
            {
                if($file == "." | $file == "..")
                {
                    continue;
                }
                unlink("./smarty_compiled_templates/$file");
            }
            rmdir("./smarty_compiled_templates");
        }
    }
}
