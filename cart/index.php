<html>
<head>
    <title>Test Shop</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script src="../js/script.js"></script>
</head>
<body>
<div class="header">
<div class="title"><h2><a href="/">Test shop</a></h2></div>
    <div class="cart">
        <ul>
            <li><a href="/cart">Cart</a></li>
            <li>Your cache: <span id="cache">100</span>$</li>
        </ul>
    </div>
</div>
<div id="cart"></div>
<script>
    document.getElementById('cache').innerHTML = Cart.cache;
    if(window.location.pathname == '/cart' || window.location.pathname == '/cart/'){
        console.log(document.getElementById('cart'));
        document.getElementById('cart').innerHTML = makeCart();
    }
</script>
</body>
</html>
