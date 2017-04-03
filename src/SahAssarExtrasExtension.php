<?php

namespace SahAssar\SahAssarExtrasExtension;

use Symfony\Component\VarDumper\VarDumper;
use Bolt\Extension\SimpleExtension;
use Bolt\Asset\Snippet\Snippet;
use Bolt\Controller\Zone;
use Bolt\Asset\Target;
use Bolt\Helpers\Html;

class SahAssarExtrasExtension extends SimpleExtension
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
            'd'        => 'dumper',
            'barelink' => 'bareLink'
        ];
    }

    protected function registerTwigFilters()
    {
        return [
            'modified' => 'modified',
            'shuffle'  => 'twigShuffle',
            'd'        => 'dumper',
            'barelink' => 'bareLink'
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

    /**
     * Create an bare link to a given URL or contenttype/slug pair.
     *
     * @param string $location
     * @param string $label
     *
     * @return string
     */
    public function bareLink($location)
    {
        $app = $this->getContainer();
        if ((string) $location === '') {
            return '';
        }
        if (Html::isURL($location)) {
            $location = Html::addScheme($location);
        } elseif ($record = $app['storage']->getContent($location)) {
            if (is_array($record)) {
                return $location;
            }
            $location = $record->link();
        }
        return $location;
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
