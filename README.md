# GrapheneDB Client for PHP 5.4+

![img](http://www.graphenedb.com/images/logo.png)

A PHP Client for the popular [GrapheneDB](http://www.graphenedb.com) | Neo4j as a Service.

### Requirements

* A GrapheneDB account, you can create one here : https://app.graphenedb.com/signup

### Usage

Require the library with composer :

```bash
composer require neoxygen/graphenedb-client
```

Create the client by providing your GrapheneDB account e-mail and password :

```php

require_once 'vendor/autoload.php';

use Neoxygen\GrapheneDBClient\GrapheneDBClient;

$client = new GrapheneDBClient('graphista@neo4jrocks.com', 'SuPeRp@sSwOrD');
```

#### Create a Neo4j database instance

You need to pass a name for your database, and optionally a neo4j version :

```php
$myNewDB = $client->createDatabase('test');
```

By default, the latest neo4j version will be used (currently 2.1.5)

This will return you a `Neoxygen\GrapheneDBClient\Database` instance, for the available methods of this class read the section `The Database class`.

#### Listing available versions :

```php
$client->getVersions();
```

```
Array
(
    [default] => v215
    [versions] => Array
        (
            [0] => Array
                (
                    [version] => v198
                    [label] => Neo4j Community Edition 1.9.8
                )

            [1] => Array
                (
                    [version] => v204
                    [label] => Neo4j Community Edition 2.0.4
                )

            [2] => Array
                (
                    [version] => v215
                    [label] => Neo4j Community Edition 2.1.5
                )

        )

)
```

#### Getting all your databases

```php
$databases = $client->getDatabases();
```

This will return you a collection of `Neoxygen\GrapheneDBClient\Database` instances.

#### Getting a specific database

You need to provide the name of your database :

```php
$db = $client->getDatabase('test');
```

This will return you an instance of `Neoxygen\GrapheneDBClient\Database`.

#### Deleting a database

You need to provide the `id` of the database you want to delete :

```php
$db = $client->getDatabase('test');
$client->deleteDatabase($db->getId());
```

This will return you true, or throw an exception if the database does not exist.

#### Deleting all databases

```php
$client->deleteAllDatabases();
```

This will return you true, or throw an exception if an error occured on the GrapheneDB server.

#### The Database class

The `Neoxygen\GrapheneDBClient\Database` offers you methods to have informations about your GrapheneDB Neo4j instances :

```php
$db = $client->getDatabase('test');

echo $db->getId(); //42354265476534
echo $db->getName(); // test
echo $db->getNodesLimit(); // 1000
echo $db->getDbLocation(); // us-east-1-New York 
```

For the list of all available methods, check the `Neoxygen\GrapheneDBClient\Database` source code.

---

### Author

Christophe Willemsen [Twitter](https://twitter.com/ikwattro) | [Github](https://github.com/ikwattro)

### License

This library is licensed under the MIT License, check out the `LICENSE` file packaged with the source code.

### Bugs & Contributions

Simple report & PR on the Github Repository.