<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>


<body>
    <form method="POST" action="{{route('webhook')}}">
        {{@csrf}}
        <input type="text" name="name">
        <input type="text" name="email">
        <input type="text" name="phone">
        <input type="text" name="total">
        <input type="text" name="quantity">
        <input type="text" name="description">

        <button>Checkout</button>
    </form>
</body>


</html>