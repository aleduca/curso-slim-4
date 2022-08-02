<?php $this->layout('site/master') ?>

<h2>login</h2>
<?php echo getFlash('message'); ?>

<form action="/login" method="post">
  <input
    type="text"
    name="email"
    class="form-control"
    value="xandecar@hotmail.com"
    placeholder="seu email"
  />
  <?php echo getFlash('email'); ?>
  <br />
  <input
    type="password"
    name="password"
    class="form-control"
    value="123"
    placeholder="sua senha"
  />
  <?php echo getFlash('password'); ?>

  <button type="submit" class="btn btn-info" id="btn-create">Logar</button>
</form>