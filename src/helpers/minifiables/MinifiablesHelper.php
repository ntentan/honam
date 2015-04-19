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
    
    private function makePublic($file)
    {
        return $this->getTag($this->makeFullUrl(AssetsLoader::load($this->getExtension() . "/" . basename($file), $file)));        
    }
    
    private function writeTags($files)
    {
        $tags = '';
        foreach($files as $script)
        {
            $tags .= $this->makePublic($script);
        }
        return $tags;
    }
    
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
            $tags .= $this->writeTags($this->minifiableScripts);
        }
        
        $tags .= $this->writeTags($this->otherScripts);
        
        $this->minifiableScripts = array();
        $this->otherScripts = array();
        
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
