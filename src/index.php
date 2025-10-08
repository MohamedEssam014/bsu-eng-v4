<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/auth.php';

// language
$lang = $_GET['lang'] ?? ($_SESSION['lang'] ?? 'ar');
$_SESSION['lang'] = $lang;

// fetch counts and latest news (lectures as sample)
$students_count = $pdo->query('SELECT COUNT(*) as c FROM students')->fetch()['c'];
$courses_count = $pdo->query('SELECT COUNT(*) as c FROM courses')->fetch()['c'];
$latest = $pdo->query('SELECT l.*, c.name_en, c.name_ar FROM lectures l LEFT JOIN courses c ON l.course_id=c.id ORDER BY l.uploaded_at DESC LIMIT 5')->fetchAll();

include __DIR__ . '/templates/header.php';
?>
<div class="container mt-4">
  <div class="row">
    <div class="col-12">
      <div class="jumbotron p-4 bg-primary text-white rounded">
        <h1><?= $lang==='ar' ? 'كلية الهندسة' : 'Faculty of Engineering' ?></h1>
        <p><?= $lang==='ar' ? 'مرحبًا بكم في الموقع الرسمي لكلية الهندسة' : 'Welcome to BSU Faculty of Engineering' ?></p>
      </div>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-md-6"><div class="card p-3"><h5><?= $lang==='ar' ? 'إجمالي الطلاب' : 'Total Students' ?></h5><p class="display-6"><?= $students_count ?></p></div></div>
    <div class="col-md-6"><div class="card p-3"><h5><?= $lang==='ar' ? 'إجمالي المقررات' : 'Total Courses' ?></h5><p class="display-6"><?= $courses_count ?></p></div></div>
  </div>
  <div class="row mt-4">
    <div class="col-12"><h3><?= $lang==='ar' ? 'آخر المحاضرات' : 'Latest Lectures' ?></h3></div>
    <?php foreach($latest as $l): ?>
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
</div>
<?php include __DIR__ . '/templates/footer.php'; ?>