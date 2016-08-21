<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secured Login for Administrator</title>
</head>
<body>
    <h1>Hello! Super Admin</h1>

    <p>
    	You have intended to login as super user to the web portal Inzaana.
    </p>
    <p>
    	If you find this email not caused by your action, Please secure/ change your email credentials
    </p>

    <p>
        We just need you to <a href='{{ url("/signup/admin/t/{$token}/o/{$original}") }}'>login as admin</a> real quick!
    </p>
</body>
</html> 