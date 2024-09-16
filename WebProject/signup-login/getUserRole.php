<?php
session_start();

if (isset($_SESSION['user_role'])) {
    echo json_encode(['role' => $_SESSION['user_role']]);
} else {
    echo json_encode(['role' => 'guest']);
}
