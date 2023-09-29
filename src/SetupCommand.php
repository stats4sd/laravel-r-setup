<?php

namespace Stats4SD\LaravelRSetup;

use Illuminate\Console\Command;
use InvalidArgumentException;
use Illuminate\Support\Facades\Process;

class SetupCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'rsetup
                    { type : The type of R project (r, rmarkdown) }
                    { --option=* : Pass an option to the preset command }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialise an RStudio project inside scripts/R';

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function handle()
    {
        if (static::hasMacro($this->argument('type'))) {
            return call_user_func(static::$macros[$this->argument('type')], $this);
        }

        if (! in_array($this->argument('type'), ['r', 'rmarkdown'])) {
            throw new InvalidArgumentException('Invalid preset. Please choose either r or rmarkdown');
        }

        $this->info('###################################');
        $this->info('Starting R Setup Process');
        $this->info('###################################');

        $this->{$this->argument('type')}();

        $this->info('R setup complete!');
        $this->comment('You are ready to start developing your R project inside `scripts/R`. An RStudio project has been created, and the project is ready to use renv to manage dependencies.');
    }

    /**
     * Installs the core R dependencies
     *
     * @return void;
     */
    protected function r()
    {
        Presets\R::install();

        $this->info('Files copied to `scripts/R`. Starting renv installation');
        $this->setupRenvRepo();
        $this->installRenv();
        $this->initRenv();
    }

    /**
     * Installs R + RMarkdown dependencies
     *
     * @return void;
     */
    protected function rmarkdown()
    {
        Presets\R::install();
        Presets\RMarkdown::install();
        $this->setupRenvRepo();
        $this->installRenv();
        $this->initRenv();
    }

    /**
     * Setup renv repository
     *
     * @return void;
     */
    protected function setupRenvRepo()
    {
        $this->info("It will take a few minutes to setup renv repo, please wait...");
        $result = Process::forever()->run('Rscript -e "install.packages(\'renv\', repos = \'http://cran.rstudio.com/\')"');

        echo $result->output();
        echo $result->errorOutput();
    }

    /**
     * Install the Renv library to manage R library dependencies
     *
     * @return void;
     */
    protected function installRenv()
    {
        $this->info("It will take a few minutes to install renv, please wait...");

        $result = Process::forever()->run('Rscript -e "renv::install()"');

        echo $result->output();
        echo $result->errorOutput();
    }

    /**
     * Initialises the Renv library to manage R library dependencies
     *
     * @return void;
     */
    protected function initRenv()
    {
        $this->info("It will take a few minutes to initialise renv, please wait...");

        $result = Process::forever()->run('Rscript -e "renv::init()"');

        echo $result->output();
        echo $result->errorOutput();
    }

}
