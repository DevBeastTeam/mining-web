<?php

// connection with database 
$conn = mysqli_connect("localhost", "root", "", "mining-db");

// check connection 
if
(!$conn) {
    die("not connected");
}

$uid = $_COOKIE['uid'];

$profile = mysqli_query($conn, "SELECT * FROM users WHERE id = $uid");
$data = mysqli_fetch_assoc($profile);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Mining Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f4f6f5;
        }

        /* HEADER */
        .header {
            background: linear-gradient(90deg, #0b3d2e, #0f5c3f);
            color: #fff;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            text-decoration: none;
        }

        .nav a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
            font-size: 15px;
        }

        /* PROFILE CONTENT */
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .profile-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .avatar {
            width: 120px;
            height: 120px;
            background: #0b3d2e;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 50px;
            border: 4px solid #2ecc71;
        }

        .profile-card h2 {
            color: #0b3d2e;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .profile-card p.status {
            color: #2ecc71;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
            margin-bottom: 30px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            text-align: left;
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 30px;
        }

        .info-item label {
            display: block;
            font-size: 12px;
            color: #777;
            text-transform: uppercase;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .info-item span {
            font-size: 16px;
            color: #333;
            font-weight: bold;
        }

        .btn-edit {
            margin-top: 40px;
            background: #0b3d2e;
            color: #fff;
            border: none;
            padding: 15px 40px;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-edit:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(11, 61, 46, 0.2);
        }

        .footer {
            background: linear-gradient(90deg, #0b3d2e, #0f5c3f);
            color: #fff;
            padding: 30px 40px;
            margin-top: 50px;
            text-align: center;
        }

        /* MODAL STYLES */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .modal-content {
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-icon {
            font-size: 50px;
            color: #e74c3c;
            margin-bottom: 20px;
        }

        .modal-btns {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-modal {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-cancel {
            background: #eee;
            color: #555;
        }

        .btn-logout {
            background: #e74c3c;
            color: #fff;
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="header">
        <a href="index.php" class="logo"><i class="fa-solid fa-c"></i> DashBoard</a>
        <div class="nav">
            <a href="index.php">Home</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="profile.php">Profile</a>
            <a href="#" onclick="showLogoutModal()">Logout</a>
        </div>
    </div>

    <!-- LOGOUT MODAL -->
    <div id="logoutModal" class="modal-overlay">
        <div class="modal-content">
            <div class="modal-icon"><i class="fas fa-sign-out-alt"></i></div>
            <h3 style="color:#333; font-size:22px; margin-bottom:10px;">Are you sure?</h3>
            <p style="color:#777; font-size:14px;">Do you really want to logout?</p>
            <div class="modal-btns">
                <button onclick="closeLogoutModal()" class="btn-modal btn-cancel">Cancel</button>
                <a href="index.php" class="btn-modal btn-logout"
                    style="text-decoration:none; display:flex; align-items:center; justify-content:center;">Logout</a>
            </div>
        </div>
    </div>

    <script>
        function showLogoutModal() { document.getElementById('logoutModal').style.display = 'flex'; }
        function closeLogoutModal() { document.getElementById('logoutModal').style.display = 'none'; }
        window.onclick = function (e) { if (e.target.id == 'logoutModal') closeLogoutModal(); }
    </script>


    <div class="container">
        <div class="profile-card">
            <div class="avatar">

                <?php
                if ($data['profile-image'] != ""):
                    ?>
                    <img src="<?php echo $data['profile-image'] ?>" alt="">
                <?php else:
                    ?>
                    <i class="fa-solid fa-user"></i>
                <?php endif ?>

            </div>
            <h2>
                <?php echo $data['name'] ?>
            </h2>
            <p class="status">Verified Miner</p>

            <div class="info-grid">
                <div class="info-item">
                    <label>Balance</label>
                    <span>
                        <?php echo $data['balance'] ?>
                    </span>
                </div>
                <div class="info-item">
                    <label>phone number</label>
                    <span><?php if ($data['phone'] == "") {

                        echo "0300-0000000";

                    } else {

                        echo $data['phone'];

                    }

                    ?></span>
                </div>
                <div class="info-item">
                    <label>Email Address</label>
                    <span>user@example.com</span>
                </div>
                <div class="info-item">
                    <label>Account Created</label>
                    <span><?php echo $data['created-at'] ?></span>
                </div>
            </div>

            <button class="btn-edit">Edit Profile</button>
        </div>
    </div>

    <div class="footer">
        <p>© 2025 DashBoard. All Rights Reserved.</p>
    </div>

</body>

</html>