<?php


namespace Stats4SD\LaravelRSetup\Presets;


use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class RMarkdown
{
    /**
     * Install the preset.
     *
     * @return void
     */
    public static function install()
    {
        static::updateR();
    }

    /**
     * Update the R files for the application.
     *
     * @return void
     */
    protected static function updateR()
    {
        (new Filesystem)->ensureDirectoryExists(base_path('scripts/R'));

        copy(__DIR__.'/r-markdown-stubs/init.R', base_path('scripts/R/init.R'));
        copy(__DIR__.'/r-markdown-stubs/example-markdown.R', base_path('scripts/R/example-markdown.R'));
        copy(__DIR__.'/r-markdown-stubs/example-markdown-doc.Rmd', base_path('scripts/R/example-markdown-doc.Rmd'));
    }

}
