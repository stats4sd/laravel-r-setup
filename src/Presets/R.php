<?php


namespace Stats4SD\LaravelRSetup\Presets;


use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class R
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

        copy(__DIR__.'/r-stubs/init.R', base_path('scripts/R/init.R'));
        copy(__DIR__.'/r-stubs/example.R', base_path('scripts/R/example.R'));
        copy(__DIR__.'/r-stubs/rstudio.Rproj', base_path('scripts/R/'.config('app.name').'.Rproj'));
        copy(__DIR__.'/r-stubs/gitignore', base_path('scripts/R/.gitignore'));

    }

}
