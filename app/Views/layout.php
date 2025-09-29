<?php $u = $_SESSION['user'] ?? null; $flash = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); ?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title ?? 'MiniForum') ?></title>
<link rel="stylesheet" href="/assets/app.css">
<script defer src="/assets/app.js"></script>
</head><body>
<header class="container">
  <a href="/" class="brand">MiniForum</a>
  <nav>
    <a href="/topics">Topics</a>
    <?php if($u): ?>
      <a href="/topics/new">New Topic</a>
      <?php if($u['role']==='admin'): ?><a href="/panel/admin">Admin</a><?php endif; ?>
      <?php if($u['role']==='mod'): ?><a href="/panel/mod">Mod</a><?php endif; ?>

      <span class="userpill">
        <span class="avatar"><?= strtoupper($u['name'][0] ?? 'U') ?></span>
        <strong><?= e($u['name']) ?></strong>
      </span>
      <form action="/logout" method="post" style="display:inline">
        <?= $csrf->field() ?? '' ?>
        <button class="btn danger sm">Log out</button>
      </form>

    <?php else: ?>
      <a class="btn ghost sm" href="/login">Login</a>
      <a class="btn sm" href="/register">Sign Up</a>
    <?php endif; ?>
  </nav>
</header>
<main class="container">
  <?php if($flash): ?><div class="flash"><?= e($flash) ?></div><?php endif; ?>
  <?= $content ?? '' ?>
</main>
<footer class="container" style="color:var(--muted);font-size:.9rem">© MiniForum</footer>
</body></html>
