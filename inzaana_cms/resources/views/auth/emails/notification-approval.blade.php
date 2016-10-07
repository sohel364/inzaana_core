<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your {{ $data['type'] }} is {{ $data['status'] }}! </title>
</head>
<body>
    <h1>Hi {{ $user->name }}</h1>

    <p>
    	You have requested to approve a {{ $data['type'] }} stated <b> {{ $data['item_name'] }} </b> on {{ $data['created_at'] }}.
    </p>

    <p>
        We are very {{ ( strtolower($data['status']) == 'approved' ? 'happy' : 'sorry') }} to say that, our element auditing team has {{ strtolower($data['status']) }} your request.
    </p>
    <p>
        Thank you for staying with us and contributing to Inzaana.
    </p>
    <p>
        Thanks & Regards,<br/>
        Inzaana Admin
    </p>
</body>
</html> 