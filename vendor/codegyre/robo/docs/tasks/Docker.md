# Docker Tasks

## Build


Builds Docker image

```php
<?php
$this->taskDockerBuild()->run();

$this->taskDockerBuild('path/to/dir')
     ->tag('database')
     ->run();

?>

```

Class Build
@package Robo\Task\Docker

* `tag($tag)` 
* `addToCollection($collection, $taskName = null, $rollbackTask = null)` 
* `addAsRollback($collection)` 
* `addAsCompletion($collection)` 
* `addToCollectionAndIgnoreErrors($collection, $taskName = null)` 
* `dir($dir)`  changes working directory of command
* `printed($arg)`  Should command output be printed
* `arg($arg)`  Pass argument to executable
* `args($args)`  Pass methods parameters as arguments to executable
* `option($option, $value = null)`  Pass option to executable. Options are prefixed with `--` , value can be provided in second parameter.
* `optionList($option, $value = null)`  Pass multiple options to executable. Value can be a string or array.

## Commit


Commits docker container to an image

```
$this->taskDockerCommit($containerId)
     ->name('my/database')
     ->run();

// alternatively you can take the result from DockerRun task:

$result = $this->taskDockerRun('db')
     ->exec('./prepare_database.sh')
     ->run();

$task->dockerCommit($result)
     ->name('my/database')
     ->run();
```

* `name($name)` 
* `addToCollection($collection, $taskName = null, $rollbackTask = null)` 
* `addAsRollback($collection)` 
* `addAsCompletion($collection)` 
* `addToCollectionAndIgnoreErrors($collection, $taskName = null)` 
* `dir($dir)`  changes working directory of command
* `printed($arg)`  Should command output be printed
* `arg($arg)`  Pass argument to executable
* `args($args)`  Pass methods parameters as arguments to executable
* `option($option, $value = null)`  Pass option to executable. Options are prefixed with `--` , value can be provided in second parameter.
* `optionList($option, $value = null)`  Pass multiple options to executable. Value can be a string or array.

## Exec


Executes command inside running Docker container

```php
<?php
$test = $this->taskDockerRun('test_env')
     ->detached()
     ->run();

$this->taskDockerExec($test)
     ->interactive()
     ->exec('./runtests')
     ->run();

// alternatively use commands from other tasks

$this->taskDockerExec($test)
     ->interactive()
     ->exec($this->taskCodecept()->suite('acceptance'))
     ->run();
?>
```


* `detached()` 
* `interactive()` 
* `exec($command)` 
* `addToCollection($collection, $taskName = null, $rollbackTask = null)` 
* `addAsRollback($collection)` 
* `addAsCompletion($collection)` 
* `addToCollectionAndIgnoreErrors($collection, $taskName = null)` 
* `dir($dir)`  changes working directory of command
* `printed($arg)`  Should command output be printed
* `arg($arg)`  Pass argument to executable
* `args($args)`  Pass methods parameters as arguments to executable
* `option($option, $value = null)`  Pass option to executable. Options are prefixed with `--` , value can be provided in second parameter.
* `optionList($option, $value = null)`  Pass multiple options to executable. Value can be a string or array.

## Pull


Pulls an image from DockerHub

```php
<?php
$this->taskDockerPull('wordpress')
     ->run();

?>
```


* `addToCollection($collection, $taskName = null, $rollbackTask = null)` 
* `addAsRollback($collection)` 
* `addAsCompletion($collection)` 
* `addToCollectionAndIgnoreErrors($collection, $taskName = null)` 
* `dir($dir)`  changes working directory of command
* `printed($arg)`  Should command output be printed
* `arg($arg)`  Pass argument to executable
* `args($args)`  Pass methods parameters as arguments to executable
* `option($option, $value = null)`  Pass option to executable. Options are prefixed with `--` , value can be provided in second parameter.
* `optionList($option, $value = null)`  Pass multiple options to executable. Value can be a string or array.

## Remove


Remove docker container

```php
<?php
$this->taskDockerRemove($container)
     ->run();
?>
```


