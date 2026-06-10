<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Pastikan BASE_URL terdefinisi
if (!defined('BASE_URL')) {
    define('BASE_URL', '../');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIKPU - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #0771e2;
            --sidebar-bg: #0d56c5;
        }
        body { background-color: #f5f5f5; margin: 0; font-family: 'Segoe UI', sans-serif; }
        
        /* Sidebar Styling */
        .sidebar {
            width: 240px;
            height: 100vh;
            position: fixed;
            background: var(--sidebar-bg);
            color: white;
            transition: all 0.3s;
        }
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar a {
            display: block;
            color: rgba(255,255,255,0.8);
            padding: 15px 25px;
            text-decoration: none;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.2);
            color: white;
            padding-left: 30px;
        }
        .sidebar a i { margin-right: 10px; width: 20px; }

        /* Topbar / Navbar Styling (Mengikuti UI Anda) */
        .topbar {
            margin-left: 240px;
            background: linear-gradient(135deg, var(--primary-color) 0%, #1a24a5; 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Content Area */
        .main-content {
            margin-left: 240px;
            padding: 30px;
            min-height: 100vh;
        }
        
        /* Card Styling (Mengikuti UI Anda) */
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-top: 3px solid var(--primary-color);
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="sidebar-header">
        <h4><i class="fas fa-hospital-user"></i> SIKPU</h4>
    </div>
    <a href="<?= BASE_URL ?>dashboard/index.php"><i class="fas fa-home"></i> Dashboard</a>
    <a href="<?= BASE_URL ?>pasien/index.php"><i class="fas fa-user-injured"></i> Data Pasien</a>
    <a href="<?= BASE_URL ?>dashboard/rekap.php"><i class="fas fa-file-alt"></i> Rekap Pasien</a>
    <a href="<?= BASE_URL ?>auth/logout.php" class="mt-5 text-warning"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<div class="main-content">