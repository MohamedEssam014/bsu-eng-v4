<?php
require_once __DIR__ . '/../includes/db.php';
session_start();
$lang = $_GET['lang'] ?? ($_SESSION['lang'] ?? 'ar');
if(!isset($_SESSION['user']) || $_SESSION['user']['role']!=='admin'){ header('Location: /login.php?lang='.$lang); exit; }
include __DIR__ . '/../templates/header.php';
$users = $pdo->query('SELECT * FROM users')->fetchAll();
$courses = $pdo->query('SELECT * FROM courses')->fetchAll();
?>
<h3>Admin Panel</h3>
<h4>Users</h4>
<table class="table"><thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th></tr></thead>
<tbody><?php foreach($users as $u): ?><tr><td><?= $u['id'] ?></td><td><?= htmlspecialchars($u['username']) ?></td><td><?= htmlspecialchars($u['email']) ?></td><td><?= $u['role'] ?></td></tr><?php endforeach; ?></tbody></table>
<h4>Courses</h4>
<table class="table"><thead><tr><th>ID</th><th>Code</th><th>Name EN</th><th>Name AR</th></tr></thead>
<tbody><?php foreach($courses as $c): ?><tr><td><?= $c['id'] ?></td><td><?= htmlspecialchars($c['course_code']) ?></td><td><?= htmlspecialchars($c['name_en']) ?></td><td><?= htmlspecialchars($c['name_ar']) ?></td></tr><?php endforeach; ?></tbody></table>
<?php include __DIR__ . '/../templates/footer.php'; ?>