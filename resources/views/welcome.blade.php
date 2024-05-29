<!DOCTYPE html>
<html> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
</head>


<body >
    <form method="POST" action="{{route('checkout')}}">
        @csrf
        total:<input type="text" name="total"><br>
        quantity:<input type="text" name="quantity"><br>
        description:<input type="text" name="description"><br>

        <button>Checkout</button>
    </form>

   
</body>

<script >

</script>
</html>