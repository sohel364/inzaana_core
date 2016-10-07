<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>You have changed your profile information!</title>
</head>
<body>
    <h1>Hi! {{ $user->name }}</h1>

    <p>
    	We have found some changes of profile information of yours at inzaana.com .
    </p>

    <p>
        We just need you to <a href='{{ url("/dashboard/edit/mail/confirm/users/{$user->id}/{$data['request_url']}") }}'> confirm your changes</a> real quick!
    </p>
</body>
</html> 