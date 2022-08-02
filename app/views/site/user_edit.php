<?php $this->layout('site/master') ?>

<h2>Edit</h2>

{{ messages['message']['message']|message( messages['message']['alert'])|raw }}

<form action="/user/update/{{ user.id }}" method="post">
  <input type="hidden" name="_METHOD" value="PUT" />
  <input
    type="text"
    name="firstName"
    class="form-control"
    value="{{ user.firstName }}"
  />
  <?php echo getFlash('firstName'); ?>

  <br />
  <input
    type="text"
    name="lastName"
    class="form-control"
    value="{{ user.lastName }}"
  />
  <?php echo getFlash('lastName'); ?>
  {{ messages['lastName']['message']|message( messages['lastName']['alert'])|raw
  }}
  <br />
  <input
    type="text"
    name="email"
    class="form-control"
    value="{{ user.email }}"
  />
  <?php echo getFlash('email'); ?>
  {{ messages['email']['message']|message( messages['email']['alert'])|raw }}
  <br />
  <input
    type="password"
    name="password"
    class="form-control"
    value="{{ user.password }}"
  />
  <?php echo getFlash('password'); ?>
  {{ messages['password']['message']|message( messages['password']['alert'])|raw
  }}
  <br />
  <button type="submit">Atualizar</button>
</form>

{% endblock %}
