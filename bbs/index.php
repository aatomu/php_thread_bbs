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
        #sidebar{
          position: -webkit-sticky;
          position: sticky;
          top: 15%;
        }
        #art{
          position: fixed;
          font-size: 200%;
          bottom: 5%;
          right: 10%;
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
                -site map-
              </b>
            </u>
          </font>
        </td>
      </tr>
      <tr>
        <td>
          任意(しても問題なし
        </td>
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
              アクセスカウンター
              ※プログラムを自由にはめてね
          </td>
        </tr>
    </table>
    <!--Ascii Art-->
    <div id="art">
     <pre>
 ∧___∧
( ´∀` )
(     )
|  |  |
(__)__)
      </pre>
    </div>
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
      $maxline =10;
      $line = shell_exec('wc -l ./thread/'.$page.".txt | sed \"s|./thread/${page}.txt||\"");
      $line_text = $line + 1
      $page = $_GET['page'];
      $name = "";
      $message = "";
      if (isset($_POST['send']) === true) {
        if ($line >= $maxline) {
          echo "<div id='text_box'>メッセージが".$maxline."を超えました\n新しく立ててください</div>";
          exit;
        }
        $name = $_POST["name"];
        $message = $_POST["message"];
        $date = date("Y/m/d H:i:s");
        $fp = fopen("./thread/".$page.".txt", "a");
        $line = str_replace(array("\r", "\n"), '', $line);
        fwrite($fp,"No.".$line_text.",Name:".$name.",Date:".$date.",Text:".$message."\n");
        fclose($fp);
        header("Location: ./?page=".$page);
        exit;
      }
    ?>
  </body>
</html>
