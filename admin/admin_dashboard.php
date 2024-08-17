<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Admin Dashboard</title>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Open Sans', sans-serif;
        }

        .container {
            margin-top: 50px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #343a40;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        ul li {
            margin: 10px 0;
        }

        ul li a {
            display: block;
            padding: 10px 15px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        ul li a:hover {
            background-color: #0056b3;
        }

        ul li a:active {
            background-color: #004085;
        }

        ul li a:visited {
            color: #ffffff;
        }

        ul li a:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
        }

        @media (min-width: 576px) {
            .container {
                width: 50%;
            }
        }

        @media (min-width: 768px) {
            .container {
                width: 40%;
            }
        }

        @media (min-width: 992px) {
            .container {
                width: 30%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="../index.php">Home Page</a></li>
            <li><a href="admin_add_product.php">Add Product</a></li>
            <li><a href="admin_edit_product.php">Edit Product</a></li>
            <li><a href="admin_delete_product.php">Delete Product</a></li>
            <li><a href="admin_view_orders.php">View Orders</a></li>
            <li><a href="admin_view_users.php">View Users</a></li>
        </ul>
    </div>
</body>
</html>
