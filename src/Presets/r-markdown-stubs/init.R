library(RMariaDB)
library(dotenv)

dotenv::load_dot_env("../../.env")

## Include additional environment variables into PATH
## PDFLATEX_PATH should be declared in the .env file, and should point to the installed location of pdflatex (found using `which pdflatex` on a unix server)
Sys.setenv(PATH=paste0(
        Sys.getenv('PDFLATEX_PATH'),
        ':',
        Sys.getenv('PATH')
    )
)

get_db <- function() {
    return(dbConnect(RMariaDB::MariaDB(),
                 dbname = Sys.getenv("DB_DATABASE"),
                 host = Sys.getenv("DB_HOST"),
                 port = as.integer(Sys.getenv("DB_PORT")),
                 user = Sys.getenv("DB_USERNAME"),
                 password = Sys.getenv("DB_PASSWORD")
    ))
}
