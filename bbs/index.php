<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <style>
      body {
        background-color: #ffff80;
      }
    </style>
    <style type="text/css">
      <!--
        #sidebar{
          position: -webkit-sticky;
          position: sticky;
          top: 15%;
          }
        #top {
          background-color: #ffffff;
          outline-style: dashed;
          outline-width: 10px;
          font-size: 500%;
          text-align: center;
        }
        #text_box {
          font-size: 150%;
          text-align: left;
        }
      -->
    </style>
  </head>
  <body>
    <!--サイドバー-->
    <!--heightは見出し*50 行*20-->
    <table border="10" width="200" background="" cellpadding="0" cellspacing="10" align="right" id="sidebar">
      <caption>
        サイドバー
      </caption>
      <tr height="50">
        <td>
          <font color="red">
            <u>
              <b>
                -main-
              </b>
            </u>
          </font>
        </td>
      </tr>
      <tr>
        <th background="background.png">
          1.
            <a href="http://atomic.f5.si:8816/board/board1.php">
              >1st board<
            </a>
          <br>
          2.
            <a href="http://atomic.f5.si:8816/board/board2.php">
              >2nd board<
           </a>
          <br>
          3.
            <a href="http://atomic.f5.si:8816/board/board3.php">
              >3rd board<
           </a>
          <br>
          4.
            <a href="http://atomic.f5.si:8816/2048/">
              >game of 2048<
           </a>
          <br>
          5.
            <a href="http://atomic.f5.si:8816/SlitherGame/">
              >game of snake<
            </a>
          <br>
          <script type="text/javascript">
            function gate() {
              var UserInput = prompt("パスワードを入力して下さい:","");
                if ( UserInput == "typingg" ) {
                  location.href = "http://atomic.f5.si:8816/typing.html";
                }
                  else {
                    alert("pass is typingg");
                  }
                }
          </script>
          6.
            <input type="button" value="type score?" onclick="gate();">
          </tr>
          <tr height="50">
            <td>
              <font color="red">
                <u>
                  <b>
                    -other-
                  </b>
                </u>
              </font>
            </td>
          </tr>
          <tr>
            <th background="background.png">
              create by
              <br>
              atomu21263
              <br>
              <a href="https://twitter.com/atomu21263">
                >twitter<
              </a>
          </tr>
          <tr>
            <td>
              <span id="view_today" style="color:rgba(0,0,0,1.0); font-size:15px; background-color:rgba(0,127,0,0.5);"></span>
              <script type="text/javascript">
                timerID = setInterval('clock()',500); //0.5秒毎にclock()を実行
                function clock() {
                 document.getElementById("view_today").innerHTML = getToday();
                }
                function getToday() {
                  var now = new Date();
                  var year = now.getFullYear();
                  var mon = now.getMonth()+1; //１を足すこと
                  var day = now.getDate();
                  var you = now.getDay(); //曜日(0～6=日～土)
                  var hour = now.getHours();
                  var min = now.getMinutes();
                  var sec = now.getSeconds();
                  //曜日の選択肢
                   var youbi = new Array("日","月","火","水","木","金","土");
                  //出力用
                   var s1 = "現在 " + year + "年<br>" + mon + "月" + day + "日 (" + youbi[you] + ")<br>" + hour + ":" + min + ":" + sec;
                return s1;
                }
              </script>
            </td>
          </tr>
          <tr>
            <td>
              アクセスカウンター
              <?php
                $counter_file = 'count.txt';
                $counter_lenght = 8;
                $fp = fopen($counter_file, 'r+');
                if ($fp) {
                  if (flock($fp, LOCK_EX)) {
                    $counter = fgets($fp, $counter_lenght);
                    $counter = $counter + 1 ;
                    rewind($fp);
                    if (fwrite($fp,  $counter) === FALSE) {
                      echo ('<p>'.'ファイル書き込みに失敗しました'.'</p>');
                    }
                  flock ($fp, LOCK_UN);
                  }
                }
                fclose ($fp);
                echo ('<br>');
                echo ('<em>'.$counter.'access</em>');
              ?>
          </td>
        </tr>
    </table>
    <!--メイン-->
    <?php
      $page = $_GET['page'];
      if ( $page != "") {
        //page表示
        $cmd = ('./log.sh '.$page);
        echo shell_exec($cmd);
      }else{
        $url = ($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
        $cmd = ('./list.sh '.$url);
        echo shell_exec($cmd);
      }
      $newpage = $_GET['newpage'];
      $type = $_GET['type'];
      if ( $newpage != "") {
        //page生成
        $cmd = ('./run.sh '.$newpage.' '.$type);
        echo shell_exec($cmd);
      }
    ?>
    <form action="" method="post">
      <label for="name">Name:</label>
        <input type="text" id="name" name="name">
      <br>
      <label for="message">Text:</label>
        <input type="text" id="message" name="message"value="" size="30">
      <br>
      <input type="submit" name="send" value="送信する">
    </form>
    <?php
      $page = $_GET['page'];
      $name = "";
      $message = "";
      if (isset($_POST['send']) === true) {
        $name = $_POST["name"];
        $message = $_POST["message"];
        $date = date("Y/m/d H:i:s");
        $fp = fopen("./thread/".$page.".txt", "a");
        fwrite($fp,"Name:".$name.",Date:".$date.",Text:".$message."\n");
        fclose($fp);
        echo "二重で送られないように!";
        exit();
      }
    ?>
    <h1> made by atomu21263</h>
  </body>
</html>