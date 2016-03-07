<?php $view->extend('layout.php') ?>
<?php $view['slots']->set('title', 'Tasks Management') ?>
<form action="list" method="post">

</form>
<p>
 There are <strong><?php $count ?></strong> tasks.
</p>
<table>
 <thead>
     <tr>
         <th>ID</th>
         <th>Title</th>
         <th>Status</th>
         <th>Actions</th>
     </tr>
 </thead>
 <tbody>
 <?php foreach ($tasks as $todo) : ?>
     <tr>
         <td class="center"><?= $todo['id'] ?></td>
         <td>
             <a href="todo/<?= $todo['id'] ?>">
                 <?= $view->escape($todo['title']) ?>
             </a>
         </td>
         <td class="center">
             <?php if ($todo['is_done']) : ?>
                 <span class="done">done</span>
             <?php else : ?>
                 <a href="list?action=close&id=<?= $todo['id'] ?>">close</a>
             <?php endif ?>
         </td>
         <td class="center">
             <a href="list?action=delete&id=<?= $todo['id'] ?>">delete</a>
         </td>
     </tr>
 <?php endforeach ?>
 </tbody>
</table>