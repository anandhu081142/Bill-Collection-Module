<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: "Nunito", sans-serif;
    }

    body {
      background: #1f1f47;
    }

    .container {
      min-height: 100vh;
      width: 100%;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      overflow: hidden;
    }

    .card {
      width: 400px;
      min-height: 300px;
      background: rgba(255, 255, 255, 0.15);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
      backdrop-filter: blur(18px);
      -webkit-backdrop-filter: blur(18px);
      border: 1px solid rgba(255, 255, 255, 0.18);
      border-radius: 1rem;
      padding: 2rem;
      z-index: 10;
      color: whitesmoke;
      text-align: center;
    }

    .title {
      font-size: 2.2rem;
      margin-bottom: 1rem;
    }

    .typing-container {
      text-align: center;
      margin-bottom: 2rem;
    }

    .input-group {
      display: flex;
      align-items: center;
      margin-bottom: 1rem;
    }

    label {
      margin-right: 1rem;
      width: 80px;
    }

    input[type="text"],
    input[type="password"] {
      flex: 1;
      padding: 0.5rem;
      border: none;
      border-radius: 0.5rem;
      outline: none;
    }

    .btn {
      background: none;
      border: none;
      text-align: center;
      font-size: 1rem;
      color: whitesmoke;
      background-color: #fa709a;
      padding: 0.8rem 1.8rem;
      border-radius: 2rem;
      cursor: pointer;
    }

    .blob {
      position: absolute;
      width: 500px;
      height: 500px;
      background: linear-gradient(
        180deg,
        rgba(47, 184, 255, 0.42) 31.77%,
        #5c9df1 100%
      );
      mix-blend-mode: color-dodge;
      -webkit-animation: move 25s infinite alternate;
      animation: move 25s infinite alternate;
      transition: 1s cubic-bezier(0.07, 0.8, 0.16, 1);
    }

    .blob:hover {
      width: 520px;
      height: 520px;
      -webkit-filter: blur(30px);
      filter: blur(30px);
      box-shadow:
        inset 0 0 0 5px rgba(255, 255, 255, 0.6),
        inset 100px 100px 0 0px #fa709a,
        inset 200px 200px 0 0px #784ba8,
        inset 300px 300px 0 0px #2b86c5;
    }

    @-webkit-keyframes move {
      from {
        transform: translate(-100px, -50px) rotate(-90deg);
        border-radius: 24% 76% 35% 65% / 27% 36% 64% 73%;
      }

      to {
        transform: translate(500px, 100px) rotate(-10deg);
        border-radius: 76% 24% 33% 67% / 68% 55% 45% 32%;
      }
    }

    @keyframes move {
      from {
        transform: translate(-100px, -50px) rotate(-90deg);
        border-radius: 24% 76% 35% 65% / 27% 36% 64% 73%;
      }

      to {
        transform: translate(500px, 100px) rotate(-10deg);
        border-radius: 76% 24% 33% 67% / 68% 55% 45% 32%;
      }
    }

    /* Typing animation styles */
    h1 {
      font-size: 2.2rem;
      text-align: center;
    }

    .type-animation {
      display: inline-flex;
      width: 0;
      overflow: hidden;
      padding-right: 0.08em;
      position: relative;
    }

    .type-animation:after {
      content: "";
      background: #1f1f47;
      position: absolute;
      right: 0;
      top: -0.05em;
      bottom: -0.05em;
      width: 0.08em;
      border-right: 2px solid transparent;
    }

    .type-animation.animating {
      animation: type 2.7s steps(15) forwards;
      animation-delay: 1s;
    }

    .type-animation.animating:after {
      animation: cursor 320ms 7 ease-in-out;
    }

    @keyframes cursor {
      0%,
      100% {
        border-color: #1f1f47;
      }
      50% {
        border-color: slateblue;
      }
    }

    @keyframes type {
      0% {
        width: 0;
      }
      100% {
        width: 8em;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="card">
      <div class="typing-container">
        <h1>DITS BILL <span class="type-animation animating">COLLECTOR</span></h1>
      </div>
      <form action="login.php" method="post" name="loginForm" onsubmit="return validateForm()">
        <div class="input-group">
          <label for="username">Username:</label>
          <input type="text" id="username" name="username" required>
        </div>
        <div class="input-group">
          <label for="password">Password:</label>
          <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn">Login</button>
      </form>
    </div>
    <div class="blob"></div>
  </div>
  <script>
    function validateForm() {
      var username = document.forms["loginForm"]["username"].value;
      var password = document.forms["loginForm"]["password"].value;

      if (username == "" || password == "") {
        alert("All fields must be filled out");
        return false;
      }
    }
  </script>
</body>
</html>
