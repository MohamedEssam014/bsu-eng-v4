<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!=='admin'){ header('Location: /login.php'); exit; }
if($_SERVER['REQUEST_METHOD']==='POST'){
    $code = $_POST['course_code']; $name_en = $_POST['name_en']; $name_ar = $_POST['name_ar'];
    $stmt = $pdo->prepare('INSERT INTO courses (course_code, name_en, name_ar) VALUES (?,?,?)');
    $stmt->execute([$code,$name_en,$name_ar]);
    header('Location: /admin/dashboard.php');
    exit;
}
include __DIR__ . '/../templates/header.php';
?>
<form method="post">
  <div class="mb-3"><label>Course Code</label><input name="course_code" class="form-control"></div>
  <div class="mb-3"><label>Name EN</label><input name="name_en" class="form-control"></div>
  <div class="mb-3"><label>Name AR</label><input name="name_ar" class="form-control"></div>
  <button class="btn btn-success">Add</button>
</form>
<?php include __DIR__ . '/../templates/footer.php'; ?>