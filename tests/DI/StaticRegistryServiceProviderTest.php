<?php

namespace TheCodingMachine\CMS\StaticRegistry\DI;

use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\CacheInterface;
use Simplex\Container;
use Symfony\Component\Cache\Simple\ArrayCache;
use TheCodingMachine\CMS\StaticRegistry\Registry\StaticRegistry;
use TheCodingMachine\CMS\Theme\TwigThemeDescriptor;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Uri;

class StaticRegistryServiceProviderTest extends TestCase
{
    public function testServiceProvider()
    {
        $simplex = new Container();
        $simplex->register(new StaticRegistryServiceProvider());

        $simplex->set('CMS_ROOT', __DIR__.'/../fixtures/Loaders');
        $simplex->set(CacheInterface::class, function() { return new ArrayCache(); });

        $staticRegistry = $simplex->get(StaticRegistry::class);
        /* @var $staticRegistry StaticRegistry */
        $request = new ServerRequest([], [], new Uri('http://example.com/foo/bar'));
        $block = $staticRegistry->getPage($request);

        $theme = $block->getThemeDescriptor();
        $this->assertInstanceOf(TwigThemeDescriptor::class, $theme);
    }
}
