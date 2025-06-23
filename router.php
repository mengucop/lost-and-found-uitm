<?php
// router.php
if (file_exists(__DIR__ . '/public' . $_SERVER['REQUEST_URI'])) {
    return false;
}

require __DIR__ . '/public/index.php';
