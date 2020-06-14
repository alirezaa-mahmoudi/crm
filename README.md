# Customers API Provider
This project provides the REST API for managing customers. To implement it, I have used symfony 5.1 and taken advantage of api-platform. The libraries that used in the project listed blow: 
1. Symfony 5.1
2. api-platform
3. lexik/jwt-authentication-bundle


# API
- Login: The endpoint provides jwt token for authentication. Through this token user can call customer APIs
```
METHOD: POST    http://[server]/api/login 
parameters = {
                  "username": "admin@admin.com",
                  "password": "admin123456"
              }
```
- List of Customers 
```
METHOD: GET   http://[server]/api/customers/list

```
- List of Customers with pagination
```
METHOD: GET   http://[server]/api/customers/list?page=2
METHOD: GET   http://[server]/api/customers/list?itemsPerPage=20'

```
- Search in Customer List
```
METHOD: GET   http://[server]/api/customers/list?id,id[],firstName,lastName,company,company[],phone
METHOD: GET   http://[server]/api/customers/list?firstName=Luis
```
- Sort Customer List
```
METHOD: GET   http://[server]/api/customers/list?sortby[id],sortby[firstName],sortby[lastName],sortby[company]
```
- Create a Customer
```
METHOD: POST   http://[server]/api/customers/create
```
- Update a Customer
```
METHOD: PUT   http://[server]/api/customers/update/{id}
```
- Delete a Customer
```
METHOD: Delete   http://[server]/api/customers/delete/{id}
```

# Setup
- PHP 7.4.6
- `composer install`
- create schema `doctrine:schema:update --force`
- load fixtures `doctrine:fixture:load`
- use the `symfony serve` or the builtin php server 
