<?php declare(strict_types=1);

namespace Palmyr\WebApp\Install\Script;

use Composer\Script\Event;

class InstallScript
{

    static protected self $instance;

    protected string $rootDirectory;

    protected string $templateDirectory;

    protected function __construct(
        string $rootDirectory
    )
    {
        $this->rootDirectory = $rootDirectory;
        $this->templateDirectory = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'Resources' . DIRECTORY_SEPARATOR . 'templates';
    }

    static public function install(Event $event): void
    {
        static::init($event);
    }

    static public function update(Event $event): void
    {
        static::init($event);
    }

    static protected function init(Event $event): void
    {
        if ( !isset(static::$instance) ) {
            $rootDir = dirname($event->getComposer()->getConfig()->get('vendor-dir'));
            static::$instance = new static($rootDir);
        }

        static::$instance->setupApplication();

    }

    protected function setupApplication(): void
    {

        foreach ($this->applicationDirectories() as $directory ) {
            $directory = $this->rootDirectory . $directory;
            if ( !is_dir($directory) ) {
                if ( !mkdir($directory) ) {
                    throw new \RuntimeException(sprintf('Failed to create application directory [Directory: %s ]', $directory));
                }
            }
        }

        foreach ( $this->applicationTemplates() as $template => $destination ) {
            $template = $this->templateDirectory . $template;
            $destination = $this->rootDirectory . $destination;

            if ( !copy($template, $destination) ) {
                throw new \RuntimeException(sprintf('Failed to copy template [Template: %s ] [Destination: %s ]', $template, $destination));
            }
        }
    }

    protected function applicationDirectories(): array
    {
        return [
            DIRECTORY_SEPARATOR . 'public',
            DIRECTORY_SEPARATOR . 'config',
        ];
    }

    protected function applicationTemplates(): array
    {
        return [
            '/htaccess.txt' => '/public/.htaccess',
            '/index.php.txt' => '/public/index.php',
        ];
    }


}