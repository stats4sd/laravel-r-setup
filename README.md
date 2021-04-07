# Laravel R Setup

This helper package can be used to quickly scaffold an R project within the main Laravel project.

Often, we have found the need to pass particular tasks out to R, for example advanced data processing, statistical analysis, or generation of customisable reports through RMarkdown. In these cases, we want to initialise an R project within a sub-folder of the main Laravel application. 

## Requirements
To use this package locally, you must have R installed, and you should have installed the renv library locally (`install.packages('renv')` in R).

> NOTE: This package does not help with installing R on your local development machine, OR on the server you deploy to. You should handle that separately! 
 
TODO: Add a link to deployment script...

## Quick Start

To get started: 

1. require the package as a dev dependency: `composer require stats4sd/laravel-r-setup`.
2. Run `php artisan rsetup r`. 
   
This will create a new RStudio project with some example files in `scripts/R`.   

## More Details

The following provides more details on what files are actually created and added to your project. 

### Setup a basic R environment:

To run the basic setup, run `php artisan rsetup r`. This will give you an RStudio project inside the `scripts/R` folder, which includes:
 - **An `init.R` script**: This connects R to the same .env file that Laravel uses, and adds a function to connect to the Laravel database.
 - **An `example.R` script**: This provides an example to show how to connect to the database in your scripts. It also acts as a quick test to ensure the setup is working. 
   - Run this script to test your setup. A `user-test.csv` file should be created, containing a list of users in your Laravel application database.
     
The setup script also initialises renv. Renv is a good way to handle library dependencies across different instances. 

### Setup an RMarkdown enabled environment:

If you need to render RMarkdown documents (e.g. to create pdf files), use the following: `php artisan rsetup rmarkdown`. This will provide you with the basic R environment above, plus the following extras:
 - **A `example-markdown.R` script**: This demonstrates how you can get data from the Laravel database and pass it to a .Rmd file as a parameter. Run this script to generate a pdf output that contains a list of the current users in your Laravel database. 
 - **A `example-markdown.Rmd` file**: This is used together with the example script.

> NOTE: If you intend to produce PDF documents with RMarkdown, you will need to ensure your deployment environment has pdflatex and pandoc installed. You also need to tell R where these applications are located, especially when running R scripts from PHP via Symfony Process.
> 
> We have found a reliable way is to add the following variables to your .env file, and reference them where needed in your R script:
>  - RSTUDIO_PANDOC 
>  - PDFLATEX_PATH 
> 
> Our `init.R` script for r-markdown references the PDFLATEX_PATH variable. The RSTUDIO_PANDOC one is a default variable that RMarkdown references when looking for a version of pandoc to use. 


### How to find your env variables

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

## License

This repo is licensed in the same way as the original repo - with an [MIT License (MIT)](LICENCE.md). 
