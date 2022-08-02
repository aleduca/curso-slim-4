<?php $this->layout('site/master') ?>

<h2>Create</h2>

<form action="/user/store" method="post">
  <input type="text" name="firstName" class="form-control" value="<?php echo old('firstName') ?>" placeholder="FirstName" />

  <?php echo getFlash('firstName'); ?>

  <br />
  <input type="text" name="lastName" class="form-control" value="<?php echo old('lastName') ?>" placeholder="LastName" />

  <?php echo getFlash('lastName'); ?>
  <br />
  <input
  placeholder="Email"
  type="text"
  name="email"
  class="form-control"
  value="<?php echo old('email') ?>"
  />
  <?php echo getFlash('email'); ?>
  <br />
  <input type="password" name="password" class="form-control" value="" placeholder="Password" />
  <?php echo getFlash('password'); ?>
  <br />
  <button type="submit">Cadastrar</button>
</form>

