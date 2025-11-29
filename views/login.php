<?php
session_start();
$error = $_SESSION['error'] ?? '';
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">

  <div class="card shadow p-4 w-100" style="max-width: 450px;">
    <h3 class="text-center mb-4">Login</h3>

    <?php if ($error): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="../handlers/auth.php">
      <input type="hidden" name="action" value="login">

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input 
          type="email" 
          name="email" 
          class="form-control" 
          placeholder="Enter email"
          required
        >
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input 
          type="password" 
          name="password" 
          class="form-control" 
          placeholder="Enter password"
          required
        >
      </div>

      <button class="btn btn-primary w-100">Login</button>

      <p class="text-center mt-3">
        Don't have an account? <a href="register.php">Register</a>
      </p>
    </form>

  </div>

</div>

</body>
</html>
