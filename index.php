<html>
<head>
    <title>Test Shop</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="js/script.js"></script>
</head>
<body>
<div class="header">
    <div class="title"><h2><a href="/">Test shop</a></h2></div>
    <div class="cart">
        <ul>
            <li><a href="/cart">Cart</a></li>
            <li>Your cache: <span class="cache" id="cache">100</span>$</li>
        </ul>
    </div>
</div>
<div class="container">
    <?php require_once ('products.php');?>
</div>
<script>
    document.getElementById('cache').innerHTML = Cart.cache;
</script>
</body>
</html>
