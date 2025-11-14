<div style="max-width:480px;margin:40px auto">
  <div style="text-align:center;margin-bottom:32px">
    <h2 style="font-size:32px;margin:0 0 8px;font-weight:800">Create Account</h2>
    <p style="color:var(--muted);margin:0">Join the MiniForum community today</p>
  </div>

  <form method="post" action="/register" class="card" style="box-shadow:var(--shadow-lg)">
    <?= $csrf->field() ?>
    <label>Full Name
      <input type="text" name="name" required placeholder="Enter your full name">
    </label>
    <label>Email Address
      <input type="email" name="email" required placeholder="your@email.com">
    </label>
    <label>Password
      <input type="password" name="password" minlength="6" required placeholder="Minimum 6 characters">
    </label>
    <button class="btn" style="width:100%;margin-top:12px">Create my account</button>
    <p style="text-align:center;margin-top:20px;color:var(--muted);font-size:14px">
      Already have an account? <a href="/login" style="font-weight:600">Log in</a>
    </p>
  </form>
</div>
