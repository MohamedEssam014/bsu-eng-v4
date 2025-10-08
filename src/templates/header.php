<?php
$dir = $lang === 'en' ? 'ltr' : 'rtl';
?><!doctype html>
<html lang="<?= $lang ?>" dir="<?= $dir ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>BSU Engineering</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-white bg-white border-bottom">
  <div class="container">
    <a class="navbar-brand" href="/?lang=<?= $lang ?>"><?= $lang==='ar' ? 'كلية الهندسة' : 'Faculty of Engineering' ?></a>
    <div class="d-flex align-items-center">
      <a class="btn btn-link" href="/?lang=ar">عربي</a>
      <a class="btn btn-link" href="/?lang=en">EN</a>
      <a class="btn btn-outline-primary ms-2" href="/lectures.php?lang=<?= $lang ?>"><?= $lang==='ar' ? 'المحاضرات' : 'Lectures' ?></a>
      <a class="btn btn-outline-secondary ms-2" href="/results.php?lang=<?= $lang ?>"><?= $lang==='ar' ? 'النتائج' : 'Results' ?></a>
      <a class="btn btn-primary ms-2" href="/login.php?lang=<?= $lang ?>"><?= $lang==='ar' ? 'تسجيل الدخول' : 'Login' ?></a>
    </div>
  </div>
</nav>
<div class="container mt-4">