<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>PMS - Home</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #fff;
            color: #000;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .btn-dark {
            background: #000 !important;
            color: #fff !important;
        }
        .btn-outline-dark {
            border-color: #000 !important;
            color: #000 !important;
        }
        .box {
            border: 2px solid #000;
            border-radius: 10px;
            padding: 40px;
            width: 350px;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="box">
    <h3 class="mb-4">Welcome</h3>

    <a href="views/manage-product.php" class="btn btn-dark w-100 mb-3">Admin Panel</a>

    <a href="views/login.php" class="btn btn-outline-dark w-100">User Login</a>
</div>

</body>
</html>
