<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "banks2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_POST['member_id'];

    $sql = "SELECT * FROM members WHERE member_id='$member_id'";
    $result = $conn->query($sql);

    if ($result !== false && $result->num_rows > 0) {
        header("Location: member_details1.php?member_id=" . $member_id);
        exit();
    } else {
        $error_message = "Member not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        :root {
    --color-one: #ab49de;
    --color-two: #5b41f2;
    --bg-color: #201c29;
    --light: #fefefe;
}

*,
::before,
::after {
    box-sizing: border-box;
}

::-webkit-scrollbar {
    width: 0;
    height: 0;
}

body {
    margin: 0;
    font-family: "Dosis", sans-serif;
    font-size: 62.5%;
    cursor: col-resize;
    background-color: var(--bg-color);
}

.container,
section {  
    height: 100vh;
}

.container {
    position: relative;
    width: 100%;
    overflow: hidden;
    background-color: var(--bg-color);
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;

    &::before,
    &::after {
        position: absolute;
        width: 350px;
        height: 350px;
        content: "";
        border-radius: 54% 46% 42% 58% / 60% 58% 42% 40%;
        background-image: linear-gradient(45deg, var(--color-one), var(--color-two));
        animation: vawe 5s linear infinite;
    }

    &::before {
        top: -10%;
        right: -10%;
    }
    
    &::after {
        bottom: -10%;
        left: -15%;
    }

    .dots {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;

        span {
            position: absolute;
            border-radius: 50%;
            background-image: linear-gradient(45deg, var(--color-one), var(--color-two));
            animation: vawe 7s linear infinite;
            
            &:nth-child(1) {        
                top: 10%;
                left: calc(100% - 360px);
                width: 75px;
                height: 75px;
            }

            &:nth-child(2) {
                top: 15px;
                left: 180px;
                width: 50px;
                height: 50px;
                border-radius: 38% 62% 33% 67% / 60% 53% 47% 40%;
                transform: rotate(90deg);
            }

            &:nth-child(3) {
                right: 180px;
                bottom: 20px;
                width: 80px;
                height: 80px;
                border-radius: 38% 62% 55% 45% / 52% 53% 47% 48%;
            }

            &:nth-child(4) {
                bottom: 50px;
                left: 240px;
                width: 20px;
                height: 20px;
                border-radius: 38% 62% 55% 45% / 52% 53% 47% 48%;
            }

            &:nth-child(5) {
                right: 280px;
                bottom: 80px;
                width: 25px;
                height: 25px;
                border-radius: 38% 62% 55% 45% / 52% 53% 47% 48%;
            }
            
            &:nth-child(6) {        
                top: 6%;
                left: calc(100% - 400px);
                width: 25px;
                height: 25px;
            }
        }
    }
}

.resize {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: 10px;
    z-index: 2;
    text-transform: uppercase;
    font-size: 1rem;
    color: var(--light);
}

.content {
    position: relative;
    z-index: 1;
    width: 70%;
    padding: 2em;
    text-align: center;
    font-size: 1.25rem;
    border-radius: 0.5em;
    background-color: var(--bg-color);
    border: 2px solid var(--color-two);
    color: var(--light);
    mix-blend-mode: luminosity;

    h1 {
        margin: 0;
        font-size: 5vw;
        letter-spacing: 5px;
        overflow: hidden; 
        white-space: nowrap; 
        margin: 0 auto;
        letter-spacing: .15em; 
    }

    form {
        margin-top: 20px;
    }

    input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    button {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }

    .error-message {
        color: red;
        margin-top: 10px;
    }
}

@keyframes typing {
    from { width: 0 }
    to { width: 100% }
}

@keyframes blink-caret {
    from, to { border-color: transparent }
    99%, 100% { border-color: transparent }
}

@keyframes vawe {
    20% {
        border-radius: 45% 55% 62% 38% / 53% 51% 49% 47%;
    }
    40% {
        border-radius: 45% 55% 49% 51% / 36% 51% 49% 64%;
    }
    60% {
        border-radius: 60% 40% 57% 43% / 47% 62% 38% 53%;
    }
    80% {
        border-radius: 60% 40% 32% 68% / 38% 36% 64% 62%;
    }
}

    </style>
</head>
<body>
    <div class="container">
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="content">
            <h1>Recurrent Deposit</h1>
            <form action="" method="POST">
                <input type="text" name="member_id" placeholder="Enter Member ID" required>
                <button type="submit">Search</button>
                <?php
                if ($error_message != "") {
                    echo '<p class="error-message">' . $error_message . '</p>';
                }
                ?>
            </form>
        </div>
    </div>
</body>
</html>
