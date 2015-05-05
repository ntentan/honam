<?php
namespace ntentan\honam\helpers;

use ntentan\honam\Helper;
use ntentan\honam\AssetsLoader;
use ntentan\honam\helpers\minifiables\Minifier;

abstract class MinifiablesHelper extends Helper
{
    private $minifiableScripts = array();
    private $otherScripts = array();
    private $context = 'default';
    private $combine = false;
    private $destination = null;

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
        $filename = "/" . $this->getExtension() . "/combined_{$this->context}." . $this->getExtension();
        if($this->combine === true)
        {
            foreach($this->minifiableScripts as $script)
            {
                $minifiedScript .= file_get_contents($script);
            }
            file_put_contents(AssetsLoader::getDestinationDir() . $filename, Minifier::minify($minifiedScript, $this->getMinifier()));
            $tags = $this->getTag(AssetsLoader::getSiteUrl() . $filename);
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
    
    public function setContext($context)
    {
        return $this->context($context);
    }
    
    public function setCombine($combine)
    {
        return $this->combine($combine);
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
