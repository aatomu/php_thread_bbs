<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <style>
      body {
        background-color: #FFF8DC;
      }
    </style>
    <style type="text/css">
        #sidebar{
          position: -webkit-sticky;
          position: sticky;
          top: 20%;
          right: 10px;
          float: right;
        }
        #art{
          font-size: 200%;
        }
        #top {
          background-color: #FFDAB9;
          outline-style: double;
          outline-width: 10px;
          font-size: 500%;
          text-align: center;
          margin: 2% 10% 0%;
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
    <div id="sidebar">
      <table border="5" width="200" bgcolor="F0FFFF" cellpadding="0" cellspacing="10">
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
          <td>
            create by
            <br>
            atomu21263
            <br>
            <a href="https://twitter.com/atomu21263">
              >twitter<
            </a>
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
    </div>
    <!--メイン-->
    <?php
      //表示限界
      $maxline = 500;
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
        $date = date("Y/m/d H:i:s");
        $line = str_replace(array("\r", "\n"), '', $line);
        //メッセージ 無効化
        $message = htmlspecialchars($message,ENT_QUOTES,'utf-8');
        $message = str_replace(",","，",$message);
        $message = str_replace(array("\r\n","\n","\r"),"<br>",$message);
        $message = str_replace(" ","&ensp;",$message);
        //name message lineを文に変形
        $write = ("No.".$line_text.",Name:".$name.",Date:".$date.",Text:".$message."\n");
        file_put_contents("./thread/".$page.".txt",$write,FILE_APPEND | LOCK_EX);
        header("Location: ./?page=".$page);
        exit;
      }
    require('./function.php');
    ?>
    <hr size=5 color="gray">
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
