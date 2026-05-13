<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "mining-db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle Balance Update
if (isset($_POST['update-balance'])) {
    $uid = $_POST['uid'];
    $new_balance = $_POST['balance'];
    mysqli_query($conn, "UPDATE users SET balance = $new_balance WHERE id = $uid");
    header("Location: manage-users.php?msg=updated");
    exit();
}

// Handle User Deletion
if (isset($_GET['delete'])) {
    $uid = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM users WHERE id = $uid");
    header("Location: manage-users.php?msg=deleted");
    exit();
}

$users = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - Admin Panel</title>
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
            <a href="manage-users.php" class="nav-link active flex items-center gap-4 px-6 py-4 transition">
                <i class="fa-solid fa-users w-6"></i> Manage Users
            </a>
            <a href="manage-deposits.php" class="nav-link flex items-center gap-4 px-6 py-4 transition">
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
                <h1 class="text-3xl font-bold text-gray-800">User Management</h1>
                <p class="text-gray-500">Monitor and manage your user base</p>
            </div>
            <div class="bg-white p-3 rounded-xl shadow-sm text-gray-600">
                Total Users: <span class="font-bold text-green-600"><?php echo mysqli_num_rows($users); ?></span>
            </div>
        </header>

        <?php if(isset($_GET['msg'])): ?>
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-xl flex items-center gap-3 font-medium">
                <i class="fa-solid fa-circle-check"></i>
                User data has been successfully <?php echo $_GET['msg']; ?>.
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-gray-50 text-gray-400 text-xs uppercase tracking-wider border-b">
                            <th class="px-6 py-4 font-semibold">User Info</th>
                            <th class="px-6 py-4 font-semibold text-center">Referrals</th>
                            <th class="px-6 py-4 font-semibold">Balance</th>
                            <th class="px-6 py-4 font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php while($user = mysqli_fetch_assoc($users)): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800"><?php echo $user['name']; ?></p>
                                        <p class="text-xs text-gray-500"><?php echo $user['email'] ?? 'No Email'; ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center text-sm font-bold text-gray-600">
                                <?php echo $user['referrals'] ?? 0; ?>
                            </td>
                            <td class="px-6 py-4">
                                <form method="POST" class="flex items-center gap-2">
                                    <input type="hidden" name="uid" value="<?php echo $user['id']; ?>">
                                    <input type="number" step="0.01" name="balance" value="<?php echo $user['balance']; ?>" class="w-24 border border-gray-200 rounded-lg px-2 py-1 text-sm outline-none focus:border-green-500">
                                    <button type="submit" name="update-balance" class="text-green-600 hover:text-green-800 p-1">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-3">
                                    <a href="?delete=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?')" class="text-red-400 hover:text-red-600 transition">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </a>
                                    <button class="text-blue-400 hover:text-blue-600 transition">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
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
