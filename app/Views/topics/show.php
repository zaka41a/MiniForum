<article class="topic card">
  <h2 style="margin:4px 0 6px"><?= e($topic['title']) ?>
    <?php if(!empty($topic['pinned_at'])): ?><span class="badge pin">Pinned</span><?php endif;?>
    <span class="badge <?= e($topic['status']) ?>"><?= e($topic['status']) ?></span>
  </h2>
  <div class="meta" style="color:var(--muted)">Created on <?= e($topic['created_at']) ?></div>
  <div class="body"><?= $md->toHtml(e($topic['body'])) ?></div>
</article>

<section class="posts card" style="margin-top:14px">
  <h3>Replies</h3>
  <?php foreach($posts as $p): ?>
    <div class="post" data-id="<?= $p['id'] ?>">
      <aside class="vote">
        <form class="vote-form" method="post" action="/posts/<?= $p['id'] ?>/vote">
          <input type="hidden" name="_token" value="<?= $csrf->token() ?>">
          <button name="value" value="1" type="submit" class="btn ghost sm">▲</button>
          <span class="score" style="font-weight:700"><?= (int)$p['_score'] ?></span>
          <button name="value" value="-1" type="submit" class="btn ghost sm">▼</button>
        </form>
      </aside>
      <div class="content" style="flex:1">
        <div class="meta">by <strong><?= e($p['name']) ?></strong> — <?= e($p['created_at']) ?></div>
        <div class="body"><?= $md->toHtml(e($p['body'])) ?></div>
      </div>
    </div>
  <?php endforeach; ?>
</section>

<?php if($auth->check() && $topic['status']==='open'): ?>
  <form method="post" action="/topics/<?= $topic['id'] ?>/reply" class="card" style="margin-top:14px">
    <input type="hidden" name="_token" value="<?= $csrf->token() ?>">
    <input type="hidden" name="slug" value="<?= e($topic['slug']) ?>">
    <label>Your reply</label>
    <textarea name="body" required rows="5"></textarea>
    <div class="form-row"><button class="btn">Publish</button></div>
  </form>
<?php elseif($topic['status']!=='open'): ?>
  <p class="badge closed">Topic closed</p>
<?php else: ?>
  <p><a class="btn" href="/login">Log in</a> to vote and reply.</p>
<?php endif; ?>
