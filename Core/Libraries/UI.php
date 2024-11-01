<?php
Namespace Skytells\SFA;
if (!defined('ABSPATH')) { exit; }
use Skytells\Container\Container;
use Skytells\Events\Dispatcher;
use Skytells\Filesystem\Filesystem;
use Skytells\View\Compilers\BladeCompiler;
use Skytells\View\Engines\CompilerEngine;
use Skytells\View\Engines\EngineResolver;
use Skytells\View\Engines\PhpEngine;
use Skytells\View\Factory;
use Skytells\View\FileViewFinder;

Class UI {
  public static function render($view, $templateData = []) {
    $pathsToTemplates = [SFA_VIEWS];
    $pathToCompiledTemplates = SFA_CACHE.'/views/';

    $filesystem = new Filesystem;
    $eventDispatcher = new Dispatcher(new Container);

    $viewResolver = new EngineResolver;
    $bladeCompiler = new BladeCompiler($filesystem, $pathToCompiledTemplates);
    $viewResolver->register('blade', function () use ($bladeCompiler, $filesystem) {
        return new CompilerEngine($bladeCompiler, $filesystem);
    });
    $viewResolver->register('php', function () {
        return new PhpEngine;
    });
    $viewFinder = new FileViewFinder($filesystem, $pathsToTemplates);
    $viewFactory = new Factory($viewResolver, $viewFinder, $eventDispatcher);
    echo $viewFactory->make($view, $templateData)->render();
  }


}
