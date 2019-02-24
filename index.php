<?php
$context = stream_context_create(array(
    'http' => array('ignore_errors' => true)
));
$response = file_get_contents('https://ragnarokonline.gungho.jp/', false, $context);
$servertime = str_replace('Date: ', '', $http_response_header[4]);

$format = 'D, d M Y H:i:s O';
$date = DateTime::createFromFormat($format, $servertime);
$date->setTimeZone(new DateTimeZone('Asia/Tokyo'));

 ?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-51164693-4"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-51164693-4');
    </script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>アルデバラン時計塔時刻管理局</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/siimple@3.3.0/dist/siimple.min.css">
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="siimple-jumbotron">
      <div class="siimple-jumbotron-title">アルデバラン時計塔時刻管理局</div>
      <div class="siimple-jumbotron-detail">冒険者の皆様に（たぶん）正確な時刻をお伝えします</div>
    </div>

    <div class="clock siimple-box">
      <div class="date siimple-box-subtitle">
        <span id="year"></span><span id="month"></span><span id="day"></span>
      </div>
      <div class="time siimple-box-title">
        <span id="hour"></span><span id="minute"></span><span id="second"></span>
      </div>
    </div>

    <div class="siimple-tip siimple-tip--warning siimple-tip--exclamation warning">
      おそらく公式のHTTPサーバーとゲームサーバーの時刻は同じであろう、という考えに基づき<br>
      HTTPサーバーから取得した時刻を表示しています。<br>
      仕組み上最大で2秒程度の遅れが出ます。
    </div>
    <div class="siimple-footer" align="center">
      アルデバラン時計塔時刻管理局 by JIKE <a href="https://ro-mastodon.puyo.jp/@jike">Mastodon</a> <a href="https://twitter.com/jike37">Twitter</a><br>
      (c)Gravity Co., Ltd. & Lee MyoungJin(studio DTDS). All rights reserved.<br>
      (c)GungHo Online Entertainment, Inc. All Rights Reserved.
    </div>
  </body>
  <script>
    let changeDate = (dateobj) => {
      document.getElementById('year').textContent = dateobj.getFullYear();
      document.getElementById('month').textContent = dateobj.getMonth()+1;
      document.getElementById('day').textContent = dateobj.getDate();
      document.getElementById('hour').textContent = ('0'+dateobj.getHours()).slice(-2);
      document.getElementById('minute').textContent = ('0'+dateobj.getMinutes()).slice(-2);
      document.getElementById('second').textContent = ('0'+dateobj.getSeconds()).slice(-2);
      dateobj.setSeconds(dateobj.getSeconds()+1);
    }

    let datedata = "<?php echo $date->format('Y,m,d,H,i,s');?>";
    datedata = datedata.split(',');
    let date = new Date(...datedata);
    changeDate(date);
    setInterval("changeDate(date)", 1000);
  </script>
</html>
