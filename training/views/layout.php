<!DOCTYPE html>
<html>
<head>
    <meta content="text/html; charset=UTF-8"/>
    <title>
        <?php $view['slots']->output('title', 'Todo Application') ?>
    </title>
    <link rel="stylesheet" type="text/css" href="/style.css"/>
</head>
<body>
    <div id="container">
        <h1><a href="list.php">My Todos List</a></h1>
        <div id="content">
            <?php $view['slots']->output('_content') ?>
        </div>
        <div id="footer">(c) copyright</div>
    </div>
</body>
</html>