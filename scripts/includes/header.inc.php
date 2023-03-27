<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?> | C Programming for HSC</title>

    <link href="./assets/prism/prism.css" rel="stylesheet" />

    <?php if ($page == 'study') : ?>
        <link rel="stylesheet" href="./assets/css/study.css">
    <?php else : ?>
        <link rel="stylesheet" href="./assets/css/style.css">
    <?php endif; ?>

    <?php foreach ($custom_css as $css) : ?>
        <link rel="stylesheet" href="<?= $css ?>">
    <?php endforeach; ?>

    <script src="https://kit.fontawesome.com/c9fec141b0.js" crossorigin="anonymous"></script>
</head>

<body class="line-numbers">
    <?php require_once __DIR__ . '/nav.inc.php'; ?>