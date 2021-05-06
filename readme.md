To run the application, in the project directory, run the following command:
``` 
docker-compose up -d --build
```
After the docker container is running, open in browser:
http://localhost:9090/

To run the unit tests, run the following command:
```
docker-compose exec test-hero bash
cd ..
./vendor/bin/phpunit tests 
```