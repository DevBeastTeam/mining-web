<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw - C DashBoard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f4f6f5;
        }

        .bg-green {
            background: linear-gradient(90deg, #0b3d2e, #0f5c3f);
        }

        .main-green {
            color: #0b3d2e;
        }

        .card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            border: 2px solid #0b3d2e;
        }

        .btn-main {
            background: #0b3d2e;
            color: white;
            border-radius: 10px;
            transition: 0.3s;
        }

        .btn-main:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 15px rgba(11, 61, 46, 0.2);
        }

        .balance-box {
            background: #eef5f2;
            border: 2px dashed #0b3d2e;
        }

        .hidden-form {
            display: none;
        }
    </style>
</head>

<body>
    <header class="bg-green text-white px-8 py-4 flex justify-between items-center">
        <div class="flex items-center gap-3 text-xl font-bold">
            <i class="fa-solid fa-c"></i> DashBoard
        </div>
        <div class="flex gap-6">
            <a href="dashboard.html">Dashboard</a>
            <a href="profile.html">Profile</a>
            <a href="#" onclick="showLogoutModal()">Logout</a>
        </div>
    </header>

    <!-- LOGOUT MODAL -->
    <div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-[2000] p-4">
        <div class="bg-white rounded-2xl p-8 max-w-sm w-full text-center shadow-2xl">
            <div
                class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                <i class="fa-solid fa-right-from-bracket"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Are you sure?</h3>
            <p class="text-gray-500 mb-8">Do you really want to logout from your account?</p>
            <div class="flex gap-4">
                <button onclick="closeLogoutModal()"
                    class="flex-1 py-3 bg-gray-100 text-gray-600 font-bold rounded-xl hover:bg-gray-200 transition">Cancel</button>
                <a href="index.html"
                    class="flex-1 py-3 bg-red-500 text-white font-bold rounded-xl hover:bg-red-600 transition shadow-lg shadow-red-200 text-center flex items-center justify-center">Logout</a>
            </div>
        </div>
    </div>

    <script>
        function showLogoutModal() { document.getElementById('logoutModal').style.display = 'flex'; }
        function closeLogoutModal() { document.getElementById('logoutModal').style.display = 'none'; }
        window.onclick = function (e) { if (e.target.id == 'logoutModal') closeLogoutModal(); }
    </script>

    <div class="p-8 max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold main-green text-center mb-4">Withdraw Earnings</h2>
        <p class="text-center text-gray-500 mb-8">Select your withdrawal method</p>

        <div class="balance-box p-6 rounded-2xl text-center mb-8">
            <p class="text-gray-600 font-bold uppercase text-xs tracking-widest mb-1">Available for Withdrawal</p>
            <h1 class="text-4xl font-black main-green">$50.00</h1>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            <div onclick="showWithdrawForm('JazzCash')"
                class="card p-5 text-center cursor-pointer border-2 border-transparent">
                <img src="src/jazzcash2.png" class="h-12 mx-auto mb-3">
                <p class="font-bold text-sm">JazzCash</p>
            </div>
            <div onclick="showWithdrawForm('EasyPaisa')"
                class="card p-5 text-center cursor-pointer border-2 border-transparent">
                <img src="src/easypaisa.png" class="h-12 mx-auto mb-3" style="filter: hue-rotate(140deg);">
                <p class="font-bold text-sm">EasyPaisa</p>
            </div>
            <div onclick="showWithdrawForm('Bank Account')"
                class="card p-5 text-center cursor-pointer border-2 border-transparent">
                <img src="src/bank.png" class="h-12 mx-auto mb-3">
                <p class="font-bold text-sm">Bank</p>
            </div>
            <div onclick="showWithdrawForm('USDT (Crypto)')"
                class="card p-5 text-center cursor-pointer border-2 border-transparent">
                <img src="src/coins.png" class="h-12 mx-auto mb-3">
                <p class="font-bold text-sm">Crypto</p>
            </div>
        </div>

        <!-- HIDDEN WITHDRAWAL FORM -->
        <div id="withdrawArea" class="hidden-form animate-fade-in">
            <div class="card p-8 border-t-4 border-[#0b3d2e]">
                <h3 id="withdrawTitle" class="text-2xl font-bold main-green mb-6 text-center">Withdraw via JazzCash</h3>

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Withdrawal Amount</label>
                        <input type="number" placeholder="Enter amount"
                            class="w-full border-2 border-gray-100 p-3 rounded-xl outline-none focus:border-[#0b3d2e]">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-2">Account Number / Wallet Address</label>
                        <input type="text" placeholder="Enter details"
                            class="w-full border-2 border-gray-100 p-3 rounded-xl outline-none focus:border-[#0b3d2e]">
                    </div>
                </div>

                <div class="mb-8">
                    <label class="block text-gray-700 font-bold mb-2">Account Title Name</label>
                    <input type="text" placeholder="Enter name"
                        class="w-full border-2 border-gray-100 p-3 rounded-xl outline-none focus:border-[#0b3d2e]">
                </div>

                <button onclick="submitWithdraw()" class="btn-main w-full py-4 text-lg font-bold">Submit Withdrawal
                    Request</button>
            </div>
        </div>
    </div>

    <footer class="bg-green text-white text-center py-6 mt-20">
        <p>© 2025 DashBoard. All Rights Reserved.</p>
    </footer>

    <script>
        function showWithdrawForm(method) {
            document.getElementById('withdrawArea').style.display = 'block';
            document.getElementById('withdrawTitle').innerText = 'Withdraw via ' + method;
            window.scrollTo({ top: document.getElementById('withdrawArea').offsetTop - 100, behavior: 'smooth' });
        }

        function submitWithdraw() {
            alert('Your withdrawal request has been received! It will be processed within 24 hours.');
            window.location.href = 'dashboard.html';
        }
    </script>
</body>

</html>