<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="profile.css">
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer" />
  <title>ICT HomeWork</title>
</head>

<body>
  <?php
  $db_server = "localhost";
  $db_user = "root";
  $db_pwd = "";
  $db_name = "ict-homework";
  $isRegistered = false;

  try {
    $connection = new mysqli($db_server, $db_user, $db_pwd, $db_name);
  } catch (mysqli_sql_exception) {
    die("Connection failed: " . $connection->connect_error);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
    $first_name = filter_input(INPUT_POST, "first_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $last_name = filter_input(INPUT_POST, "last_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $pwd_plain = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    $pwd_hash = password_hash($pwd_plain, PASSWORD_DEFAULT);

    if (isset($_POST["submit_button"])) {
      $sql_insert = "INSERT INTO users (email, password_hash, fist_name, last_name) 
              VALUES ('$email', '$pwd_hash', '$first_name', '$last_name')";

      try {
        mysqli_query($connection, $sql_insert);
        $isRegistered = true;
      } catch (mysqli_sql_exception) {
        echo "Could not insert data!";
        $isRegistered = false;
      }

      if ($isRegistered) {
        $sql_select = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($connection, $sql_select);

        if (mysqli_num_rows($result) > 1) {
          $row = mysqli_fetch_assoc($result);
        }
      }
    }
  }
  ?>
  <?php if ($isRegistered != true): ?>
    <main class="app-wrapper">
      <img
        src="https://img.freepik.com/free-vector/nature-scene-with-river-hills-forest-mountain-landscape-flat-cartoon-style-illustration_191095-260.jpg?semt=ais_hybrid"
        alt="nature.jpg"
        class="nature-img" />
      <div class="form-wrapper">
        <header class="form-head-wrapper">
          <h1 class="form-mainheader">Create Acount</h1>
          <p class="form-subheader">
            Use your credentials to create a new account
          </p>
        </header>
        <form action="index.php" method="post" name>
          <div class="input-cont">
            <i class="fa-regular fa-envelope icon icon-email"></i>
            <input
              placeholder="Email"
              class="form-email-input"
              type="email"
              name="email"
              required />
          </div>
          <div class="input-cont">
            <i class="fa-regular fa-user icon icon-fn"></i>
            <input
              placeholder="First Name"
              class="form-fn-input"
              type="text"
              name="first_name"
              required />
          </div>
          <div class="input-cont">
            <i class="fa-regular fa-user icon icon-sn"></i>
            <input
              placeholder="Second Name"
              class="form-ln-input"
              type="text"
              name="last_name" />
          </div>
          <div class="input-cont">
            <i class="fa-solid fa-lock icon icon-lock"></i>
            <input
              placeholder="Password"
              class="form-pwd-input"
              type="password"
              name="password"
              required />
          </div>
          <button class="form-submit-button" type="submit" name="submit_button">Sign Up</button>
        </form>
      </div>
    </main>
  <?php else: ?>
    <div class="profile-wrapper">
      <div class="profile-cont">
        <div class="user-icon-wrapper">
          <i class="fa-solid fa-user profile-icon"></i>
        </div>
        <div class="profile-header-wrappers">
          <h3 class="profile-mainheader"><?php echo htmlspecialchars($_POST["first_name"] . " " . htmlspecialchars($_POST["last_name"])); ?></h3>
          <h5 class="profile-subheader"><?php echo htmlspecialchars($_POST["email"]) ?></h5>
        </div>
        <hr class="sep-hr">
        <div class="profile-attrs">
          <h5 class="profile-label">First Name</h5>
          <h5 class="profile-label">Second Name</h5>
          <h5 class="profile-label">Email</h5>
          <h5 class="profile-label">Password</h5>
          <p class="profile-value val-fn"><?php echo htmlspecialchars($_POST["first_name"]) ?></p>
          <p class="profile-value val-ln"><?php echo htmlspecialchars($_POST["last_name"]) ?></p>
          <p class="profile-value val-e"><?php echo htmlspecialchars($_POST["email"]) ?></p>
          <p class="profile-value val-pwd"><?php echo htmlspecialchars($_POST["password"]) ?></p>
        </div>
      </div>
    </div>
  <?php endif; ?>
</body>
  <?php if ($isRegistered): ?>
    <link rel="stylesheet" href="body-img.css">
  <?php endif; ?>
</html>