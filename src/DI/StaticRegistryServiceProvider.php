<?php
namespace TheCodingMachine\CMS\StaticRegistry\DI;

use Psr\Container\ContainerInterface;
use Psr\SimpleCache\CacheInterface;
use TheCodingMachine\CMS\StaticRegistry\Registry\BlockRegistry;
use TheCodingMachine\CMS\StaticRegistry\Registry\PageRegistry;
use TheCodingMachine\CMS\StaticRegistry\Registry\StaticRegistry;
use TheCodingMachine\CMS\StaticRegistry\Registry\ThemeRegistry;
use TheCodingMachine\Funky\Annotations\Factory;
use TheCodingMachine\Funky\ServiceProvider;
use TheCodingMachine\CMS\Page\PageRegistryInterface;

class StaticRegistryServiceProvider extends ServiceProvider
{
    /**
     * @Factory(
     *     aliases={PageRegistryInterface::class}
     * )
     */
    public static function getStaticRegistry(PageRegistry $pageRegistry, ThemeRegistry $themeRegistry): StaticRegistry
    {
        return new StaticRegistry($pageRegistry, $themeRegistry);
    }

    /**
     * @Factory()
     */
    public static function getPageRegistry(string $PAGES_PATH, CacheInterface $cache): PageRegistry
    {
        return new PageRegistry($PAGES_PATH, $cache);
    }

    /**
     * @Factory()
     */
    public static function getThemeRegistry(string $THEMES_PATH, string $SUBTHEMES_PATH, ContainerInterface $container, CacheInterface $cache, BlockRegistry $blockRegistry): ThemeRegistry
    {
        return new ThemeRegistry($THEMES_PATH, $SUBTHEMES_PATH, $container, $cache, $blockRegistry);
    }

    /**
     * @Factory()
     */
    public static function getBlockRegistry(string $BLOCKS_PATH, ContainerInterface $container, CacheInterface $cache): BlockRegistry
    {
        return new BlockRegistry($BLOCKS_PATH, $container, $cache);
    }

    /**
     * @Factory(name="PAGES_PATH")
     */
    public static function getPagesDirectory(string $CMS_ROOT): string
    {
        return $CMS_ROOT.'/pages';
    }

    /**
     * @Factory(name="THEMES_PATH")
     */
    public static function getThemesDirectory(string $CMS_ROOT): string
    {
        return $CMS_ROOT.'/themes';
    }

    /**
     * @Factory(name="SUBTHEMES_PATH")
     */
    public static function getSubthemesDirectory(string $CMS_ROOT): string
    {
        return $CMS_ROOT.'/sub_themes';
    }

    /**
     * @Factory(name="BLOCKS_PATH")
     */
    public static function getBlocksDirectory(string $CMS_ROOT): string
    {
        return $CMS_ROOT.'/blocks';
    }
}
