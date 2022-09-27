<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
</head>

<body>
    <form action="{{ route('auth.login') }}" method="POST">
        @csrf
        <input type="text" name="username" placeholder="Username">
        <br>
        <input type="password" name="password" placeholder="Password">
        <hr>
        <button type="submit">LOGIN</button>
    </form>
</body>

</html>