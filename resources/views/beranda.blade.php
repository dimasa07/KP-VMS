<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
</head>

<body>
    <h1>
        @if(!is_null($user))
            Welcome, {{ $user->username }}, {{ $user->role }}
        @endif
    </h1>
</body>

</html>