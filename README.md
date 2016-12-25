# Simple user API

## Tests

Run the following command in project root:
 
 ```bash
 # load the fixtures for tests
 ./yii fixture/load "*"
 
 # run all tests
 ./vendor/bin/codecept run
 ```
 
> Please note that all data will be deleted from tables which is used in fixtures.  
So avoid to run it on production environment.