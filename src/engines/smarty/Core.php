<?php
namespace ntentan\honam\engines\smarty;

use ntentan\utils\Filesystem;
use Smarty;

class Core extends Smarty
{
    private $temp = '.';

    public function __construct(string $tempDirectory)
    {
        parent::__construct();
        $this->temp = $tempDirectory;
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
    }
}
