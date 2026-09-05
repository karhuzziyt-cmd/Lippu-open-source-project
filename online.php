<?php
session_start();
$file = __DIR__ . '/online_users.json';
$online = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
if (!is_array($online)) $online = [];

$now = time();
$timeout_sec = 20; // jos käyttäjä ei pingaa 20s sisään, poistetaan
$action = $_GET['action'] ?? 'count';

// Poista vanhentuneet
foreach ($online as $sid => $last_seen) {
    if ($last_seen < ($now - $timeout_sec)) unset($online[$sid]);
}

// Päivitä listaa
$sid = session_id();
if ($action === 'ping') {
    $online[$sid] = $now; // päivitä "olen paikalla"
} elseif ($action === 'leave') {
    unset($online[$sid]); // poista heti
}

// Tallenna takaisin
file_put_contents($file, json_encode($online, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

// Palauta määrä JSON:na
header('Content-Type: application/json');
echo json_encode(['online' => count($online)]);
