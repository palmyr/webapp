<?php declare(strict_types=1);

namespace Palmyr\WebApp\Install\Script;

use Composer\Script\Event;

class InstallScript
{

    static public function install(Event $event): void
    {
        $rootDir = dirname($event->getComposer()->getConfig()->get('vendor-dir'));
        static::setupPublicDir($rootDir);
    }

    static public function update(Event $event): void
    {
        $rootDir = dirname($event->getComposer()->getConfig()->get('vendor-dir'));
        static::setupPublicDir($rootDir);
    }

    static protected function setupPublicDir(string $rootDir): void
    {
        $publicDir = $rootDir . DIRECTORY_SEPARATOR . 'public';
        $indexTemplate = dirname(__DIR__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'index.php.txt';

        if ( !is_dir($publicDir) ) {
            if ( !mkdir($publicDir) ) {
                throw new \RuntimeException('Failed to create public directory');
            }
        }


        if ( !copy($indexTemplate, $publicDir . DIRECTORY_SEPARATOR . 'index.php') ) {
            throw new \RuntimeException('Failed to create index.php');
        }
    }


}