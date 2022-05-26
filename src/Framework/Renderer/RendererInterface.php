<?php

namespace Framework\Renderer;

interface RendererInterface
{
    
    /**
     * allow to added path for resolve views
     * addPath
     *
     * @param  mixed $namespace
     * @param  mixed $path
     * @return void
     */
    public function addPath(string $namespace, ?string $path = null):void;
    
    /**
     * Allow render an view
     * The path can be specify with namespace added to addPath()
     * $this->render("@blog/view");
     * $this->render("view");
     * render
     *
     * @param  mixed $view
     * @param  mixed $params
     * @return string
     */
    public function render(string $view, array $params = []): string;

    /**
     * Allow Added global variables to all views
     * addGlobal
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public function addGlobal(string $key, mixed $value): void;
}
