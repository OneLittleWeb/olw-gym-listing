<!DOCTYPE html>
<html>
<head>
    <title>Contact us</title>
</head>
<body>

<h2>Hey !</h2> <br><br>

You received an email from : {{ $contact->name }} <br><br>

User details: <br><br>

Name: {{ $contact->name }}<br>
Email: {{ $contact->email }}<br>
Subject: {{ $contact->subject }}<br>
Message: {{ $contact->message }}<br><br>

Thanks

</body>
</html>
