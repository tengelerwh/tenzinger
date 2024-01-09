# tenzinger
Assessment for Tenzinger

# Set up
Start environment by running `docker-compose up` from the home directory

Run the `bin/host/setup` command from the host machine. This should set up the database and insert some employees and compensation amounts
Employees (id) in the DB: 0001 - 0008

The website is available on localhost by using http://travel-cost.localhost 

# REST API
GET /api/employees/all/compensations/<year>/<month> - return all commute compensations for all employees and given year and month as CSV
GET /api/employees/<employeeId>>/compensations/<year>/<month> - return all commute compensations for the given employee and given year and month as CSV
GET /api/employees/all/compensations/2024/01/html - returns all commute compensations for all employees in Januari 2024 in simple html format

GET /api/employees/all/calculate  - Calculate commute compensations for

# Console command
To calculate the compensations for all employees in a given year and month,
execute `bin/host/calculate` from the host machine
