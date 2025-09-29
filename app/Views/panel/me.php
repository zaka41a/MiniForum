<h2 style="margin:8px 0 16px">My Space</h2>

<div class="card">
  <div class="form-row">
    <a class="btn" href="/topics/new">Create a topic</a>
    <a class="btn ghost" href="/topics">Browse topics</a>
  </div>
</div>

<div class="grid grid-2" style="margin-top:16px">
  <div class="card">
    <h3>My recent topics</h3>
    <ul class="list">
      <?php foreach($my_topics as $t): ?>
        <li class="item">
          <div>
            <a href="/topics/<?= $t['id'].'-'.$t['slug'] ?>"><strong><?= e($t['title']) ?></strong></a>
            <div class="meta"><span class="badge <?= e($t['status']) ?>"><?= e($t['status']) ?></span> • <?= e($t['created_at']) ?></div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="card">
    <h3>My latest replies</h3>
    <ul class="list">
      <?php foreach($my_posts as $p): ?>
        <li class="item">
          <div>
            <a href="/topics/<?= $p['topic_id'].'-'.$p['slug'] ?>"><strong><?= e($p['title']) ?></strong></a>
            <div class="meta">Replied on <?= e($p['created_at']) ?></div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
