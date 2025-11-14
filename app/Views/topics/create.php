<div style="max-width:800px;margin:0 auto">
  <div style="margin-bottom:24px">
    <h2 style="font-size:28px;margin:0 0 8px;font-weight:800">Create New Topic</h2>
    <p style="color:var(--muted);margin:0">Share your question or discussion with the community</p>
  </div>

  <form method="post" action="/topics/create" class="card" style="box-shadow:var(--shadow-lg)">
    <?= $csrf->field() ?>
    <label>Topic Title
      <input name="title" required placeholder="Enter a clear, descriptive title">
    </label>
    <label>Content
      <textarea name="body" rows="10" required placeholder="Describe your topic in detail... (Markdown supported)"></textarea>
    </label>

    <fieldset style="border:1px solid var(--border);border-radius:12px;padding:16px;margin:16px 0">
      <legend style="font-weight:600;padding:0 8px">Tags (Select relevant tags)</legend>
      <ul class="chips">
        <?php foreach($tags as $t): ?>
          <li><label class="chip" style="transition:all .2s ease">
            <input type="checkbox" name="tags[]" value="<?= $t['id'] ?>">
            <span style="font-weight:500"><?= e($t['name']) ?></span>
          </label></li>
        <?php endforeach; ?>
      </ul>
    </fieldset>

    <button class="btn" style="width:100%">Create Topic</button>
  </form>
</div>