* `addToCollection($collection, $taskName = null, $rollbackTask = null)` 
* `addAsRollback($collection)` 
* `addAsCompletion($collection)` 
* `addToCollectionAndIgnoreErrors($collection, $taskName = null)` 
* `dir($dir)`  changes working directory of command
* `printed($arg)`  Should command output be printed
* `arg($arg)`  Pass argument to executable
* `args($args)`  Pass methods parameters as arguments to executable
* `option($option, $value = null)`  Pass option to executable. Options are prefixed with `--` , value can be provided in second parameter.
* `optionList($option, $value = null)`  Pass multiple options to executable. Value can be a string or array.


## Run


Performs `docker run` on a container.

```php
<?php
$this->taskDockerRun('mysql')->run();

$result = $this->taskDockerRun('my_db_image')
     ->env('DB', 'database_name')
     ->volume('/path/to/data', '/data')
     ->detached()
     ->publish(3306)
     ->name('my_mysql')
     ->run();

// retrieve container's cid:
$this->say("Running container ".$result->getCid());

// execute script inside container
$result = $this->taskDockerRun('db')
     ->exec('prepare_test_data.sh')
     ->run();

$this->taskDockerCommit($result)
     ->name('test_db')
     ->run();

// link containers
$mysql = $this->taskDockerRun('mysql')
     ->name('wp_db') // important to set name for linked container
     ->env('MYSQL_ROOT_PASSWORD', '123456')
     ->run();

$this->taskDockerRun('wordpress')
     ->link($mysql)
     ->publish(80, 8080)
     ->detached()
     ->run();

?>
```


* `detached()` 
* `interactive()` 
* `exec($run)` 
* `volume($from, $to = null)` 
* `env($variable, $value = null)` 
* `publish($port = null, $portTo = null)` 
* `containerWorkdir($dir)` 
* `user($user)` 
* `privileged()` 
* `name($name)` 
* `link($name, $alias)` 
* `addToCollection($collection, $taskName = null, $rollbackTask = null)` 
* `addAsRollback($collection)` 
* `addAsCompletion($collection)` 
* `addToCollectionAndIgnoreErrors($collection, $taskName = null)` 
* `dir($dir)`  changes working directory of command
* `printed($arg)`  Should command output be printed
* `arg($arg)`  Pass argument to executable
* `args($args)`  Pass methods parameters as arguments to executable
* `option($option, $value = null)`  Pass option to executable. Options are prefixed with `--` , value can be provided in second parameter.
* `optionList($option, $value = null)`  Pass multiple options to executable. Value can be a string or array.

## Start


Starts Docker container

```php
<?php
$this->taskDockerStart($cidOrResult)
     ->run();
?>
```

* `addToCollection($collection, $taskName = null, $rollbackTask = null)` 
* `addAsRollback($collection)` 
* `addAsCompletion($collection)` 
* `addToCollectionAndIgnoreErrors($collection, $taskName = null)` 
* `dir($dir)`  changes working directory of command
* `printed($arg)`  Should command output be printed
* `arg($arg)`  Pass argument to executable
* `args($args)`  Pass methods parameters as arguments to executable
* `option($option, $value = null)`  Pass option to executable. Options are prefixed with `--` , value can be provided in second parameter.
* `optionList($option, $value = null)`  Pass multiple options to executable. Value can be a string or array.

## Stop


Stops Docker container

```php
<?php
$this->taskDockerStop($cidOrResult)
     ->run();
?>
```

* `addToCollection($collection, $taskName = null, $rollbackTask = null)` 
* `addAsRollback($collection)` 
* `addAsCompletion($collection)` 
* `addToCollectionAndIgnoreErrors($collection, $taskName = null)` 
* `dir($dir)`  changes working directory of command
* `printed($arg)`  Should command output be printed
* `arg($arg)`  Pass argument to executable
* `args($args)`  Pass methods parameters as arguments to executable
* `option($option, $value = null)`  Pass option to executable. Options are prefixed with `--` , value can be provided in second parameter.
* `optionList($option, $value = null)`  Pass multiple options to executable. Value can be a string or array.

