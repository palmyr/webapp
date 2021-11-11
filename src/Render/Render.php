<?php declare(strict_types=1);

namespace Palmyr\WebApp\Render;

class Render implements RenderInterface
{

    protected array $templates;

    public function addTemplate(string $name, string $path): RenderInterface
    {
        $this->templates[$name] = $path;

        return $this;
    }

    public function render(string $template, array $variables = []): string
    {
        if ( array_key_exists($template, $this->templates) ) {
            ob_start();
            include $this->templates[$template];

            return ob_get_clean();
        }

        throw new \RuntimeException('Template not found');
    }
}