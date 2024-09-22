<?php include_once "header.php"?>
<body>
     <div class="wrapper">
        <section class="form login">
            <header>Realtime Chat App</header>
            <form action="#">
                <div class="error-txt"></div>
                <div class="field input">
                    <label for="email">Email Address</label>
                    <input name="email" type="text" placeholder="Enter your email">
                </div>
                <div class="field input">
                    <label for="password">Password</label>
                    <input name="password" type="password" placeholder="Enter your password">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field button">
                    <input type="submit" value="Continue to chat">
                </div>
            </form>
            <div class="link">Not yet signed up? <a href="sign-up.php">Signup now</a></div>
        </section>
     </div>
     <script src="javascript/pass-show-hide.js"></script>
     <script src="javascript/login.js"></script>
</body>
</html>
