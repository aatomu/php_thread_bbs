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
<!--/*
    <br><br>
    <form method="post" enctype="multipart/form-data">
      <font size=5>Pass:</font>
      <input type="text" name="up_pass" maxlength="5" oninput="value = value.replace(/[^0-9]+/i,'');"><br>
      <font size=5>File:</font>
      <input type="file" name="up_file">
      <input type="submit" name="up_send" value="アップロード">
    </form>
    <br><br>
    <form method="post">
      <font size=5>DownloadPass:</font>
      <input type="text" name="down_pass" maxlength="5" oninput="value = value.replace(/[^0-9]+/i,'');"><br>
      <font size=5>File:</font>
      <input type="text" name="down_file">
      <input type="submit" name="down_send" value="ダウンロード">
    </form>
    <?php
      //ファイルのupload
      if (isset($_POST['up_send']) === true ) {
        if (strlen($_POST['up_pass']) == 5 && isset($_FILES['up_file']) === true) {
          $file_size = $_FILES["up_file"]["size"];
          $date = date("Y.m.d,H:i:s");
          $file_name = ($date."_".$_FILES["up_file"]["name"]);
          if ( preg_match("|\s|",$file_name) != "" ) {
            $file_name = preg_replace("|\s|","_",$file_name);
            echo ("change file name to ".$file_name."<br>");
          }
          $file_tmp = $_FILES["up_file"]["tmp_name"];
          $file_pass = $_POST['up_pass'];
          echo ("upload to server : ".$file_name." , Size : ".$file_size."byte password : ".$file_pass."<br>");
            if (is_uploaded_file($file_tmp)) {
              if ( move_uploaded_file($file_tmp , "./file/".$file_name."__".$file_pass)) {
                echo $file_name . "をアップロードしました。<br><br><br>";
              } else {
              echo "ファイルをアップロードできません。";
              }
            $url = ((empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
            header("Location: ".$url);
            exit;
          }
        } else {
          echo "ダウンロード用パスワードが短い(ない)かファイルが設定されていません<br><br>";
        }
      }
      //ファイルのdownload
      if (isset($_POST['down_send']) === true ) {
        if (strlen($_POST['down_pass']) == 5 && isset($_POST['down_file']) === true) {
          $file_name = shell_exec("ls ./file/| grep \"".$_POST['down_file']."\"");
          $file_pass = preg_replace("|.*__|","",$file_name);
          $file_pass = preg_replace("|\s|","",$file_pass);
          if ($_POST['down_pass'] == $file_pass) {
            // ファイルのパス
            $filepath = ("./file/".$_POST['down_file']);
            // リネーム後のファイル名
            $filename = $file_name;
            // ファイルタイプを指定
            header('Content-Type: application/force-download');
            // ファイルサイズを取得し、ダウンロードの進捗を表示
            header('Content-Length: '.filesize($filepath));
            // ファイルのダウンロード、リネームを指示
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            // ファイルを読み込みダウンロードを実行
            readfile($filepath);
          } else {
            echo "ダウンロードパスワードが正しくありません<br><br>";
          }
        } else {
          echo "ダウンロードパスワードが短い(ない)かファイルが設定されていません<br><br>";
        }
      }
      //ファイルの一覧
      $files = glob('./file/*');
      $files = implode("<br>",$files);
      $files = preg_replace("|^./file/|","",$files);
      $files = preg_replace("|<br>./file/|","<br>",$files);
      $files = preg_replace("|__[0-9]{0,5}<br>|","<br>",$files);
      echo "～～～ファイル一覧～～～～<br>";
      echo $files;
    ?>
*/-->
  </body>
</html>
