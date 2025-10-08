<?php
require_once __DIR__ . '/includes/db.php';
session_start();
$lang = $_GET['lang'] ?? ($_SESSION['lang'] ?? 'ar');
if(!isset($_SESSION['user'])) { header('Location: /login.php?lang='.$lang); exit; }
$user = $_SESSION['user'];
include __DIR__ . '/templates/header.php';
?>
<div class="container">
  <h3>Dashboard - <?= htmlspecialchars($user['username']) ?></h3>
  <?php if($user['role']==='staff'): ?>
    <p><a class="btn btn-success" href="/upload_lecture.php?lang=<?= $lang ?>"><?= $lang==='ar' ? 'رفع محاضرة' : 'Upload Lecture' ?></a></p>
    <p><a class="btn btn-secondary" href="/admin/logout.php?lang=<?= $lang ?>"><?= $lang==='ar' ? 'تسجيل خروج' : 'Logout' ?></a></p>
  <?php elseif($user['role']==='student'): ?>
    <p><a class="btn btn-primary" href="/results.php?lang=<?= $lang ?>"><?= $lang==='ar' ? 'عرض النتائج' : 'View Results' ?></a></p>
    <p><a class="btn btn-secondary" href="/admin/logout.php?lang=<?= $lang ?>"><?= $lang==='ar' ? 'تسجيل خروج' : 'Logout' ?></a></p>
  <?php else: ?>
    <p><a class="btn btn-secondary" href="/admin/dashboard.php?lang=<?= $lang ?>"><?= $lang==='ar' ? 'لوحة الإدارة' : 'Admin Panel' ?></a></p>
  <?php endif; ?>
</div>
<?php include __DIR__ . '/templates/footer.php'; ?>