<?php
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}
function redirect($url) {
    header("Location: $url");
    exit();
}
?>