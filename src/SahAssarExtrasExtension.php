<?php

namespace boltabandoned\boltabandonedExtrasExtension;

use Bolt\Extension\SimpleExtension;
use Bolt\Asset\Snippet\Snippet;
use Bolt\Controller\Zone;
use Bolt\Asset\Target;
use Bolt\Helpers\Html;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class boltabandonedExtrasExtension extends SimpleExtension
{
    private $pushAssets = [];

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
            'p'        => 'pushLink',
            'barelink' => 'bareLink'
        ];
    }

    protected function registerTwigFilters()
    {
        return [
            'modified' => 'modified',
            'shuffle'  => 'twigShuffle',
            'd'        => 'dumper',
            'p'        => 'pushLink',
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

    protected function subscribe(EventDispatcherInterface $dispatcher)
    {
        $app = $this->getContainer();
        $app->after(function ($request, $response, $app) {
            $this->addPushHeader($response);
        });
    }

    public function addPushHeader($response)
    {
        $response->headers->set('Link', $this->pushAssets);
    }

    public function pushLink($uri = "")
    {
        $as = false;
        if (strpos($uri, '.css') !== false) {
            $as = 'style';
        } elseif (strpos($uri, '.js') !== false) {
            $as = 'script';
        } elseif (strpos($uri, '.woff') !== false || strpos($uri, '.woff2') !== false) {
            $as = 'font';
        } elseif (strpos($uri, '.jpg') !== false || strpos($uri, '.jpeg') !== false || strpos($uri, '.png') !== false) {
            $as = 'image';
        }

        if ($as && $uri) {
            $this->pushAssets[] = sprintf('<%s>; rel=preload; as=%s', $uri, $as);
        }

        return $uri;
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

        VarDumper::setHandler(function ($var) {
            $cloner = new VarCloner();
            $dumper = 'cli' === PHP_SAPI ? new CliDumper() : new HtmlDumper();

            $dumper->dump($cloner->cloneVar($var));
        });

        return VarDumper::dump($variable);
    }
}
