<?php
require_once __DIR__ . '/includes/db.php';
$lang = $_GET['lang'] ?? ($_SESSION['lang'] ?? 'ar');
include __DIR__ . '/templates/header.php';

$stmt = $pdo->query('SELECT l.*, c.name_en, c.name_ar FROM lectures l LEFT JOIN courses c ON l.course_id=c.id ORDER BY l.uploaded_at DESC');
$lectures = $stmt->fetchAll();
?>
<h3><?= $lang==='ar' ? 'المحاضرات' : 'Lectures' ?></h3>
<div class="row">
<?php foreach($lectures as $l): ?>
  <div class="col-md-4">
    <div class="card mb-3">
      <div class="card-body">
        <h5><?= htmlspecialchars($lang==='ar' ? $l['title_ar'] : $l['title_en']) ?></h5>
        <p><?= htmlspecialchars($lang==='ar' ? $l['name_ar'] : $l['name_en']) ?></p>
        <a href="/uploads/lectures/<?= urlencode($l['filename']) ?>" class="btn btn-sm btn-primary">Download</a>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php include __DIR__ . '/templates/footer.php'; ?>