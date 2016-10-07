<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your have {{ strtolower($data['status']) }} an element of {{ $data['type'] }}! </title>
</head>
<body>
    <h1>Hi {{ $user->name }}</h1>

    <p>
    	You have successfully {{ strtolower($data['status']) }} an element of {{ $data['type'] }} titled <b> {{ $data['item_name'] }} </b> which requested on {{ $data['created_at'] }}.
    </p>
    <p>
        Thanks & Regards,<br/>
        Inzaana Auditing Team
    </p>
</body>
</html> 