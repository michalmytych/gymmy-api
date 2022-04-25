<?php

if (!function_exists('docs_path')) {
    function docs_path() {
        // @todo
        $rootPath = str_replace(
            '/app',
            '',
            app_path()
        );

        return $rootPath . '/docs';
    }
}
