<h2>New Topic</h2>
<form method="post" action="/topics/create" class="card">
  <?= $csrf->field() ?>
  <label>Title<input name="title" required></label>
  <label>Content<textarea name="body" rows="8" required></textarea></label>

  <fieldset>
    <legend>Tags</legend>
    <ul class="chips">
      <?php foreach($tags as $t): ?>
        <li><label class="chip"><input type="checkbox" name="tags[]" value="<?= $t['id'] ?>"> <?= e($t['name']) ?></label></li>
      <?php endforeach; ?>
    </ul>
  </fieldset>

  <button class="btn">Create</button>
</form>
