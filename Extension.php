<?php

namespace Bolt\Extension\sahassar\extras;

use Symfony\Component\VarDumper\VarDumper;

class Extension extends \Bolt\BaseExtension
{

    public function getName()
    {
        return 'SahAssar extras';
    }

    function initialize()
    {
        if ($this->app['config']->getWhichEnd()=='frontend') {
            if(!isset($this->app['config']->get('general')['favicon']) && !file_exists($this->app['resources']->getPath('web')."favicon.ico") || $this->app['config']->get('general/favicon') === false){
                $this->addSnippet('endofhead', '<link rel="icon" type="image/png" href="data:image/png;base64,iVBORw0KGgo=">');
            }
        }elseif ($this->app['config']->getWhichEnd()=='backend'){
            $this->app['twig.loader.filesystem']->prependPath(__DIR__."/twig");
        }
        $this->addTwigFunction('fileModified', 'fileModified');
        $this->addTwigFunction('d', 'dumper');
    }

    function fileModified($file = "")
    {
        return filemtime($file);
    }

    function dumper($variable = "")
    {
        return dump($variable);
    }

}
