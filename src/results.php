<?php
require_once __DIR__ . '/includes/db.php';
session_start();
$lang = $_GET['lang'] ?? ($_SESSION['lang'] ?? 'ar');
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!=='student'){ header('Location: /login.php?lang='.$lang); exit; }
$student_email = $_SESSION['user']['email'];

$student = $pdo->prepare('SELECT * FROM students WHERE email=?'); $student->execute([$student_email]); $s = $student->fetch();
if(!$s){ echo 'Student not found'; exit; }

$stmt = $pdo->prepare('SELECT r.*, c.name_en, c.name_ar FROM results r JOIN courses c ON r.course_id=c.id WHERE r.student_id=?');
$stmt->execute([$s['id']]);
$results = $stmt->fetchAll();

include __DIR__ . '/templates/header.php';
?>
<h3><?= $lang==='ar' ? 'النتائج' : 'Results' ?></h3>
<table class="table table-bordered">
  <thead class="table-light"><tr><th>#</th><th><?= $lang==='ar' ? 'المقرر' : 'Course' ?></th><th><?= $lang==='ar' ? 'الدرجة' : 'Grade' ?></th><th><?= $lang==='ar' ? 'الفصل' : 'Semester' ?></th></tr></thead>
  <tbody>
    <?php foreach($results as $r): ?>
      <tr><td><?= $r['id'] ?></td><td><?= htmlspecialchars($lang==='ar' ? $r['name_ar'] : $r['name_en']) ?></td><td><?= htmlspecialchars($r['grade']) ?></td><td><?= htmlspecialchars($r['semester']) ?></td></tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php include __DIR__ . '/templates/footer.php'; ?>