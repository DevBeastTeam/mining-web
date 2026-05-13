<?php
// connection with database 
$conn = mysqli_connect("localhost", "root", "", "mining-db");

// check connection 
if (!$conn) {
    die("not connected");
}

// Cookie check
$uid = isset($_COOKIE["uid"]) ? $_COOKIE["uid"] : "";

// Agar login nahi hy to index.php par bhejo
if (!$uid) {
    header("Location: index.php");
    exit();
}

$profile = mysqli_query($conn, "SELECT * FROM users WHERE id = '$uid'");
$data = mysqli_fetch_assoc($profile);

// Self-healing: Check if 'date' column exists
$check_col = mysqli_query($conn, "SHOW COLUMNS FROM `total-deposit` LIKE 'date'");
if(mysqli_num_rows($check_col) == 0) {
    mysqli_query($conn, "ALTER TABLE `total-deposit` ADD `date` VARCHAR(50)");
}
$check_col2 = mysqli_query($conn, "SHOW COLUMNS FROM `total-withdraw` LIKE 'date'");
if(mysqli_num_rows($check_col2) == 0) {
    mysqli_query($conn, "ALTER TABLE `total-withdraw` ADD `date` VARCHAR(50)");
}

// Handle form submission
if(isset($_POST['submit-deposit'])) {
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);
    $tid = mysqli_real_escape_string($conn, $_POST['tid']);
    $method = mysqli_real_escape_string($conn, $_POST['method_name']);
    $date = date("d M");
    
    // Insert into DB
    $query = "INSERT INTO `total-deposit` (uid, amount, date, status) VALUES ('$uid', '$amount', '$date', 'Pending')";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Your deposit request has been submitted successfully! Please wait for admin approval.'); window.location.href='dashboard.php';</script>";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit - C DashBoard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body { background: #f4f6f5; }
        .bg-green { background: linear-gradient(90deg, #0b3d2e, #0f5c3f); }
        .main-green { color: #0b3d2e; }
        .card { background: #ffffff; border-radius: 20px; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08); transition: 0.3s; }
        .card:hover { transform: translateY(-5px); border: 2px solid #0b3d2e; }
        .btn-main { background: #0b3d2e; color: white; border-radius: 10px; transition: 0.3s; }
        .btn-main:hover { transform: scale(1.02); box-shadow: 0 8px 15px rgba(11, 61, 46, 0.2); }
        .hidden-form { display: none; }
    </style>
</head>

<body>
    <header class="bg-green text-white px-8 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3 text-xl font-bold">
            <i class="fa-solid fa-c"></i> DashBoard
        </div>
        <div class="flex gap-6 items-center">
            <span class="text-green-200 hidden md:block">Welcome, <?php echo $data['name']; ?></span>
            <a href="dashboard.php">Dashboard</a>
            <a href="profile.php">Profile</a>
            <a href="#" onclick="showLogoutModal()">Logout</a>
        </div>
    </header>

    <!-- LOGOUT MODAL -->
    <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[2000] p-4">
        <div class="bg-white rounded-2xl p-8 max-w-sm w-full text-center shadow-2xl">
            <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                <i class="fa-solid fa-right-from-bracket"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Are you sure?</h3>
            <p class="text-gray-500 mb-8">Do you really want to logout from your account?</p>
            <div class="flex gap-4">
                <button onclick="closeLogoutModal()"
                    class="flex-1 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition">Cancel</button>
                <form method="POST" action="dashboard.php" class="flex-1">
                    <button type="submit" name="logout-btn" class="w-full py-3 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition shadow-lg shadow-red-200 text-center flex items-center justify-center">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showLogoutModal() { document.getElementById('logoutModal').style.display = 'flex'; }
        function closeLogoutModal() { document.getElementById('logoutModal').style.display = 'none'; }
        window.onclick = function (e) { if (e.target.id == 'logoutModal') closeLogoutModal(); }
    </script>

    <div class="p-8 max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold main-green text-center mb-4">Deposit Funds</h2>
        <p class="text-center text-gray-500 mb-8">Select a payment method to continue</p>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            <div onclick="showForm('JazzCash')" class="card p-5 text-center cursor-pointer border-2 border-transparent">
                <img src="src/jazzcash2.png" class="h-12 mx-auto mb-3">
                <p class="font-bold text-sm">JazzCash</p>
            </div>
            <div onclick="showForm('EasyPaisa')"
                class="card p-5 text-center cursor-pointer border-2 border-transparent">
                <img src="src/easypaisa.png" class="h-12 mx-auto mb-3" style="filter: hue-rotate(140deg);">
                <p class="font-bold text-sm">EasyPaisa</p>
            </div>
            <div onclick="showForm('Bank Transfer')"
                class="card p-5 text-center cursor-pointer border-2 border-transparent">
                <img src="src/bank.png" class="h-12 mx-auto mb-3">
                <p class="font-bold text-sm">Bank</p>
            </div>
            <div onclick="showForm('USDT (Crypto)')"
                class="card p-5 text-center cursor-pointer border-2 border-transparent">
                <img src="src/coins.png" class="h-12 mx-auto mb-3">
                <p class="font-bold text-sm">Crypto</p>
            </div>
        </div>

        <!-- HIDDEN FORM SECTION -->
        <div id="depositArea" class="hidden-form animate-fade-in">
            <form method="POST" class="card p-8 border-t-4 border-[#0b3d2e]">
                <h3 id="formTitle" class="text-2xl font-bold main-green mb-6 text-center">Deposit via JazzCash</h3>

                <input type="hidden" name="method_name" id="methodName" value="JazzCash">

                <!-- PAYMENT INFO BOX -->
                <div class="bg-gray-50 p-6 rounded-2xl mb-8 border-2 border-gray-100 flex flex-col items-center">
                    <p class="text-sm text-gray-500 mb-1 font-bold uppercase tracking-wider">Send Payment To:</p>
                    <div class="flex items-center gap-3">
                        <h2 id="accountNumber" class="text-2xl font-black text-gray-800">0300 1234567</h2>
                        <button type="button" onclick="copyAccount()"
                            class="bg-gray-200 p-2 rounded-lg hover:bg-gray-300 transition text-gray-600">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </div>
                    <p id="accountTitle" class="text-gray-500 mt-2 font-bold">Account Title: Muhammad Ali</p>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Amount (USD)</label>
                        <input type="number" name="amount" required placeholder="Enter amount"
                            class="w-full border-2 border-gray-100 p-3 rounded-xl outline-none focus:border-[#0b3d2e]">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Transaction ID (TID)</label>
                        <input type="text" name="tid" required placeholder="Enter transaction ID"
                            class="w-full border-2 border-gray-100 p-3 rounded-xl outline-none focus:border-[#0b3d2e]">
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-gray-700 font-bold mb-2">Upload Screenshot</label>
                    <input type="file"
                        class="w-full border-2 border-dashed border-gray-200 p-4 rounded-xl text-gray-400">
                </div>

                <button type="submit" name="submit-deposit" class="btn-main w-full py-4 text-lg font-bold">Submit Payment Details</button>
            </form>
        </div>
    </div>

    <footer class="bg-green text-white text-center py-6 mt-20">
        <p>© 2025 DashBoard. All Rights Reserved.</p>
    </footer>

    <script>
        function showForm(method) {
            document.getElementById('depositArea').style.display = 'block';
            document.getElementById('formTitle').innerText = 'Deposit via ' + method;
            document.getElementById('methodName').value = method;

            // Dynamic Account Details
            let accNum = document.getElementById('accountNumber');
            let accTitle = document.getElementById('accountTitle');

            if (method === 'JazzCash') {
                accNum.innerText = '0300 1234567';
                accTitle.innerText = 'Account Title: Muhammad Ali';
            } else if (method === 'EasyPaisa') {
                accNum.innerText = '0345 7654321';
                accTitle.innerText = 'Account Title: Muhammad Ali';
            } else if (method === 'Bank Transfer') {
                accNum.innerText = '1234 5678 9012 3456';
                accTitle.innerText = 'Bank: Allied Bank | Title: Muhammad Ali';
            } else {
                accNum.innerText = 'TX7yU...9zL0k (USDT TRC20)';
                accTitle.innerText = 'Scan QR or Copy Address';
            }

            window.scrollTo({ top: document.getElementById('depositArea').offsetTop - 100, behavior: 'smooth' });
        }

        function copyAccount() {
            let num = document.getElementById('accountNumber').innerText;
            navigator.clipboard.writeText(num);
            alert('Account details copied to clipboard!');
        }
    </script>
</body>

</html>