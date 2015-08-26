<?php

namespace Bolt\Extension\boltabandoned\extras;

use Symfony\Component\VarDumper\VarDumper;

class Extension extends \Bolt\BaseExtension
{
    
    public function getName()
    {
        return 'Bolt extras';
    }
    
    function initialize()
    {
        if ($this->app['config']->getWhichEnd()=='frontend') {
            $this->addTwigFunction('filemodified', 'filemodified');
            $this->addTwigFunction('d', 'dumper');
        }else{
            if(!file_exists($this->app['resources']->getPath('web')."app/config/backend")){
                mkdir($this->app['resources']->getPath('web')."app/config/backend");
            }
            if(!file_exists($this->app['resources']->getPath('web')."app/config/backend/listing")){
                mkdir($this->app['resources']->getPath('web')."app/config/backend/listing");
            }
            $this->app['twig.loader.filesystem']->prependPath($this->app['resources']->getPath('web')."app/config/backend/listing");
            $this->app['twig.loader.filesystem']->prependPath(__DIR__."/twig");
        }
    }
    
    function filemodified($file = "")
    {
        return filemtime($file);
    }
    
    function dumper($variable = "")
    {
        return dump($variable);
    }
    
}
