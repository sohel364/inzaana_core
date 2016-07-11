<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up Confirmation</title>
</head>
<body>
    <h1>Thanks for signing up!</h1>

    <p>
    	You are going to open a store named <b>{{ $data['storeName'] }}</b> under a subdomain (<b> {{ $data['site'] }} </b>)
    </p>

    <p>
        We just need you to <a href='{{ url("register/confirm/{$user->token}/site/{$data['site']}/store/{$data['storeName']}") }}'>confirm your email address</a> real quick!
    </p>
</body>
</html> 