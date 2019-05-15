<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<script src="/js/jquery-1.11.2.min.js"></script>
<body>
<input type="submit" value="走你" id="btn">
</body>
</html>
<script>
    $('#btn').click(function() {

        $.ajax({
            url: 'http://vm.weixinpay.com/index',
            type: "get",
            dataType: 'jsonp',
            jsonp: "jsonpCallback",
            success: function (msg) {
                console.log(msg);
            }
        })
    })
</script>