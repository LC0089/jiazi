<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="/js/jquery-1.11.2.min.js"></script>
</head>
<body>
<table>
    <tr>
        <td>账号</td>
        <td><input type="email" name="user_email" id="user_email"></td>
    </tr>
    <tr>
        <td>密码</td>
        <td><input type="password" name="user_pwd" id="user_pwd"></td>
    </tr>

</table>
<input type="submit" value="Login" id="btn">
</body>
</html>
<script>
    $('#btn').click(function() {
        var data = {};
        var user_email = $('#user_email').val();
        var user_pwd = $('#user_pwd').val();
        data.user_email = user_email;
        data.user_pwd = user_pwd;
        $.ajax({
            method: 'post',
            data: data,
            url: 'doLogin',
            dataType: 'json',
            success: function (msg) {

            }
        })
    })
</script>




