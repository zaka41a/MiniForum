<section class="hero">
  <h1>Welcome to MiniForum</h1>
  <p>A modern Questions & Answers platform built with native PHP.<br>Share knowledge, engage with the community, and grow together.</p>
  <?php if(!$auth->check()): ?>
    <div class="form-row" style="justify-content:center;margin-top:24px">
      <a class="btn" href="/register">Get Started</a>
      <a class="btn ghost" href="/login">Login</a>
    </div>
  <?php endif; ?>
</section>

<?php
$logged = $auth->check();
$role   = $logged ? $auth->role() : null;
?>

<form class="form-row card" method="get" action="/topics">
  <input type="text" name="search" placeholder="Full-text search…" value="<?= e($q ?? '') ?>">
  <button class="btn">Search</button>
  <a class="btn outline" href="<?= $logged ? '/topics/new' : '/login' ?>">New Topic</a>
</form>

<ul class="list card" style="margin-top:12px">
  <?php foreach($topics as $t): ?>
    <li class="item">
      <div>
        <a href="/topics/<?= $t['id'] . '-' . e($t['slug']) ?>"><strong><?= e($t['title']) ?></strong></a>
        <div class="meta">
          <?php if(!empty($t['pinned_at'])): ?><span class="badge pin">Pinned</span><?php endif; ?>
          <span class="badge <?= e($t['status']) ?>"><?= e($t['status']) ?></span>
          • <?= e($t['created_at']) ?>
        </div>
      </div>
    </li>
  <?php endforeach; ?>
</ul>

<?php require __DIR__ . '/partials/pagination.php'; ?>
