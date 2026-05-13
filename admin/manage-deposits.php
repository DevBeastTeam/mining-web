<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "mining-db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle Status Update
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];
    $status = ($action == 'approve') ? 'Success' : 'Rejected';

    // If approving, update user balance
    if ($status == 'Success') {
        $dep_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `total-deposit` WHERE id = $id"));
        if ($dep_data && $dep_data['status'] == 'Pending') {
            $amount = $dep_data['amount'];
            $uid = $dep_data['uid'];
            mysqli_query($conn, "UPDATE users SET balance = balance + $amount WHERE id = $uid");
        }
    }

    mysqli_query($conn, "UPDATE `total-deposit` SET status = '$status' WHERE id = $id");
    header("Location: manage-deposits.php");
    exit();
}

$deposits = mysqli_query($conn, "SELECT d.*, u.name, u.email FROM `total-deposit` d JOIN users u ON d.uid = u.id ORDER BY d.id DESC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Deposits - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #f0f4f2; }
        .sidebar { background: #0b3d2e; }
        .nav-link:hover { background: rgba(255,255,255,0.1); }
        .nav-link.active { background: #1e7d57; border-left: 4px solid #ccff00; }
        .main-green { color: #0b3d2e; }
        .status-pending { background: #fffbeb; color: #b45309; }
        .status-success { background: #f0fdf4; color: #15803d; }
        .status-rejected { background: #fef2f2; color: #b91c1c; }
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
            <a href="manage-deposits.php" class="nav-link active flex items-center gap-4 px-6 py-4 transition">
                <i class="fa-solid fa-wallet w-6"></i> Deposits
            </a>
            <a href="manage-withdrawals.php" class="nav-link flex items-center gap-4 px-6 py-4 transition">
                <i class="fa-solid fa-money-bill-transfer w-6"></i> Withdrawals
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
                <h1 class="text-3xl font-bold text-gray-800">Deposit Requests</h1>
                <p class="text-gray-500">Manage all incoming user payments</p>
            </div>
            <a href="dashboard.php" class="bg-white p-3 rounded-xl shadow-sm text-gray-600 hover:text-green-600 transition">
                <i class="fa-solid fa-house"></i>
            </a>
        </header>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-wider border-b">
                            <th class="px-6 py-4 font-semibold">User Details</th>
                            <th class="px-6 py-4 font-semibold">Amount</th>
                            <th class="px-6 py-4 font-semibold">Date</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                            <th class="px-6 py-4 font-semibold text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php while($row = mysqli_fetch_assoc($deposits)): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-gray-800"><?php echo $row['name']; ?></p>
                                <p class="text-xs text-gray-500"><?php echo $row['email']; ?></p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-gray-800">$<?php echo number_format($row['amount'], 2); ?></p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                <?php echo $row['date']; ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase <?php 
                                    echo ($row['status'] == 'Pending') ? 'status-pending' : (($row['status'] == 'Success') ? 'status-success' : 'status-rejected'); 
                                ?>">
                                    <?php echo $row['status']; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center gap-2">
                                    <?php if($row['status'] == 'Pending'): ?>
                                        <a href="?action=approve&id=<?php echo $row['id']; ?>" class="w-8 h-8 bg-green-100 text-green-600 rounded-lg flex items-center justify-center hover:bg-green-600 hover:text-white transition shadow-sm" title="Approve">
                                            <i class="fa-solid fa-check"></i>
                                        </a>
                                        <a href="?action=reject&id=<?php echo $row['id']; ?>" class="w-8 h-8 bg-red-100 text-red-600 rounded-lg flex items-center justify-center hover:bg-red-600 hover:text-white transition shadow-sm" title="Reject">
                                            <i class="fa-solid fa-xmark"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-xs text-gray-400 italic">Processed</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
