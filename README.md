# UNI

### Req
* Nginx (docroot on www)
* PHP > 5.5 (use password_hash) also work on php7
* DB all sql database supported by PDO

### Installation
* Install composer
* Install vendors
* Run SQL's
```
cd migrations
mysql -utest -ptest -hmysql  < *.sql
 ```
* Change DataBase accesses
```
$conf
	->set(DB_TYPE, 'mysql')
	->set(DB_HOST, 'mysql')
	->set(DB_NAME, 'uni')
	->set(DB_USER, 'test')
	->set(DB_PASS, 'test');
```

