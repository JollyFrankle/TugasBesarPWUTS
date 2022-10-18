<?php
session_start();

if ($_SESSION["id"] ?? false) {
    header("Location: ../page/Home.php");
}
?>

<!Doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- bootstrap 5.2.1 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link href="../assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/intro.css" />
    <link rel="icon" href="../assets/images/mc-icons/bookshelf.png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js" integrity="sha512-A7AYk1fGKX6S2SsHywmPkrnzTZHrgiVT7GcQkLGDe2ev0aWb8zejytzS8wjo7PGEXKqJOrjQ4oORtnimIRZBtw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" integrity="sha512-1cK78a1o+ht2JcaW6g8OXYwqpev9+6GqOkz9xmBN9iUUhIndKtxwILGWYOSibOKjLsEdjyjZvYDq/cZwNeak0w==" crossorigin="anonymous" referrerpolicy="no-referrer"   />
    <title>Login &bull; Minecraft Library</title>
</head>

<body>
    <div class="bg bg-light text-dark">
        <div class="background-tint"></div>
        <div class="container min-vh-100 d-flex align-items-center justify-content-center">
            <div class="card text-white bg-dark ma-5 shadow" style="min-width: 25rem;" data-aos="flip-left" data-aos-duration="500">
                <div class="card-header text-center">
                    <a href="./Welcome.php" class="btn text-white">
                        <img src="../assets/images/mc-icons/bookshelf.png" alt="bookshelf" width="32" height="32" class="mc-icon me-1">
                        <strong>Minecraft</strong> Library
                    </a>
                </div>
                <div class="card-body">
                    <p class="text-center fw-bold lead">Log in</p>
                    <form action="../process/login.php" method="post">
                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            <!-- <input type="text" class="form-control" id="email" name="email" placeholder="Email" required> -->
                            <div class="form-floating text-muted">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Username atau Email" required>
                                <label for="email">Username atau Email</label>
                            </div>
                        </div>
                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <!-- <input type="password" class="form-control" id="password" name="password" placeholder="Password" required> -->
                            <div class="form-floating text-muted">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mb-4 w-100" name="action" value="login">Login</button>
                    </form>
                    <p class="mb-0">Don't have an account yet? <a href="./Register.php">Click here!</a></p>
                </div>
            </div>
        </div>
    </div>



    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.1/js/bootstrap.min.js"></script>

    <!-- reCAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js?hl=id" async defer></script>
    <script>
        AOS.init();
    </script>
</body>

</html>