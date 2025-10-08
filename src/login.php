<?php
require_once __DIR__ . '/includes/db.php';
session_start();
$lang = $_GET['lang'] ?? ($_SESSION['lang'] ?? 'ar');
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username=?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    if($user && password_verify($password, $user['password_hash'])){
        $_SESSION['user'] = ['id'=>$user['id'],'username'=>$user['username'],'role'=>$user['role'],'email'=>$user['email']];
        header('Location: /dashboard.php?lang='.$lang);
        exit;
    } else {
        $error = $lang==='ar' ? 'بيانات الدخول غير صحيحة' : 'Invalid credentials';
    }
}
include __DIR__ . '/templates/header.php';
?>
<div class="container">
  <h3><?= $lang==='ar' ? 'تسجيل الدخول' : 'Login' ?></h3>
  <?php if(!empty($error)): ?><div class="alert alert-danger"><?= htmlspecialchars($error) ?></div><?php endif; ?>
  <form method="post">
    <div class="mb-3"><label>Username</label><input name="username" class="form-control" required></div>
    <div class="mb-3"><label>Password</label><input name="password" type="password" class="form-control" required></div>
    <button class="btn btn-primary"><?= $lang==='ar' ? 'دخول' : 'Login' ?></button>
  </form>
</div>
<?php include __DIR__ . '/templates/footer.php'; ?>