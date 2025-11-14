<div style="max-width:480px;margin:40px auto">
  <div style="text-align:center;margin-bottom:32px">
    <h2 style="font-size:32px;margin:0 0 8px;font-weight:800">Welcome Back</h2>
    <p style="color:var(--muted);margin:0">Login to your MiniForum account</p>
  </div>

  <form method="post" action="/login" class="card" style="box-shadow:var(--shadow-lg)">
    <?= $csrf->field() ?>
    <label>Email Address
      <input type="email" name="email" required placeholder="your@email.com">
    </label>
    <label>Password
      <input type="password" name="password" required placeholder="Enter your password">
    </label>
    <button class="btn" style="width:100%;margin-top:12px">Log in</button>
    <p style="text-align:center;margin-top:20px;color:var(--muted);font-size:14px">
      Don't have an account? <a href="/register" style="font-weight:600">Sign up</a>
    </p>
  </form>
</div>
