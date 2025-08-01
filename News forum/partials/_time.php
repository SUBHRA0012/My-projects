<?php
function timeAgoFromDateTime($when) {
    date_default_timezone_set("Asia/Kolkata");
    $now = new DateTime();
    $past = new DateTime($when);
    $diff = $now->diff($past);

    if ($diff->y >= 1) {
        return $diff->y . ' year' . ($diff->y > 1 ? 's' : '') . ' ago';
    } elseif ($diff->m >= 1) {
        return $diff->m . ' month' . ($diff->m > 1 ? 's' : '') . ' ago';
    } elseif ($diff->d >= 1) {
        return $diff->d . ' day' . ($diff->d > 1 ? 's' : '') . ' ago';
    } elseif ($diff->h >= 1) {
        return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '') . ' ago';
    } elseif ($diff->i >= 1) {
        return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '') . ' ago';
    } else {
        return 'Just now';
    }
}

// Example usage
// echo timeAgoFromDateTime($when);
?>