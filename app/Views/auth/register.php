<h2>Sign Up</h2>
<form method="post" action="/register" class="card">
  <?= $csrf->field() ?>
  <label>Name<input type="text" name="name" required></label>
  <label>Email<input type="email" name="email" required></label>
  <label>Password<input type="password" name="password" minlength="6" required></label>
  <button class="btn">Create my account</button>
</form>
