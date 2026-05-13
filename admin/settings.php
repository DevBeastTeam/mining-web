<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #f0f4f2; }
        .sidebar { background: #0b3d2e; }
        .nav-link:hover { background: rgba(255,255,255,0.1); }
        .nav-link.active { background: #1e7d57; border-left: 4px solid #ccff00; }
        .main-green { color: #0b3d2e; }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- Sidebar -->
    <div class="sidebar w-64 text-white flex flex-col fixed h-full shadow-2xl">
        <div class="p-6 text-2xl font-bold border-b border-green-800 flex items-center gap-3">
            <i class="fa-solid fa-shield-halved text-lime-400"></i>
            AdminPanel
        </div>
        <nav class="flex-1 mt-6">
            <a href="dashboard.php" class="nav-link flex items-center gap-4 px-6 py-4 transition">
                <i class="fa-solid fa-chart-line w-6"></i> Dashboard
            </a>
            <a href="manage-users.php" class="nav-link flex items-center gap-4 px-6 py-4 transition">
                <i class="fa-solid fa-users w-6"></i> Manage Users
            </a>
            <a href="manage-deposits.php" class="nav-link flex items-center gap-4 px-6 py-4 transition">
                <i class="fa-solid fa-wallet w-6"></i> Deposits
            </a>
            <a href="manage-withdrawals.php" class="nav-link flex items-center gap-4 px-6 py-4 transition">
                <i class="fa-solid fa-money-bill-transfer w-6"></i> Withdrawals
            </a>
            <a href="settings.php" class="nav-link active flex items-center gap-4 px-6 py-4 transition">
                <i class="fa-solid fa-gears w-6"></i> Settings
            </a>
        </nav>
        <div class="p-6 border-t border-green-800">
            <a href="../logout.php" class="flex items-center gap-4 text-red-300 hover:text-red-100 transition">
                <i class="fa-solid fa-power-off"></i> Logout
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 ml-64 p-10">
        <header class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Platform Settings</h1>
                <p class="text-gray-500">Configure global website parameters</p>
            </div>
            <a href="dashboard.php" class="bg-white p-3 rounded-xl shadow-sm text-gray-600 hover:text-green-600 transition">
                <i class="fa-solid fa-house"></i>
            </a>
        </header>

        <div class="bg-white rounded-2xl shadow-sm p-8 max-w-2xl text-center border-2 border-dashed border-gray-200">
            <div class="w-20 h-20 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                <i class="fa-solid fa-person-digging"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Under Construction</h2>
            <p class="text-gray-500">The settings module is currently being developed. It will allow you to change site titles, admin passwords, and payment gateways.</p>
        </div>
    </div>

</body>
</html>
