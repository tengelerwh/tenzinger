# tenzinger
Assessment for Tenzinger

# REST API
GET /employees/{employeeId}/travels/{year-month} - return travels for given employee and given year and month
GET /employees/all/travels/{year-month}  - return travels for all employees for given year and month
POST /employees/{employeeId}/travels - Add travel for given employee (day is given in payload)
PUT /employees/{employeeId}/travels - Update travel for given employee (day is given in payload)
