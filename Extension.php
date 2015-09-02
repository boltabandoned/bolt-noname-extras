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
            $this->addTwigFunction('numToString', 'numToString');
            $this->addTwigFunction('fileModified', 'fileModified');
            $this->addTwigFunction('remoteCache', 'remoteCache');
            $this->addTwigFunction('d', 'dumper');
            if(!isset($this->app['config']->get('general')['favicon']) && !file_exists($this->app['resources']->getPath('web')."favicon.ico") || $this->app['config']->get('general/favicon') === false){
                $this->addSnippet('endofhead', '<link rel="icon" type="image/png" href="data:image/png;base64,iVBORw0KGgo=">');
            }
        }elseif ($this->app['config']->getWhichEnd()=='backend'){
            if(!file_exists($this->app['resources']->getPath('config')."backend")){
                mkdir($this->app['resources']->getPath('config')."backend");
            }
            if(!file_exists($this->app['resources']->getPath('config')."backend/listing")){
                mkdir($this->app['resources']->getPath('config')."backend/listing");
            }
            $this->app['twig.loader.filesystem']->prependPath($this->app['resources']->getPath('web')."app/config/backend/listing");
            $this->app['twig.loader.filesystem']->prependPath(__DIR__."/twig");
        }
    }
    
    function numToString($num = 1){
        $num = round($num,0);
        if($num == 0){
            $num = 1;
        }
        switch ($num) {
            case 1:
                return "one";
                break;
            case 2:
                return "two";
                break;
            case 3:
                return "three";
                break;
            case 4:
                return "four";
                break;
            case 5:
                return "five";
                break;
            case 6:
                return "six";
                break;
            case 7:
                return "seven";
                break;
            case 8:
                return "eight";
                break;
            case 9:
                return "nine";
                break;
            case 10:
                return "ten";
                break;
            case 11:
                return "eleven";
                break;
            default:
                return "twelve";
                break;
        }
    }
    
    function fileModified($file = "")
    {
        return filemtime($file);
    }
    
    function dumper($variable = "")
    {
        return dump($variable);
    }
    
    function remoteCache($url = "", $time = 604800)
    {
        $cachekey = preg_replace("/[^A-Za-z0-9 ]/", '', $url);
        $resp = $this->app['cache']->fetch("remotecache$cachekey");
        if ($resp === false) {
            $curlOptions['CURLOPT_CONNECTTIMEOUT'] = 10;
            $curlOptions['CURLOPT_USERAGENT'] = "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1866.237 Safari/537.36";
            $resp = $this->app['guzzle.client']->get($url, array('headers' =>array('User-Agent' => "Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1866.237 Safari/537.36")), $curlOptions)->getBody(true)->getContents();
            $this->app['cache']->save("remotecache$cachekey", $resp, $time);
        }
        return new \Twig_Markup($resp, 'UTF-8');
    }
    
}
