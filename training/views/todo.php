<?php $view->extend('layout.php') ?>
<?php $view['slots']->set('title', $todo['title']) ?>
<p>
    <strong>Id</strong>:
    <?= $todo['id'] ?><br/>
    <strong>Title</strong>:
    <?= $view->escape($todo['title']) ?><br/>
    <strong>Status</strong>:
    <?= $todo['is_done'] ? 'done' : 'not finished' ?>
</p>