<?php /** @var array $user */ ?>
<div style="max-width:600px;margin:0 auto">
  <div style="margin-bottom:24px">
    <a href="/panel/admin" class="btn ghost sm" style="margin-bottom:16px">← Back to Admin</a>
    <h2 style="font-size:28px;margin:8px 0;font-weight:800">Edit User</h2>
    <p style="color:var(--muted);margin:0">Update user information and password</p>
  </div>

  <form method="post" action="/panel/admin/users/<?= $user['id'] ?>/update" class="card" style="box-shadow:var(--shadow-lg)">
    <?= $csrf->field() ?>

    <div style="background:var(--primary-100);padding:12px;border-radius:12px;margin-bottom:20px">
      <strong>User ID:</strong> <?= $user['id'] ?>
      <br>
      <strong>Member since:</strong> <?= e($user['created_at']) ?>
      <br>
      <strong>Reputation:</strong> <?= (int)$user['reputation'] ?> points
    </div>

    <label>Full Name
      <input type="text" name="name" value="<?= e($user['name']) ?>" required placeholder="Enter full name">
    </label>

    <label>Email Address
      <input type="email" name="email" value="<?= e($user['email']) ?>" required placeholder="user@example.com">
    </label>

    <label>Role
      <select name="role" required>
        <option value="user" <?= $user['role']==='user'?'selected':'' ?>>User</option>
        <option value="mod" <?= $user['role']==='mod'?'selected':'' ?>>Moderator</option>
        <option value="admin" <?= $user['role']==='admin'?'selected':'' ?>>Administrator</option>
      </select>
    </label>

    <div class="hr"></div>

    <h3 style="font-size:18px;margin:16px 0 8px">Change Password</h3>
    <p style="color:var(--muted);font-size:14px;margin:0 0 12px">Leave blank to keep current password</p>

    <label>New Password (optional)
      <input type="password" name="new_password" minlength="6" placeholder="Minimum 6 characters">
    </label>

    <div style="background:#fef3c7;border:1px solid #fde68a;padding:12px;border-radius:12px;margin-top:16px;font-size:14px">
      <strong>⚠️ Warning:</strong> Changing the password will log the user out of all sessions.
    </div>

    <div class="form-row" style="margin-top:24px;gap:12px">
      <button type="submit" class="btn" style="flex:1">Update User</button>
      <a href="/panel/admin" class="btn ghost" style="flex:1;text-align:center">Cancel</a>
    </div>
  </form>
</div>
