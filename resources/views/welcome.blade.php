<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>


<body>
    <form method="POST" action="{{route('checkout')}}">
        @csrf
        total:<input type="text" name="total"><br>
        quantity:<input type="text" name="quantity"><br>
        description:<input type="text" name="description"><br>

        <button>Checkout</button>
    </form>
</body>


</html>