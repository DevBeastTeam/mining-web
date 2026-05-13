<?php
session_start();
// Database connection
$conn = mysqli_connect("localhost", "root", "", "mining-db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch Stats
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM users"))['count'];
$total_deposits = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(amount) as sum FROM `total-deposit` WHERE status='Success'"))['sum'] ?? 0;
$total_withdraws = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(amount) as sum FROM `total-withdraw` WHERE status='Success'"))['sum'] ?? 0;
$pending_deposits = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM `total-deposit` WHERE status='Pending'"))['count'];
$pending_withdraws = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM `total-withdraw` WHERE status='Pending'"))['count'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Mining Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #f0f4f2; }
        .sidebar { background: #0b3d2e; }
        .nav-link:hover { background: rgba(255,255,255,0.1); }
        .nav-link.active { background: #1e7d57; border-left: 4px solid #ccff00; }
        .stat-card { transition: transform 0.3s ease; }
        .stat-card:hover { transform: translateY(-5px); }
        .main-green { color: #0b3d2e; }
        .bg-gradient-green { background: linear-gradient(135deg, #0b3d2e, #1e7d57); }
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
            <a href="dashboard.php" class="nav-link active flex items-center gap-4 px-6 py-4 transition">
                <i class="fa-solid fa-chart-line w-6"></i> Dashboard
            </a>
            <a href="manage-users.php" class="nav-link flex items-center gap-4 px-6 py-4 transition">
                <i class="fa-solid fa-users w-6"></i> Manage Users
            </a>
            <a href="manage-deposits.php" class="nav-link flex items-center gap-4 px-6 py-4 transition">
                <i class="fa-solid fa-wallet w-6"></i> Deposits
                <?php if($pending_deposits > 0): ?>
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full ml-auto"><?php echo $pending_deposits; ?></span>
                <?php endif; ?>
            </a>
            <a href="manage-withdrawals.php" class="nav-link flex items-center gap-4 px-6 py-4 transition">
                <i class="fa-solid fa-money-bill-transfer w-6"></i> Withdrawals
                <?php if($pending_withdraws > 0): ?>
                    <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full ml-auto"><?php echo $pending_withdraws; ?></span>
                <?php endif; ?>
            </a>
            <a href="settings.php" class="nav-link flex items-center gap-4 px-6 py-4 transition">
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
                <h1 class="text-3xl font-bold text-gray-800">Overview</h1>
                <p class="text-gray-500">Welcome back, Administrator</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="font-bold text-gray-800">Admin</p>
                    <p class="text-xs text-gray-500">Super User</p>
                </div>
                <div class="w-12 h-12 bg-gradient-green rounded-full flex items-center justify-center text-white text-xl">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border-l-4 border-blue-500">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-blue-50 text-blue-500 rounded-xl">
                        <i class="fa-solid fa-users text-xl"></i>
                    </div>
                    <span class="text-green-500 text-sm font-bold">+12%</span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium">Total Users</h3>
                <p class="text-2xl font-bold text-gray-800"><?php echo $total_users; ?></p>
            </div>

            <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border-l-4 border-green-500">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-green-50 text-green-500 rounded-xl">
                        <i class="fa-solid fa-sack-dollar text-xl"></i>
                    </div>
                    <span class="text-green-500 text-sm font-bold">+8%</span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium">Total Deposits</h3>
                <p class="text-2xl font-bold text-gray-800">$<?php echo number_format($total_deposits, 2); ?></p>
            </div>

            <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border-l-4 border-amber-500">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-amber-50 text-amber-500 rounded-xl">
                        <i class="fa-solid fa-clock-rotate-left text-xl"></i>
                    </div>
                    <span class="text-red-500 text-sm font-bold"><?php echo $pending_deposits; ?> New</span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium">Pending Deposits</h3>
                <p class="text-2xl font-bold text-gray-800"><?php echo $pending_deposits; ?></p>
            </div>

            <div class="stat-card bg-white p-6 rounded-2xl shadow-sm border-l-4 border-red-500">
                <div class="flex justify-between items-start mb-4">
                    <div class="p-3 bg-red-50 text-red-500 rounded-xl">
                        <i class="fa-solid fa-hand-holding-dollar text-xl"></i>
                    </div>
                    <span class="text-gray-500 text-sm font-bold">Total</span>
                </div>
                <h3 class="text-gray-500 text-sm font-medium">Total Withdraws</h3>
                <p class="text-2xl font-bold text-gray-800">$<?php echo number_format($total_withdraws, 2); ?></p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Users -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Recent Users</h2>
                    <a href="manage-users.php" class="text-green-600 hover:underline text-sm font-medium">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-400 text-xs uppercase tracking-wider border-b">
                                <th class="pb-3 font-semibold">User</th>
                                <th class="pb-3 font-semibold">Status</th>
                                <th class="pb-3 font-semibold text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <?php
                            $recent_users = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC LIMIT 5");
                            while($user = mysqli_fetch_assoc($recent_users)):
                            ?>
                            <tr>
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center text-gray-500">
                                            <i class="fa-solid fa-user text-xs"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-gray-800"><?php echo $user['name']; ?></p>
                                            <p class="text-xs text-gray-500"><?php echo $user['email'] ?? 'No Email'; ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4">
                                    <span class="px-2 py-1 bg-green-50 text-green-600 text-[10px] font-bold rounded-full uppercase">Active</span>
                                </td>
                                <td class="py-4 text-right">
                                    <button class="text-gray-400 hover:text-green-600 transition">
                                        <i class="fa-solid fa-ellipsis-vertical"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Latest Deposits</h2>
                    <a href="manage-deposits.php" class="text-green-600 hover:underline text-sm font-medium">View All</a>
                </div>
                <div class="space-y-4">
                    <?php
                    $recent_deposits = mysqli_query($conn, "SELECT d.*, u.name FROM `total-deposit` d JOIN users u ON d.uid = u.id ORDER BY d.id DESC LIMIT 5");
                    while($dep = mysqli_fetch_assoc($recent_deposits)):
                    ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 <?php echo $dep['status'] == 'Pending' ? 'bg-amber-100 text-amber-600' : 'bg-green-100 text-green-600'; ?> rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-arrow-down-long"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800"><?php echo $dep['name']; ?></p>
                                <p class="text-xs text-gray-500"><?php echo $dep['date']; ?></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-800">+$<?php echo number_format($dep['amount'], 2); ?></p>
                            <p class="text-[10px] font-bold uppercase <?php echo $dep['status'] == 'Pending' ? 'text-amber-500' : 'text-green-500'; ?>"><?php echo $dep['status']; ?></p>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
