# Example file - generates a test csv output file
# This can be used to check that R can be run from CLI and from PHP via Symfony process.
library('dbplyr')
library('dplyr')

# include init script
source('init.R')


# get connection to platform database
con <- get_db()

# get data from users table (to test it works)
users <- tbl(con, 'users') %>%
    select('id', 'email') %>%
    collect()


# export csv file
write.csv(users, "user-test.csv", row.names = FALSE)





