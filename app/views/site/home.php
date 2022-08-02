<?php $this->layout('site/master', ['title' => $title]) ?>

<h2>Home</h2>

<a href="/user/create" class="btn btn-info">Create</a>

<!-- {{ message['message']|message(message['alert'])|raw }} -->

<ul>
  <?php foreach ($users as $user): ?>

  <li>
    <?php echo $user->firstName ?> <?php echo $user->lastName ?> 
    <a href="/user/edit/{{ user.id }}" class="btn btn-success">Editar</a>
    <form action="/user/delete/<?php echo $user->id ?>" method="post">
      <input type="hidden" name="_METHOD" value="DELETE" />
      <button type="submit" class="btn btn-danger">Deletar</button>
    </form>
  </li>

    <?php endforeach ?>
</ul>