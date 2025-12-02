<?php
// index.php
require_once __DIR__ . '/inc/config.php';

// simple landing: redirect to members list
header('Location: ' . BASE_URL . 'members.php');
exit;