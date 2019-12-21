```
mysql -uroot -p < db/init.sql
mysql -uroot -p < db/scheama.sql
php -S localhost:8000 src/main.php
```

```
curl http://localhost:8000/customers
curl -X POST -H 'Content-Type: application/x-www-form-urlencoded' -d "name=Foo" http://localhost:8000/customers
curl -X POST -H 'Content-Type: application/x-www-form-urlencoded' -d "name=Bar" http://localhost:8000/customers
curl http://localhost:8000/customers
curl -X PUT -H 'Content-Type: application/x-www-form-urlencoded' -d "name=Baz&isActive=0" http://localhost:8000/customers/1
curl http://localhost:8000/customers
curl http://localhost:8000/customers/1
curl -X DELETE -H 'Content-Type: application/x-www-form-urlencoded' http://localhost:8000/customers/2
curl http://localhost:8000/customers
curl http://localhost:8000/customers/2
```
