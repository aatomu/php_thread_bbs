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
        <!--heightは見出し*50-->
    <table border="10" width="200" bgcolor="faf0e6" cellpadding="0" cellspacing="10" align="right" id="sidebar">
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
          任意
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
      //表示限界
      $maxline =500;
      //表示するページ
      $page = $_GET['page'];
      //行数の入手&整形
      $line = shell_exec('wc -l ./thread/'.$page.".txt | sed \"s|./thread/${page}.txt||\"");
      $line_text = $line + 1;
      //リセット
      $name = "";
      $message = "";
      if (isset($_POST['send']) === true) {
        //表示限界チェック
        if ($line >= $maxline) {
          echo "<div id='text_box'>メッセージが".$maxline."を超えました\n新しく立ててください</div>";
          exit;
        }
        //メッセージのいろいろ
        $name = $_POST["name"];
        $message = $_POST["message"];
        $message = str_replace(array("\r\n","\r","\n"), '<br>', $message);
        $date = date("Y/m/d H:i:s");
        $fp = fopen("./thread/".$page.".txt", "a");
        $line = str_replace(array("\r", "\n"), '', $line);
        fwrite($fp,"No.".$line_text.",Name:".$name.",Date:".$date.",Text:".$message."\n");
        fclose($fp);
        header("Location: ./?page=".$page);
        exit;
      }
      if ( $page != "") {
        //page表示
        $cmd = ('./log.sh '.$page);
        echo shell_exec($cmd);
      }else{
        //page=がない時にlistの表示
        $url = ($_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
        $cmd = ('./list.sh '.$url);
        echo shell_exec($cmd);
      }
      //変数取得して実行
      if (isset($_GET['newpage']) === true && isset($_GET['type']) === true) {
        $newpage = $_GET['newpage'];
        $type = $_GET['type'];
        //page生成
        $cmd = ('./run.sh '.$newpage.' '.$type);
        echo shell_exec($cmd);
      }
    ?>
    <form action="" method="post">
      <h3>Name:</h><br>
        <input type="text" id="name" name="name">
      <br>
      <h3>Text:</h><br>
        <textarea id="message" name="message" value="" style="width: 30%; height: 100px;" ></textarea>
      <br>
      <input type="submit" name="send" value="送信する">
    </form>
  </body>
</html>
