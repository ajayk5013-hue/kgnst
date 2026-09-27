<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

function database(): PDO {
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;
    if (!is_dir(dirname(DB_PATH))) mkdir(dirname(DB_PATH), 0755, true);
    $pdo = new PDO('sqlite:' . DB_PATH, null, null, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $pdo->exec('PRAGMA foreign_keys = ON');
    $pdo->exec('CREATE TABLE IF NOT EXISTS settings (key TEXT PRIMARY KEY, value TEXT NOT NULL)');
    $pdo->exec('CREATE TABLE IF NOT EXISTS admins (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, email TEXT UNIQUE NOT NULL, password_hash TEXT NOT NULL, created_at TEXT NOT NULL)');
    $pdo->exec('CREATE TABLE IF NOT EXISTS students (id INTEGER PRIMARY KEY AUTOINCREMENT, registration_number TEXT UNIQUE NOT NULL, full_name TEXT NOT NULL, phone TEXT NOT NULL, email TEXT, course TEXT NOT NULL, address TEXT NOT NULL, password_hash TEXT NOT NULL, created_at TEXT NOT NULL)');
    $pdo->exec('CREATE TABLE IF NOT EXISTS queries (id INTEGER PRIMARY KEY AUTOINCREMENT, full_name TEXT NOT NULL, phone TEXT NOT NULL, email TEXT, course TEXT, message TEXT NOT NULL, created_at TEXT NOT NULL)');
    return $pdo;
}

function isConfigured(): bool { return (bool)database()->query("SELECT value FROM settings WHERE key = 'configured'")->fetchColumn(); }
function esc(?string $value): string { return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8'); }
function adminRequired(): void { if (empty($_SESSION['admin_id'])) { header('Location: admin.php'); exit; } }
function registrationNumber(): string { return 'KGNST-' . date('Y') . '-' . strtoupper(bin2hex(random_bytes(3))); }
