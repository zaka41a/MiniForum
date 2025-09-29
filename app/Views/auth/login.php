<h2>Login</h2>
<form method="post" action="/login" class="card">
  <?= $csrf->field() ?>
  <label>Email<input type="email" name="email" required></label>
  <label>Password<input type="password" name="password" required></label>
  <button class="btn">Log in</button>
  <p class="small">No account? <a href="/register">Sign up</a>.</p>
</form>
