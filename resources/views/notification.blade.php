<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Notification: </h1>

    <script src="{{ asset("js/app.js") }}"></script>
    <script>
        Echo.channel('public_channel').listen(".public_notification", (e) => {
            console.log(e);
        })
    </script>
</body>
</html>
