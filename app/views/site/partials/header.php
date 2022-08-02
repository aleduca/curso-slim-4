<div id="header">
  <div>
    <a href="/" class="btn btn-success btn-sm">Home</a>
  </div>
  <div>

    <?php if (isLogged()): ?>
      Bem vindo,
      <?php echo fullname(); ?>
      <a href="/logout" class="btn btn-danger btn-sm">Logout</a>
      <?php else: ?>
        Visitante
        <a href="/login" class="btn btn-warning btn-sm">Login</a>
      <?php endif; ?>
  </div>
</div>
