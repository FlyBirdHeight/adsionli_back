<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>adsionli</title>
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.js"></script>
    <style>
        .header{
            width:100%;
            height: 60px;
            text-align: center;
            background-color:#000;
            line-height: 60px;
            color: #fff;
        }
        .title{
            font-size: 20px;
            font-weight: 600;
        }
        .content{
            margin: auto;
            width: 750px;
            text-align: center;
        }
        .content-title{
            font-size: 20px;
            text-align: center;
            margin-top: 60px;
        }
        .content-email{
            font-size: 17px;
            font-weight: 600;
            margin-top: 20px;
        }
        .content-notify{
            font-size: 16px;
            font-weight: 600;
            margin-top: 20px;
            color: #000;
        }
        .foot{
            position: absolute;
            height: 60px;
            width: 100%;
            bottom: 0;
            background-color: rgb(217,217,217);
            text-align: center;
            line-height: 60px;
        }
        .foot-content{
            color: #777;
        }
    </style>
</head>
<body style="margin:auto;background-color: rgb(245,245,241);height:800px;overflow: hidden;">
    <div class="header">
        <div>
            <span class="title">AdsionLi -- 属于AdsionLi的个人站点</span>
        </div>
    </div>
    <div class="content">
        <div class="content-title">
            Hello,欢迎{{$name}}加入AdsionLi的个人站点进行交流！
            <img src="http://p53z0yfgy.bkt.clouddn.com/jump.gif" alt="50*50" width="50px" height="50px">
        </div>
        <div class="content-email">
            请点击这里  <a href="{{$url}}"><span style="color: red;">验证邮箱</span></a>
        </div>
        <div class="content-notify">
            注意哦，有效时间只有6个小时，请抓紧！
            <br>
            <br>
            <img src="http://p53z0yfgy.bkt.clouddn.com/cat.gif" alt="50*50" width="120px" height="120px">
        </div>
    </div>
    <div class="foot">
        <div class="foot-content">
            © {{\Carbon\Carbon::now()->year}} AdsionLi. Welcome to exchange.
        </div>
    </div>
</body>
</html>
