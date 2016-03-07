# File Tasks
## Concat


Merges files into one. Used for preparing assets.

``` php
<?php
$this->taskConcat([
     'web/assets/screen.css',
     'web/assets/print.css',
     'web/assets/theme.css'
 ])
 ->to('web/assets/style.css')
 ->run()
?>
```

* `to($dst)`  set the destination file
* `addToCollection($collection, $taskName = null, $rollbackTask = null)` 
* `addAsRollback($collection)` 
* `addAsCompletion($collection)` 
* `addToCollectionAndIgnoreErrors($collection, $taskName = null)` 

## Replace


Performs search and replace inside a files.

``` php
<?php
$this->taskReplaceInFile('VERSION')
 ->from('0.2.0')
 ->to('0.3.0')
 ->run();

$this->taskReplaceInFile('README.md')
 ->from(date('Y')-1)
 ->to(date('Y'))
 ->run();

$this->taskReplaceInFile('config.yml')
 ->regex('~^service:~')
 ->to('services:')
 ->run();

$this->taskReplaceInFile('box/robo.txt')
 ->from(array('##dbname##', '##dbhost##'))
 ->to(array('robo', 'localhost'))
 ->run();
?>
```

* `regex(string)`  regex to match string to be replaced
* `from(string|array)`  string(s) to be replaced
* `to(string|array)`  value(s) to be set as a replacement

* `addToCollection($collection, $taskName = null, $rollbackTask = null)` 
* `addAsRollback($collection)` 
* `addAsCompletion($collection)` 
* `addToCollectionAndIgnoreErrors($collection, $taskName = null)` 

## TmpFile


Create a temporary file that is automatically cleaned up
once the task collection is is part of completes. When created,
it is given a random filename.

This temporary file may be manipulated exacatly like taskWrite().

``` php
<?php
$tmpFilePath = $this->taskTmpFile()
     ->line('-----')
     ->line(date('Y-m-d').' '.$title)
     ->line('----')
     ->addToCollection($collection)
     ->getPath();
?>
```

* `complete()`  Delete this file when our collection completes.
* `line($line)`  add a line.
* `lines(array $lines)`  add more lines.
* `text($text)`  add a text.
* `textFromFile($filename)`  add a text from a file.
* `place($name, $val)`  substitute a placeholder with value, placeholder must be enclosed by `{}`.
* `replace($string, $replacement)`  replace any string with value.
* `regexReplace($pattern, $replacement)`  replace any string with value using regular expression.
* `getPath()` 
* `addToCollection($collection, $taskName = null, $rollbackTask = null)` 
* `addAsRollback($collection)` 
* `addAsCompletion($collection)` 
* `addToCollectionAndIgnoreErrors($collection, $taskName = null)` 

## Write


Writes to file.

``` php
<?php
$this->taskWriteToFile('blogpost.md')
     ->line('-----')
     ->line(date('Y-m-d').' '.$title)
     ->line('----')
     ->run();
?>
```

* `append()` 

* `line($line)`  add a line.
* `lines(array $lines)`  add more lines.
* `text($text)`  add a text.
* `textFromFile($filename)`  add a text from a file.
* `place($name, $val)`  substitute a placeholder with value, placeholder must be enclosed by `{}`.
* `replace($string, $replacement)`  replace any string with value.
* `regexReplace($pattern, $replacement)`  replace any string with value using regular expression.
* `getPath()` 
* `addToCollection($collection, $taskName = null, $rollbackTask = null)` 
* `addAsRollback($collection)` 
* `addAsCompletion($collection)` 
* `addToCollectionAndIgnoreErrors($collection, $taskName = null)` 

