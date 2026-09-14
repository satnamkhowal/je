<?php
$pageTitle = $pageTitle ?? $course['name'] . ' | ' . $je['name'];
$pageDescription = $pageDescription ?? $course['description'];
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title><?= htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') ?></title>
  <meta name="description" content="<?= htmlspecialchars($pageDescription, ENT_QUOTES, 'UTF-8') ?>">
  <meta name="theme-color" content="#111318">
  <link rel="canonical" href="<?= htmlspecialchars($course['canonical'], ENT_QUOTES, 'UTF-8') ?>">
  <link rel="icon" href="../assets/images/jaipur-engieers-favicon-icon.png" type="image/png">
  <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="../java-full-stack/assets/css/landing.css">
  <script type="application/ld+json"><?php
    echo json_encode([
      '@context' => 'https://schema.org',
      '@type' => 'Course',
      'name' => $course['name'],
      'description' => $course['description'],
      'provider' => ['@type' => 'Organization', 'name' => $je['name'], 'url' => $je['website']],
      'educationalLevel' => 'Beginner to Advanced',
      'timeRequired' => 'P6M'
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
  ?></script>
</head>
<body>
