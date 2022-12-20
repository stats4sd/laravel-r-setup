# Laravel R Setup

This helper package can be used to quickly scaffold an R project within the main Laravel project.

Often, we have found the need to pass particular tasks out to R, for example advanced data processing, statistical analysis, or generation of customisable reports through RMarkdown. In these cases, we want to initialise an R project within a sub-folder of the main Laravel application. 

## Requirements
To use this package locally, you must have R installed, and you should have installed the renv library locally (`install.packages('renv')` in R).

> NOTE: This package does not help with installing R on your local development machine, OR on the server you deploy to. You should handle that separately! 



## Quick Start

To get started: 

1. require the package as a dev dependency: `composer require stats4sd/laravel-r-setup --dev`.
2. Run the setup script: 
    - If you want to write RMarkdown documents, run `php artisan rsetup rmarkdown`. 
    - If you want a simpler R environment, run `php artisan rsetup r`.
    
This will create a new RStudio project with some example files in `scripts/R`. 

## Default R Setup:
The 'default' setup creates for you: 
 - **An `init.R` script**: This connects R to the same .env file that Laravel uses, and adds a function to connect to the Laravel database.
 - **An `example.R` script**: This provides an example to show how to connect to the database in your scripts. It also acts as a quick test to ensure the setup is working. 
 
It also initialises [Renv](https://rstudio.github.io/renv/articles/renv.html) - this tool is the R equivalent to composer or npm, and it's recommended to use this to let you quickly setup any required R pacakages when you deploy your application.
 
You can run this `example.R` script to test your setup. If it is working, a `user-test.csv` file will be created, containing a list of users in your Laravel application database.

## RMarkdown
The rmarkdown option gives you some additional files: 
 - **A `example-markdown.R` script**: This demonstrates how you can get data from the Laravel database and pass it to a .Rmd file as a parameter. Run this script to generate a pdf output that contains a list of the current users in your Laravel database. 
 - **A `example-markdown.Rmd` file**: This is used together with the example script.

> NOTE: If you intend to produce PDF documents with RMarkdown, you will need to ensure your deployment environment has pdflatex and pandoc installed. You also need to tell R where these applications are located, especially when running R scripts from PHP via Symfony Process.
> 
> We have found a reliable way is to add the following variables to your .env file, and reference them where needed in your R script:
>  - RSTUDIO_PANDOC 
>  - PDFLATEX_PATH 
> 
> Our `init.R` script for r-markdown references the PDFLATEX_PATH variable. The RSTUDIO_PANDOC one is a default variable that RMarkdown references when looking for a version of pandoc to use. 


## How to find your env variables

#### RSTUDIO_PANDOC
 - If you have RStudio installed, open it and run `Sys.getenv("RSTUDIO_PANDOC")`. 
 - If you do not, or if you are deploying to a server, ensure you have installed pandoc. Then run:
    - (for windows - Powershell): `where.exe pandoc`
    - (for Mac / Linux - Bash): `which pandoc`
    
Use the *exact* output in your .env file (include the 'pandoc' on the end of the file path).

Example (from MacOS)
```
RSTUDIO_PANDOC=/Applications/RStudio.app/Contents/MacOS/pandoc
```


#### PDFLATEX_PATH
 - Ensure you have pdflatex installed. Then run:
    - (for windows - Powershell): `where.exe pdflatex`
    - (for Mac / Linux - Bash): `which pdflatex`

Use the resulting file pathway *without* the pdflatex. You want the path to the executable, not the executable itself. 

Example (from MacOS)
```
PDFLATEX_PATH=/Library/TeX/texbin/
```

## Deploying Your Application
When you deploy your Laravel application with R to the server, you will need to add some additional scripts to setup the R environment. It is recommended to use Renv, which is setup automatically when you run `php artisan rsetup r`. 

- During development of your R scripts, make sure you run `renv::snapshot()` after installing packages. This will update a `renv.lock` file.
- Make sure you install R onto your server (or where-ever you are deploying your application). Follow the instructions for your OS. For example, [here](https://linuxize.com/post/how-to-install-r-on-ubuntu-20-04/) is a guide for installing R on Ubuntu 20.04. 
- If you use RMarkdown, you also need to install Pandoc (full instructions [here](https://pandoc.org/installing.html#linux), and maybe a pdf renderer like TexLive. 
- You also need to add the correct .env variables.
- In your deployment script, add `cd scripts/R && Rscript -e "renv::restore()"`. You can do this at anytime, but I usually put it just after `npm install`.



## License

This repo is covered by an [MIT License (MIT)](LICENCE.md). You are free to copy, use, modify and distribute this package, and it would be lovely if you would credit Stats4SD where-ever you use it. 



