library(RMariaDB)
library(dotenv)

dotenv::load_dot_env("../../.env")

get_db <- function() {
    return(dbConnect(RMariaDB::MariaDB(),
                 dbname = Sys.getenv("DB_DATABASE"),
                 host = Sys.getenv("DB_HOST"),
                 port = as.integer(Sys.getenv("DB_PORT")),
                 user = Sys.getenv("DB_USERNAME"),
                 password = Sys.getenv("DB_PASSWORD")
    ))
}
