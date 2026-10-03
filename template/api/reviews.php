<?php
/**
 * Reviews API for IXORA Homestay
 * GET  — list approved reviews
 * POST — submit a review (name, email, location, rating, message)
 */
header('Content-Type: application/json; charset=utf-8');
header('X-Content-Type-Options: nosniff');

$store = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'reviews.json';
$dataDir = dirname($store);

if (!is_dir($dataDir)) {
  mkdir($dataDir, 0755, true);
}
if (!file_exists($store)) {
  file_put_contents($store, "[]\n", LOCK_EX);
}

function load_reviews($path) {
  $raw = @file_get_contents($path);
  $data = json_decode($raw !== false ? $raw : '[]', true);
  return is_array($data) ? $data : [];
}

function save_reviews($path, $reviews) {
  return file_put_contents($path, json_encode(array_values($reviews), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n", LOCK_EX) !== false;
}

function public_review($r) {
  return [
    'id' => isset($r['id']) ? (string) $r['id'] : '',
    'name' => isset($r['name']) ? (string) $r['name'] : '',
    'location' => isset($r['location']) ? (string) $r['location'] : '',
    'rating' => isset($r['rating']) ? (int) $r['rating'] : 5,
    'message' => isset($r['message']) ? (string) $r['message'] : '',
    'created_at' => isset($r['created_at']) ? (string) $r['created_at'] : '',
  ];
}

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method === 'GET') {
  $all = load_reviews($store);
  $out = [];
  foreach ($all as $r) {
    if (!empty($r['approved'])) {
      $out[] = public_review($r);
    }
  }
  usort($out, function ($a, $b) {
    return strcmp($b['created_at'], $a['created_at']);
  });
  $avg = 0;
  $count = count($out);
  if ($count > 0) {
    $sum = 0;
    foreach ($out as $r) {
      $sum += (int) $r['rating'];
    }
    $avg = round($sum / $count, 1);
  }
  echo json_encode([
    'ok' => true,
    'count' => $count,
    'average' => $avg,
    'reviews' => $out,
  ], JSON_UNESCAPED_UNICODE);
  exit;
}

if ($method !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
  exit;
}

$payload = [];
$contentType = $_SERVER['CONTENT_TYPE'] ?? $_SERVER['HTTP_CONTENT_TYPE'] ?? '';
if (stripos($contentType, 'application/json') !== false) {
  $body = file_get_contents('php://input');
  $decoded = json_decode($body, true);
  if (is_array($decoded)) {
    $payload = $decoded;
  }
} else {
  $payload = $_POST;
}

$name = trim((string) ($payload['name'] ?? ''));
$email = trim((string) ($payload['email'] ?? ''));
$location = trim((string) ($payload['location'] ?? ''));
$message = trim((string) ($payload['message'] ?? ''));
$rating = (int) ($payload['rating'] ?? 5);

// Honeypot — bots fill this; humans should leave it empty
$honeypot = trim((string) ($payload['website'] ?? ''));
if ($honeypot !== '') {
  echo json_encode(['ok' => true, 'message' => 'Thank you for your review.']);
  exit;
}

if ($name === '' || mb_strlen($name) < 2 || mb_strlen($name) > 80) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Please enter a valid name.']);
  exit;
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 120) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Please enter a valid email address.']);
  exit;
}
if ($location === '' || mb_strlen($location) < 2 || mb_strlen($location) > 100) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Please enter your location.']);
  exit;
}
if ($message === '' || mb_strlen($message) < 10 || mb_strlen($message) > 800) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Please write a review between 10 and 800 characters.']);
  exit;
}
if ($rating < 1 || $rating > 5) {
  $rating = 5;
}

$reviews = load_reviews($store);

// Simple duplicate / flood guard (same email within 10 minutes)
$now = time();
foreach ($reviews as $r) {
  if (
    isset($r['email'], $r['created_at']) &&
    strcasecmp($r['email'], $email) === 0 &&
    abs($now - strtotime($r['created_at'])) < 600
  ) {
    http_response_code(429);
    echo json_encode(['ok' => false, 'error' => 'You recently submitted a review. Please try again later.']);
    exit;
  }
}

$entry = [
  'id' => 'r-' . bin2hex(random_bytes(6)),
  'name' => $name,
  'email' => $email,
  'location' => $location,
  'rating' => $rating,
  'message' => $message,
  'created_at' => date('c'),
  'approved' => true,
  'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
];

$reviews[] = $entry;

if (!save_reviews($store, $reviews)) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => 'Could not save your review. Please try again.']);
  exit;
}

echo json_encode([
  'ok' => true,
  'message' => 'Thank you! Your review has been added.',
  'review' => public_review($entry),
], JSON_UNESCAPED_UNICODE);
