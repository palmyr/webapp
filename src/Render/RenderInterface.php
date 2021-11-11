<?php declare(strict_types=1);

namespace Palmyr\WebApp\Render;

interface RenderInterface
{

    public function addTemplate(string $name, string $path): RenderInterface;

    public function render(string $template, array $variables = []): string;

}