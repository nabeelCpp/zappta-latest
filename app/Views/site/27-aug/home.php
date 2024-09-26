<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zappta Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sticky-heading {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            text-align: center;
            padding: 10px 0;
            z-index: 1000;
        }
        .main-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px 0;
        }
        .main-header .logo {
            flex: 0 0 10%;
        }
        .main-header .search-form {
            flex: 0 0 50%;
            display: flex;
            align-items: center;
        }
        .main-header .search-form .form-control {
            border-right: 0;
        }
        .main-header .search-form .btn-search {
            border-left: 0;
        }
        .main-header .icons {
            display: flex;
            align-items: center;
            flex: 0 0 15%;
        }
        .main-header .icons .badge-btn {
            position: relative;
            margin-right: 20px;
        }
        .main-header .icons .badge-btn .badge {
            position: absolute;
            top: -5px;
            right: -10px;
        }
        .main-header .z-coins {
            flex: 0 0 10%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .main-header .z-coins .z-icon {
            font-weight: bold;
            font-size: 1.5rem;
            margin-right: 5px;
        }
        .main-header .z-coins .coin-text {
            position: relative;
        }
        .main-header .z-coins .coin-text .top-text {
            position: absolute;
            top: -5px;
            right: 0;
            font-size: 0.8rem;
        }
        .main-header .z-coins .coin-text .bottom-text {
            position: absolute;
            bottom: -5px;
            right: 0;
            font-size: 0.8rem;
        }
        .main-header .auth-buttons {
            flex: 0 0 20%;
            display: flex;
            justify-content: space-between;
        }
    </style>
</head>
<body>
    <div class="sticky-heading">
        Winners for campaign has been announced. <a href="#">Click here</a>
    </div>

    <header class="main-header container">
        <div class="logo">
            <img src="logo.png" alt="Logo" class="img-fluid">
        </div>
        <form class="search-form">
            <select class="form-select me-2">
                <option value="all">All Categories</option>
                <option value="electronics">Electronics</option>
                <option value="fashion">Fashion</option>
            </select>
            <input type="text" class="form-control" placeholder="Search for products...">
            <button type="submit" class="btn btn-primary btn-search">Search</button>
        </form>
        <div class="icons">
            <button class="btn badge-btn position-relative">
                <i class="bi bi-heart"></i>
                <span class="badge bg-danger">12</span>
            </button>
            <button class="btn badge-btn position-relative">
                <i class="bi bi-cart"></i>
                <span class="badge bg-danger">12</span>
            </button>
        </div>
        <div class="z-coins">
            <span class="z-icon">Z</span>
            <div class="coin-text">
                <span class="top-text">Coins</span>
                <span class="bottom-text">100</span>
            </div>
        </div>
        <div class="auth-buttons">
            <button class="btn btn-outline-primary">Sign Up</button>
            <button class="btn btn-primary">Sign In</button>
        </div>
    </header>

    <!-- Add the rest of the page content here -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
