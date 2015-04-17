<?php
namespace ntentan\honam\helpers\minifiables;

use ntentan\honam\helpers\Helper;
use ntentan\honam\template_engines\AssetsLoader;

abstract class MinifiablesHelper extends Helper
{
    private $minifiableScripts = array();
    private $otherScripts = array();
    private $context = 'default';
    private $combine = false;

    protected abstract function getExtension();
    protected abstract function getMinifier();
    protected abstract function getTag($url);
    
    public function __toString()
    {
        $minifiedScript = '';
        $tags = '';
        $filename = AssetsLoader::getDestinationDir() . "/".$this->getExtension()."/combined_{$this->context}." . $this->getExtension();
        if(!file_exists($filename) && $this->combine === true)
        {
            foreach($this->minifiableScripts as $script)
            {
                $minifiedScript .= file_get_contents($script);
            }
            file_put_contents($filename, Minifier::minify($minifiedScript, $this->getMinifier()));
            $tags = $this->getTag($filename);
        }
        else if($this->combine == false)
        {
            foreach($this->minifiableScripts as $script)
            {
                $public = AssetsLoader::load($this->getExtension() . "/" . basename($script), $script);
                $tags .= $this->getTag($public);
            }
        }
        
        foreach($this->otherScripts as $script)
        {
            $tags .= $this->getTag($script);
        }
        return $tags;
    }

    public function help($arguments)
    {
        if(is_array($arguments))
        {
            foreach($arguments as $argument)
            {
                if($argument == '') continue;
                $this->otherScripts[]= $argument;
            }
        }
        else if($arguments != '')
        {
            $this->otherScripts[]= $arguments;
        }
        return $this;
    }

    public function add($script)
    {
        if($script != '' && is_string($script))
        { 
            $this->minifiableScripts[] = $script;
        }
        else if(is_array($script))
        {
            foreach($script as $scriptFile)
            {
                $this->minifiableScripts[] = $scriptFile;
            }
        }
        return $this;
    }
    
    public function context($context)
    {
        $this->context = $context;
        return $this;
    }
    
    public function combine($combine)
    {
        $this->combine = $combine;
        return $this;
    }    
}
