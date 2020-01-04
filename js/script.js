var Cart = {
    cache: 100.00,
    amount: 0.00,
    prices: [],
    products: [],
    quantities: [],
    changeCache: function (price) {
        this.cache -= parseFloat(price);
        this.cache = Math.round(this.cache * 100) / 100;
    },
    changeAmount: function (price) {
        this.amount += parseFloat(price);
        this.amount = Math.round(this.amount * 100) / 100;
    },
    setProduct: function (product) {
        var index = this.products.indexOf(product);
        if (index == -1 && this.products[0] != '') {
            this.products.push(product);
            return this.products.indexOf(product);
        } else if (index == -1 && this.products[0] == '') {
            this.products.splice(0, 1, product);
            return this.products.indexOf(product);
        }
        else return index;
    },
    addQuantities: function (index) {
        if (typeof this.quantities[index] == 'undefined' || this.quantities[index] == '') this.quantities.splice(index, 0, 1);
        else this.quantities[index] = this.quantities[index] - (-1);
    },
    deductQuantities: function (index) {
        if (typeof this.quantities[index] != 'undefined' && this.quantities[index] > 0) this.quantities[index]--;
    },
    addPrices: function (index, price) {
        if (typeof this.prices[index] == 'undefined' || this.prices[index] == '') this.prices.splice(index, 0, price);
    },
    addToCart: function (id) {
        var name = document.getElementById("name" + id).textContent;
        var price = document.getElementById("price" + id).textContent;
        if (this.cache < price) return {error: 'not enough money'};
        else {
            this.changeCache(price);
            this.changeAmount(price);
            var index = this.setProduct(name);
            this.addPrices(index, price);
            this.addQuantities(index);
        }
    },
    toString: function () {
        return 'cache:' + this.cache + '&amount:' + this.amount + '&products:' + this.products.join(',') +
            '&quantities:' + this.quantities.join(',') + '&prices:' + this.prices.join(',');
    },
    addOneMore: function (index) {
        var price = parseFloat(this.prices[index]);
        if (this.cache < price) return {error: 'not enough money'};
        else {
            this.changeCache(price);
            this.changeAmount(price);
            this.addQuantities(index);
        }
        document.getElementById("cache").innerHTML = this.cache;
        document.getElementById("quantity" + index).innerHTML = this.quantities[index];
        document.getElementById("amount" + index).innerHTML = Math.round(this.quantities[index] * this.prices[index] * 100) / 100 + '$';
        document.cookie = 'cart=' + this.toString() + '; path=/';
    },
    removeOne: function (index) {
        var price = parseFloat(this.prices[index]);
        if (this.quantities[index] < 1) return {error: 'you do not have this product'};
        else {
            this.changeCache(-price);
            this.changeAmount(-price);
            this.deductQuantities(index);
        }
        document.getElementById("cache").innerHTML = this.cache;
        document.getElementById("quantity" + index).innerHTML = this.quantities[index];
        document.getElementById("amount" + index).innerHTML = Math.round(this.quantities[index] * this.prices[index] * 100) / 100 + '$';
        document.cookie = 'cart=' + this.toString() + '; path=/';
    },
    forAjax: function () {
        var data = '';
        for (p in this.products) {
            if (this.quantities[p] > 0) {
                data += this.products[p] + '=' + this.quantities[p] + '&';
            }
        }
        return data;
    },
    reset: function (cache) {
        this.cache = cache;
        this.amount = 0;
        this.prices = [];
        this.products = [];
        this.quantities = [];
        document.cookie = 'cart=' + this.toString() + '; path=/';
    }
};

function cclick(a) {
    var z = Cart.addToCart(a);
    document.getElementById("cache").innerHTML = Cart.cache;
    if (z !== undefined) {
        window.alert("You don't have enough money!");
    }
    document.cookie = 'cart=' + Cart.toString() + '; path=/';
}

function loaded() {
    var cookies = document.cookie;
    if (cookies && cookies != 'cart=') {
        cookies = cookies.split(';');
        cookies = cookies[0].split('&');
        Cart.cache = parseFloat(cookies[0].split(':')[1]);
        Cart.amount = parseFloat(cookies[1].split(':')[1]);
        Cart.products = cookies[2].split(':')[1].split(',');
        Cart.quantities = cookies[3].split(':')[1].split(',');
        Cart.prices = cookies[4].split(':')[1].split(',');
    }
}

function init() {
    if (document.addEventListener) document.addEventListener("load", loaded());
    else if (document.attachEvent) document.attachEvent("load", loaded());
}

function goToCart() {
    window.location = '/cart';
}
function makeOrder() {
    var transport = document.getElementById('transport').value;
    if (transport === '') {
        window.alert('You have to choose transfer type');
        return;
    }
    if (transport == 1) {
        if (Cart.cache < 5) {
            window.alert('you do not have enough money. Cost of UPS 5$');
            return 0;
        }
    }
    sendOrder(transport);
}
function makeCart() {
    var head = '<table>' +
        '<tr><th>Product</th><th>Price</th><th>Quantity</th><th>Amount</th><th></th><th></th></tr>';
    var foot = '</table>';
    var body = '';
    if (Cart.products[0] != '' && typeof Cart.products[0] != 'undefined') {
        for (product in Cart.products) {
            body += '<tr><td>' + Cart.products[product] + '</td>' +
                '<td>' + Cart.prices[product] + '$</td>' +
                '<td' + ' id="quantity' + product + '">' + Cart.quantities[product] + '</td>' +
                '<td class="amount" id="amount' + product + '">' + Math.round(Cart.prices[product] * Cart.quantities[product] * 100) / 100 + '$</td>' +
                '<td><input class="button" type="button" value="Add" id="product' + product + '" onclick="Cart.addOneMore(' + product + ')" />' + ' </td>' +
                '<td><input class="button" type="button" value="Remove" id="product' + product + '" onclick="Cart.removeOne(' + product + ')" />' + ' </td></tr>';
        }
        foot += '<div class="tbl">'+
            '<select id="transport">' +
            '<option value="">transport</option>' +
            '<option value="0">pick up</option>' +
            '<option value="1">UPS</option>' +
            '</select></div>' +
            '<div class="tbl"><input class="button right" type="button" value="Order" onclick="makeOrder()"/></div>';
    }
    return head + body + foot;
}

init();

function sendOrder(transport) {
    var xhttp;
    if (window.XMLHttpRequest) {
        xhttp = new XMLHttpRequest();
    } else {
        xhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 201) {
            var rest = Cart.cache - (transport == 1 ? 5 : 0);
            window.alert('Thank you. Your order created. You rest:' + rest + '$');
            Cart.reset(rest);
            window.location = '/';
        } else if (this.readyState == 4 && this.status == 400) {
            window.alert('Sorry. There was error when we create your order');
        }
    };
    xhttp.open("POST", "/order.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(Cart.forAjax() + '&transport=' + transport);
}