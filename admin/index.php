<?php
session_start();
// Database connection
$conn = mysqli_connect("localhost", "root", "", "mining-db");

$error = "";
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Simple admin check (You can change these credentials or use a table)
    if ($username === "admin" && $password === "admin123") {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid admin credentials!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Mining Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; background: #0b3d2e; }
        .login-card { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="login-card w-full max-w-md p-10 rounded-3xl shadow-2xl text-white">
        <div class="text-center mb-10">
            <div class="w-20 h-20 bg-lime-400 text-dark-green rounded-2xl flex items-center justify-center mx-auto mb-6 text-4xl shadow-lg shadow-lime-400/20">
                <i class="fa-solid fa-lock text-[#0b3d2e]"></i>
            </div>
            <h1 class="text-3xl font-bold mb-2 tracking-tight">Admin Access</h1>
            <p class="text-green-200/60 text-sm">Please sign in to manage the platform</p>
        </div>

        <?php if($error): ?>
            <div class="mb-6 p-4 bg-red-500/20 border border-red-500/50 text-red-200 rounded-xl text-center text-sm font-medium animate-pulse">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-green-200/50 mb-2 ml-1">Username</label>
                <div class="relative">
                    <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-green-200/30"></i>
                    <input type="text" name="username" required class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-4 outline-none focus:border-lime-400 transition text-white" placeholder="admin">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-widest text-green-200/50 mb-2 ml-1">Password</label>
                <div class="relative">
                    <i class="fa-solid fa-key absolute left-4 top-1/2 -translate-y-1/2 text-green-200/30"></i>
                    <input type="password" name="password" required class="w-full bg-white/5 border border-white/10 rounded-2xl py-4 pl-12 pr-4 outline-none focus:border-lime-400 transition text-white" placeholder="••••••••">
                </div>
            </div>

            <button type="submit" name="login" class="w-full bg-lime-400 hover:bg-lime-500 text-[#0b3d2e] font-black py-4 rounded-2xl transition shadow-xl shadow-lime-400/20 uppercase tracking-widest mt-4">
                Enter Control Panel
            </button>
        </form>

        <div class="mt-10 text-center">
            <a href="../index.php" class="text-sm text-green-200/40 hover:text-white transition">
                <i class="fa-solid fa-arrow-left-long mr-2"></i> Back to Website
            </a>
        </div>
    </div>

</body>
</html>
