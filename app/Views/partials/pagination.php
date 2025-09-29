<?php
// Attendu: $page, $pages, $q, $tag
if (!isset($page, $pages) || $pages <= 1) { return; }

$base = '/topics?';
if (!empty($q))   { $base .= 'search=' . urlencode($q) . '&'; }
if (!empty($tag)) { $base .= 'tag='    . urlencode($tag) . '&'; }
?>
<nav class="pagination">
  <?php for ($i = 1; $i <= $pages; $i++): ?>
    <?php if ($i === $page): ?>
      <span class="active"><?= $i ?></span>
    <?php else: ?>
      <a href="<?= $base . 'page=' . $i ?>"><?= $i ?></a>
    <?php endif; ?>
  <?php endfor; ?>
</nav>
