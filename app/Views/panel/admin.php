<?php /** @var array $users */ /** @var array $tags */ /** @var array $topics */ ?>
<h2 style="margin:8px 0 16px">Admin – Dashboard</h2>

<!-- Cartes d'accès avec boutons (scroll fluide vers les sections) -->
<div class="grid grid-3" style="margin-bottom:16px">
  <div class="card">
    <h3>Users</h3>
    <p class="meta">Change roles, delete.</p>
    <div class="form-row"><a class="btn" href="#users">Manage</a></div>
  </div>
  <div class="card">
    <h3>Tags</h3>
    <p class="meta">Create / delete tags.</p>
    <div class="form-row"><a class="btn outline" href="#tags">Manage</a></div>
  </div>
  <div class="card">
    <h3>Topics</h3>
    <p class="meta">Open / close / pin / delete.</p>
    <div class="form-row"><a class="btn ghost" href="#admin-topics">Manage</a></div>
  </div>
</div>

<!-- ===== SECTION UTILISATEURS ===== -->
<div class="card" id="users">
  <h3>Users</h3>
  <table>
    <tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Actions</th></tr>
    <?php foreach($users as $u): ?>
      <?php $formId = 'role-form-' . $u['id']; ?>
      <tr>
        <td><?= $u['id'] ?></td>
        <td><?= e($u['name']) ?></td>
        <td><?= e($u['email']) ?></td>

        <!-- Colonne Rôle : plus de bouton "Maj" ici -->
        <td>
          <select name="role" form="<?= $formId ?>">
            <?php foreach(['user','mod','admin'] as $r): ?>
              <option value="<?= $r ?>"<?= $u['role']===$r?' selected':'' ?>><?= $r ?></option>
            <?php endforeach; ?>
          </select>
        </td>

        <!-- Colonne Actions : Sauvegarder + Supprimer -->
        <td class="actions">
          <!-- Formulaire pour sauvegarder le rôle -->
          <form id="<?= $formId ?>" method="post" action="/panel/admin/users/<?= $u['id'] ?>/role" style="display:inline">
            <?= $csrf->field() ?>
            <button class="btn sm">Save</button>
          </form>

          <!-- Formulaire supprimer -->
          <form method="post" action="/panel/admin/users/<?= $u['id'] ?>/delete" style="display:inline"
                onsubmit="return confirm('Delete this user?')">
            <?= $csrf->field() ?>
            <button class="btn danger sm">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>


<!-- ===== SECTION TAGS ===== -->
<div class="card" id="tags" style="margin-top:16px">
  <h3>Tags</h3>
  <form class="form-row" method="post" action="/panel/admin/tags/create">
    <?= $csrf->field() ?>
    <input name="name" placeholder="New tag" required>
    <button class="btn">Create</button>
  </form>
  <ul class="chips">
    <?php foreach($tags as $t): ?>
      <li class="chip">
        <?= e($t['name']) ?>
        <form method="post" action="/panel/admin/tags/<?= $t['id'] ?>/delete" style="display:inline"
              onsubmit="return confirm('Delete this tag?')">
          <?= $csrf->field() ?>
          <button class="btn ghost sm" title="Delete">✕</button>
        </form>
      </li>
    <?php endforeach; ?>
  </ul>
</div>

<!-- ===== SECTION SUJETS ===== -->
<div class="card" id="admin-topics" style="margin-top:16px">
  <h3>Topics</h3>

  <table class="topics-table">
    <thead>
      <tr>
        <th class="topics-title">Title</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($topics as $t): ?>
        <?php
          $isOpen    = ($t['status'] === 'open');
          $isPinned  = !empty($t['pinned_at']);
          $lblToggle = $isOpen ? 'Close' : 'Open';
          $lblPin    = $isPinned ? 'Unpin' : 'Pin';
        ?>
        <tr>
          <td class="topics-title">
            <?php if($isPinned): ?>
              <span class="icon-pin" title="Pinned" aria-label="Pinned">📌</span>
            <?php endif; ?>
            <a href="/topics/<?= $t['id'].'-'.$t['slug'] ?>" title="<?= e($t['title']) ?>">
              <?= e($t['title']) ?>
            </a>
          </td>

          <td>
            <span class="badge <?= $isOpen ? 'open' : 'closed' ?>">
              <?= e($t['status']) ?>
            </span>
          </td>

          <td>
            <div class="actions">
              <form method="post" action="/panel/admin/topics/<?= $t['id'] ?>/toggle">
                <?= $csrf->field() ?>
                <button class="btn sm"><?= $lblToggle ?></button>
              </form>

              <form method="post" action="/panel/admin/topics/<?= $t['id'] ?>/pin">
                <?= $csrf->field() ?>
                <button class="btn outline sm"><?= $lblPin ?></button>
              </form>

              <form method="post" action="/panel/admin/topics/<?= $t['id'] ?>/delete"
                    onsubmit="return confirm('Delete this topic and all its replies/votes?')">
                <?= $csrf->field() ?>
                <button class="btn danger sm">Delete</button>
              </form>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
