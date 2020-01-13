<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Shop!</title>
  </head>
  <body>
  <div class="container">
      <h1>Welcome to Shop!</h1>
    
      <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <a href="/cart">Cart</a>Your cache: 
          <span class="badge badge-primary badge-pill" id="cache">100</span> $
        </li>
        <!--<li class="list-group-item d-flex justify-content-between align-items-center">
          Dapibus ac facilisis in
          <span class="badge badge-primary badge-pill">2</span>
        </li>-->
        
    </ul>
        
    <table class="table">
    <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">name</th>
      <th scope="col">price</th>
      <th scope="col">Add</th>
   </tr>
    </thead>
    <tbody>
        <?php foreach($productList as $product):?>
    <tr>
      <th scope="row"><?= $product['id']?></th>
      <td id='name<?=$product['id']?>'><?= $product['name']?></td>
      <td id='price<?=$product['id']?>'><?= $product['price']?></td>
      <td id='<?= $product['id']?>'><input class='button' type='button' value='Add' onclick='cclick(<?=$product['id']?>)'></td></td>
    </tr>
        <?php endforeach ?>
    </tbody>
    </table>
    </div>
    <script src="../../public/js/script.js"></script>
    <script>
        document.getElementById('cache').innerHTML = Cart.cache;
     </script>
   
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>