<?php

namespace boltabandoned\boltabandonedExtrasExtension;

use Symfony\Component\VarDumper\VarDumper;
use Bolt\Extension\SimpleExtension;
use Bolt\Asset\Snippet\Snippet;
use Bolt\Controller\Zone;
use Bolt\Asset\Target;

class boltabandonedExtrasExtension extends SimpleExtension
{
    protected function registerTwigPaths()
    {
        return [
            'templates' => ['position' => 'prepend', 'namespace' => 'bolt']
        ];
    }

    protected function registerTwigFunctions()
    {
        return [
            'modified' => 'modified',
            'shuffle'  => 'twigShuffle',
            'd'        => 'dumper'
        ];
    }

    protected function registerTwigFilters()
    {
        return [
            'modified' => 'modified',
            'shuffle'  => 'twigShuffle',
            'd'        => 'dumper'
        ];
    }

    protected function registerAssets()
    {
        $asset = new Snippet();
        $asset->setCallback([$this, 'faviconSnippet'])
            ->setLocation(Target::AFTER_META)
            ->setPriority(99)
            ->setZone(Zone::FRONTEND)
        ;

        return [
            $asset,
        ];
    }

    public function faviconSnippet()
    {
        $app = $this->getContainer();
        if (!isset($app['config']->get('general')['favicon']) || $app['config']->get('general/favicon') === false) {
            return '<link rel="icon" type="image/png" href="data:image/png;base64,iVBORw0KGgo=">';
        }
        return '';
    }

    public function twigShuffle($arr)
    {
        shuffle($arr);
        return $arr;
    }

    public function fileModified($file = "")
    {
        return filemtime($file);
    }

    public function dumper($variable = "")
    {
        $app = $this->getContainer();
        if ($app['users']->getCurrentUser() === null) {
            return null;
        }
        return dump($variable);
    }
}
