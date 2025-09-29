<h2 style="margin:8px 0 16px">Moderation</h2>

<!-- 2 access cards with real buttons -->
<div class="grid grid-2" style="margin-bottom:16px">
  <div class="card">
    <h3>Topics</h3>
    <p class="meta">Open / close topics.</p>
    <div class="form-row">
      <a class="btn" href="#topics">Go to topics</a>
    </div>
  </div>

  <div class="card">
    <h3>Vote management</h3>
    <p class="meta">View recent posts and reset votes.</p>
    <div class="form-row">
      <a class="btn outline" href="#votes">Go to votes</a>
    </div>
  </div>
</div>

<!-- Section TOPICS -->
<div class="card" id="topics">
  <h3>Topics</h3>
  <table>
    <tr><th>#</th><th>Title</th><th>Status</th><th>Actions</th></tr>
    <?php foreach($topics as $t): ?>
      <tr>
        <td><?= $t['id'] ?></td>
        <td><a href="/topics/<?= $t['id'].'-'.$t['slug'] ?>"><?= e($t['title']) ?></a></td>
        <td><span class="badge <?= e($t['status']) ?>"><?= e($t['status']) ?></span></td>
        <td class="actions">
          <form method="post" action="/panel/mod/topics/<?= $t['id'] ?>/toggle">
            <?= $csrf->field() ?>
            <button class="btn sm">Open/Close</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

<!-- Section VOTES -->
<div class="card" id="votes" style="margin-top:16px">
  <h3>Vote management</h3>
  <table>
    <tr><th>Post</th><th>Topic</th><th>Author</th><th>Score</th><th>Actions</th></tr>
    <?php foreach($posts as $p): ?>
      <tr>
        <td>#<?= $p['id'] ?></td>
        <td><a href="/topics/<?= $p['topic_id'].'-'.$p['slug'] ?>"><?= e($p['title']) ?></a></td>
        <td><?= e($p['name']) ?></td>
        <td><strong><?= (int)$p['score'] ?></strong></td>
        <td class="actions">
          <form method="post" action="/panel/mod/votes/<?= $p['id'] ?>/reset" onsubmit="return confirm('Reset votes for this post?')">
            <?= $csrf->field() ?>
            <button class="btn warn sm">Reset votes</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>
