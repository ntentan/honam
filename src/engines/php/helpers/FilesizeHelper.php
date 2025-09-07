<?php

namespace ntentan\honam\engines\php\helpers;

use ntentan\honam\engines\php\Helper;

class FilesizeHelper extends Helper
{
    private int $size;
    private string $commas = ',';
    private int $decimals = 2;
    
    public function help(mixed $size): Helper
    {
        $this->size = $size;
        
        return $this;
    }
    
    public function commas($commas)
    {
        $this->commas = $commas ? ',' : '';
        return $this;
    }
    
    public function decimals($decimals)
    {
        $this->decimals = $decimals;
        return $this;
    }
    
    public function __toString() 
    {
        $output = null;
        $scales = array(
            array(0, 1024, 'Byte', 'Byte', false),
            array(1024, 1048576, 'Kilobyte', 'KB', true),
            array(1048576, 1073741824, 'Megabyte', 'MB', true),
            array(1073741824, 1099511627776, 'Gigabyte', 'GB', true),
            array(1099511627776 ,1125899906842620, 'Terabyte', 'TB', true),
            array(1125899906842620, 1152921504606850000, 'Petabyte', 'PB', true)
        );
        
        $devisor = 1;
        foreach($scales as $scale)
        {
            if($this->size >= $scale[0] && $this->size < $scale[1])
            {
                $size = $this->size / $devisor;
                $output = number_format($size, $scale[4] ? $this->decimals : 0, '.', $this->commas)
                    . " {$scale[2]}" 
                    . ($size <> 1 ? 's' : '');
                break;
            }
            $devisor = $scale[1];
        }        
        
        return $output;
    }
}
