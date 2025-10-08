<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/mailer.php';
session_start();
$lang = $_GET['lang'] ?? ($_SESSION['lang'] ?? 'ar');
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!=='staff'){ header('Location: /login.php?lang='.$lang); exit; }
$staff_id = $_SESSION['user']['id'];

$courses = $pdo->query('SELECT * FROM courses')->fetchAll();
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_FILES['lecture_file'])){
    $course_id = $_POST['course_id'] ?? null;
    $title_en = $_POST['title_en'] ?? '';
    $title_ar = $_POST['title_ar'] ?? '';
    $file = $_FILES['lecture_file'];
    if($file['error']===0){
        $target_dir = __DIR__ . '/uploads/lectures/';
        if(!is_dir($target_dir)) mkdir($target_dir, 0755, true);
        $filename = time().'_'.basename($file['name']);
        $target = $target_dir . $filename;
        if(move_uploaded_file($file['tmp_name'], $target)){
            $stmt = $pdo->prepare('INSERT INTO lectures (course_id, staff_id, title_en, title_ar, filename) VALUES (?,?,?,?,?)');
            $stmt->execute([$course_id, $staff_id, $title_en, $title_ar, $filename]);
            // send notifications to subscribed students
            $course = $pdo->prepare('SELECT * FROM courses WHERE id=?'); $course->execute([$course_id]); $c = $course->fetch();
            $subs = $pdo->prepare('SELECT s.email FROM subscriptions sub JOIN students s ON sub.student_id=s.id WHERE sub.course_id=?');
            $subs->execute([$course_id]);
            $downloadLink = ($_SERVER['REQUEST_SCHEME'] ?? 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/uploads/lectures/' . urlencode($filename);
            foreach($subs->fetchAll() as $row){
                if(!empty($row['email'])) sendLectureNotification($row['email'], $c['name_en'], $title_en, $downloadLink);
            }
            $msg = $lang==='ar' ? 'تم رفع المحاضرة وإرسال الإشعارات.' : 'Lecture uploaded and notifications sent.';
        } else { $msg = 'Upload failed.'; }
    } else { $msg = 'File error.'; }
}
include __DIR__ . '/templates/header.php';
?>
<h3><?= $lang==='ar' ? 'رفع محاضرة' : 'Upload Lecture' ?></h3>
<?php if(!empty($msg)): ?><div class="alert alert-info"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
<form method="post" enctype="multipart/form-data">
  <div class="mb-3"><label>Course</label><select name="course_id" class="form-control">
    <?php foreach($courses as $c): ?><option value="<?= $c['id'] ?>"><?= htmlspecialchars($lang==='ar' ? $c['name_ar'] : $c['name_en']) ?></option><?php endforeach; ?>
  </select></div>
  <div class="mb-3"><label>Title (EN)</label><input name="title_en" class="form-control"></div>
  <div class="mb-3"><label>Title (AR)</label><input name="title_ar" class="form-control"></div>
  <div class="mb-3"><label>Lecture PDF</label><input type="file" name="lecture_file" accept="application/pdf" class="form-control"></div>
  <button class="btn btn-success"><?= $lang==='ar' ? 'رفع' : 'Upload' ?></button>
</form>
<?php include __DIR__ . '/templates/footer.php'; ?>