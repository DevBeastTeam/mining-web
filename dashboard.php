<?php

if (isset($_POST['logout-btn'])) {
    setcookie('uid', '', 0, "/");
    header('Location: index.php');
    exit();
}

// Cookie check - isset() se check karo
$uid  = isset($_COOKIE["uid"])  ? $_COOKIE["uid"]  : "";
$name = isset($_COOKIE["name"]) ? $_COOKIE["name"] : "";

// Agar login nahi hy to index.php par bhejo
if (!$uid) {
    header("Location: index.php");
    exit();
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C DashBoard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f4f6f5;
        }

        .card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        .main-green {
            color: #0b3d2e;
        }

        .bg-green {
            background: linear-gradient(90deg, #0b3d2e, #0f5c3f);
        }

        .btn-main {
            background: #0b3d2e;
            color: white;
            border-radius: 10px;
        }

        .btn-outline {
            border: 2px solid #0b3d2e;
            color: #0b3d2e;
            border-radius: 10px;
        }

        /* PAYMENT SECTION STYLES */
        .payments {
            display: flex;
            gap: 15px;
            padding: 10px 0 30px 0;
            flex-wrap: wrap;
        }

        .pay {
            flex: 1;
            min-width: 140px;
            background: #fff;
            padding: 15px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }

        .pay:hover {
            transform: translateY(-5px);
        }

        .pay img {
            height: 40px;
            margin: 0 auto 10px;
            object-fit: contain;
        }

        .pay p {
            font-size: 13px;
            font-weight: 600;
            color: #0b3d2e;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header class="bg-green text-white px-8 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3 text-xl font-bold">
            <i class="fa-solid fa-c"></i> DashBoard
        </div>

        <div class="flex gap-6">
            <a href="index.php">Home</a>
            <a href="profile.php">Profile</a>
            <a href="#" onclick="showLogoutModal()">Logout</a>
        </div>
    </header>


    <!-- LOGOUT MODAL -->
    <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[2000] p-4">
        <div class="bg-white rounded-2xl p-8 max-w-sm w-full text-center shadow-2xl animate-fade-in">
            <div
                class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                <i class="fa-solid fa-right-from-bracket"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Are you sure?</h3>
            <p class="text-gray-500 mb-8">Do you really want to logout from your account?</p>

            <div class="flex gap-4">
                <button onclick="closeLogoutModal()"
                    class="flex-1 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition">Cancel</button>


                <form method="post">
                    <input type="submit" name="logout-btn"
                        class="flex-1 py-3 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition shadow-lg shadow-red-200"
                        value="Logout">
                </form>


            </div>
        </div>
    </div>

    <script>
        function showLogoutModal() {
            document.getElementById('logoutModal').style.display = 'flex';
        }
        function closeLogoutModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }
        // Close modal on outside click
        window.onclick = function (event) {
            let modal = document.getElementById('logoutModal');
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>

    <div class="p-8 max-w-7xl mx-auto">

        <!-- TOP -->
        <div class="grid md:grid-cols-2 gap-8 items-center">

            <div>
                <h2 class="text-4xl font-bold" style="color:lime">
                    <span style="color:green">Welcome</span> <?php echo $name; ?>
                </h2>
                <h2 class="text-4xl font-bold main-green">Earn Every Day With Mining</h2>
                <p class="text-gray-500 mt-2">Your Balance</p>
                <h1 class="text-5xl font-bold main-green">50 USD</h1>

                <div class="flex gap-4 mt-6">
                    <a href="deposit.html" class="btn-main px-6 py-3 text-center">Deposit</a>
                    <a href="withdraw.html" class="btn-outline px-6 py-3 text-center">Withdraw</a>
                </div>
            </div>

            <div class="text-center">
                <img src="src/machine2.png" class="mx-auto w-[350px]">
            </div>

        </div>

        <!-- PAYMENTS -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-10">
            <div class="card p-5 text-center flex flex-col items-center justify-center">
                <img src="src/jazzcash2.png" alt="JazzCash" class="h-10 mb-2">
                <p class="font-bold main-green">JazzCash</p>
            </div>
            <div class="card p-5 text-center flex flex-col items-center justify-center">
                <img src="src/bank.png" alt="Bank" class="h-10 mb-2">
                <p class="font-bold main-green">Bank Account</p>
            </div>
            <div class="card p-5 text-center flex flex-col items-center justify-center">
                <img src="src/coins.png" alt="Crypto" class="h-10 mb-2">
                <p class="font-bold main-green">Crypto Wallet</p>
            </div>
            <div class="card p-5 text-center flex flex-col items-center justify-center">
                <img src="src/payeer.png" alt="Payeer" class="h-10 mb-2">
                <p class="font-bold main-green">Payeer Wallet</p>
            </div>
        </div>

        <!-- STATS -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-10">

            <div class="card p-5 text-center">
                <img src="src/btc-wallet.png" alt="">
                <p class="text-xl font-bold main-green">50 USD</p>
                <p class="text-sm text-gray-500">Total Deposit</p>
            </div>

            <div class="card p-5 text-center">
                <img src="src/deposit.png" alt="">
                <p class="text-xl font-bold main-green">10 USD</p>
                <p class="text-sm text-gray-500">Total Withdrawal</p>
            </div>

            <div class="card p-5 text-center">
                <img src="src/users.png" alt="">
                <p class="text-xl font-bold main-green">10</p>
                <p class="text-sm text-gray-500">Referrals</p>
            </div>

            <div class="card p-5 text-center">
                <img src="src/percantage.png" alt="">
                <p class="text-xl font-bold main-green">10 USD</p>
                <p class="text-sm text-gray-500">Refer Earn</p>
            </div>

        </div>

        <!-- CARDS -->
        <div class="grid md:grid-cols-2 gap-8 mt-10">

            <div class="card p-6">
                <h3 class="text-xl font-bold main-green">Invest</h3>
                <p class="text-gray-500">120% - 150% Profit</p>

                <img src="src/machine2.png" class="mx-auto my-6 w-52">

                <input type="text" value="50" class="w-full border p-3 rounded-lg mb-4">

                <button class="btn-main w-full py-3">Invest Now</button>
            </div>

            <div class="card p-6 text-center">
                <h3 class="text-xl font-bold main-green">Bet & Earn</h3>
                <p class="text-gray-500">Win upto 200%</p>

                <img src="src/head-tail.png" class="mx-auto my-6 w-40">

                <button class="btn-main w-full py-3">Play Now</button>
            </div>

        </div>

        <!-- TABLES -->
        <div class="grid md:grid-cols-2 gap-8 mt-10">

            <div class="card">
                <div class="bg-green text-white p-4 rounded-t-xl">Deposits</div>
                <table class="w-full text-sm">
                    <tr class="border-b">
                        <th class="p-3">Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                    <tr>

                        <td class="p-3">50 USD</td>
                        <td>20 May</td>
                        <td class="text-green-600">Success</td>
                    </tr>
                </table>
            </div>

            <div class="card">
                <div class="bg-green text-white p-4 rounded-t-xl">Withdrawals</div>
                <table class="w-full text-sm">
                    <tr class="border-b">
                        <th class="p-3">Amount</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td class="p-3">10 USD</td>
                        <td>21 May</td>
                        <td class="text-green-600">Success</td>
                    </tr>
                </table>
            </div>

        </div>

        <!-- FOLLOW US SECTION -->
        <div style="
            margin-top: 40px;
            background: linear-gradient(135deg, #0b3d2e, #1e7d57);
            border-radius: 18px;
            padding: 30px 25px;
            text-align: center;
            color: #fff;
            box-shadow: 0 6px 25px rgba(11, 61, 46, 0.3);
        ">
            <h3 style="font-size: 20px; font-weight: bold; margin-bottom: 8px; letter-spacing: 1px;">
                <i class="fa-solid fa-share-nodes" style="margin-right: 8px;"></i> Follow Us
            </h3>
            <p style="font-size: 14px; color: #c8e6c9; margin-bottom: 20px;">Stay connected with us on social media for latest updates &amp; offers!</p>
            <div style="display: flex; justify-content: center; gap: 18px; flex-wrap: wrap;">
                <a href="#" style="
                    width: 52px; height: 52px;
                    background: rgba(255,255,255,0.2);
                    border-radius: 50%;
                    display: flex; align-items: center; justify-content: center;
                    color: #fff; font-size: 22px;
                    text-decoration: none;
                    transition: background 0.3s, transform 0.2s;
                " onmouseover="this.style.background='rgba(255,255,255,0.4)';this.style.transform='translateY(-4px)'"
                   onmouseout="this.style.background='rgba(255,255,255,0.2)';this.style.transform='translateY(0)'">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="#" style="
                    width: 52px; height: 52px;
                    background: rgba(255,255,255,0.2);
                    border-radius: 50%;
                    display: flex; align-items: center; justify-content: center;
                    color: #fff; font-size: 22px;
                    text-decoration: none;
                    transition: background 0.3s, transform 0.2s;
                " onmouseover="this.style.background='rgba(255,255,255,0.4)';this.style.transform='translateY(-4px)'"
                   onmouseout="this.style.background='rgba(255,255,255,0.2)';this.style.transform='translateY(0)'">
                    <i class="fa-brands fa-telegram"></i>
                </a>
                <a href="#" style="
                    width: 52px; height: 52px;
                    background: rgba(255,255,255,0.2);
                    border-radius: 50%;
                    display: flex; align-items: center; justify-content: center;
                    color: #fff; font-size: 22px;
                    text-decoration: none;
                    transition: background 0.3s, transform 0.2s;
                " onmouseover="this.style.background='rgba(255,255,255,0.4)';this.style.transform='translateY(-4px)'"
                   onmouseout="this.style.background='rgba(255,255,255,0.2)';this.style.transform='translateY(0)'">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                <a href="#" style="
                    width: 52px; height: 52px;
                    background: rgba(255,255,255,0.2);
                    border-radius: 50%;
                    display: flex; align-items: center; justify-content: center;
                    color: #fff; font-size: 22px;
                    text-decoration: none;
                    transition: background 0.3s, transform 0.2s;
                " onmouseover="this.style.background='rgba(255,255,255,0.4)';this.style.transform='translateY(-4px)'"
                   onmouseout="this.style.background='rgba(255,255,255,0.2)';this.style.transform='translateY(0)'">
                    <i class="fa-brands fa-youtube"></i>
                </a>
            </div>
        </div>

    </div>

</body>

</html>