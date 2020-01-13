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

