<?php

declare(strict_types=1);

/**
 * Very small .phtml template renderer.
 *
 * Usage:
 *   render('home', ['user' => $user]);
 */
function render(string $view, array $params = [], string $layout = 'layout'): void
{
    $baseDir = __DIR__;
    $viewPath = $baseDir . '/templates/' . $view . '.phtml';
    $layoutPath = $baseDir . '/templates/' . $layout . '.phtml';

    if (!is_file($viewPath)) {
        throw new RuntimeException('View not found: ' . $viewPath);
    }

    if (!is_file($layoutPath)) {
        throw new RuntimeException('Layout not found: ' . $layoutPath);
    }

    extract($params, EXTR_SKIP);

    ob_start();
    require $viewPath;
    $content = (string) ob_get_clean();

    require $layoutPath;
}
