<?php
function thread_box() {
  $input = ("\n".'    <form action="" method="post">');
  $input = ($input."\n".'      <font size="5">Name:</font><br>');
  $input = ($input."\n".'        <input type="text" name="name">');
  $input = ($input."\n".'      <br>');
  $input = ($input."\n".'      <font size="5">Text:</font><br>');
  $input = ($input."\n".'        <textarea name="message" value="" style="width: 30%; height: 100px;" ></textarea>');
  $input = ($input."\n".'      <br>');
  $input = ($input."\n".'      <input type="submit" name="send" value="送信する">');
  $input = ($input."\n".'    </form>');
  echo $input;
}

function thread_box_user() {
  global $users;
  if (isset($_SESSION['user']) == true && isset($_SESSION['pass']) == true) {
    if (isset($_POST['signout']) == true) {
      unset($_SESSION['user']);
      unset($_SESSION['pass']);
      echo '<script type="text/javascript">window.location.reload();</script>';
      exit;
    }
    $input = ("\n".'    <form action="" method="post">');
    $input = ($input."\n".'      <font size="5">Name: '.$_SESSION['user'].'</font><br>');
    $input = ($input."\n".'      <br>');
    $input = ($input."\n".'      <font size="5">Text:</font><br>');
    $input = ($input."\n".'        <textarea name="message" value="" style="width: 30%; height: 100px;" ></textarea>');
    $input = ($input."\n".'      <br>');
    $input = ($input."\n".'      <input type="submit" name="send" value="送信する">');
    $input = ($input."\n".'      <br><br>');
    $input = ($input."\n".'      <input type="submit" name="signout" value="sign out">');
    $input = ($input."\n".'    </form>');
    echo $input;
  } else {
    $input = ("\n".'    <form action="" method="post">');
    $input = ($input."\n".'      <font size="5">Name:</font><br>');
    $input = ($input."\n".'        <input type="text" name="user" value="" onkeyup="this.value=this.value.replace(/[^0-9]+/i,\'\')" onblur="this.value=this.value.replace(/[^0-9]+/i,\'\')">');
    $input = ($input."\n".'      <br>');
    $input = ($input."\n".'      <font size="5">Pass:</font><br>');
    $input = ($input."\n".'        <input type="password" name="pass" value="" onkeyup="this.value=this.value.replace(/[^0-9]+/i,\'\')" onblur="this.value=this.value.replace(/[^0-9]+/i,\'\')">');
    $input = ($input."\n".'      <br>');
    $input = ($input."\n".'      <input type="submit" name="signin" value="sign in">');
    $input = ($input."\n".'    </form>');
    echo $input;
    if (isset($_POST['signin']) == true) {
      $_SESSION['user_tmp'] = $_POST['user'];
      $_SESSION['pass_tmp'] = $_POST['pass'];
      if (shell_exec("cat ".$users." | grep -i -e '^".$_SESSION['user_tmp'].":".$_SESSION['pass_tmp']."$'") != "") {
        //sessionに保存
        $_SESSION['user'] = $_SESSION['user_tmp'];
        $_SESSION['pass'] = $_SESSION['pass_tmp'];
        echo '<script type="text/javascript">window.location.reload();</script>';
        exit;
      } else {
        echo "unknown user or password<br>";
        if (shell_exec("cat ".$users." | grep -i -e '^".$_SESSION['user_tmp'].":'") == "") {
        $input = ("\n".'    <form action="" method="post">');
        $input = ($input."\n".'      <input type="submit" name="signup" value="sign up it data">');
        $input = ($input."\n".'    </form>');
        echo $input;
      }
      }
    }
  }
  if (isset($_POST['signup']) == true) {
    if (shell_exec("cat ".$users." | grep -i -e \"^".$_SESSION['user_tmp'].":\"") == "" && $_SESSION['user_tmp'] != "") {
      $write = ($_SESSION['user_tmp'].":".$_SESSION['pass_tmp']."\n");
      file_put_contents($users,$write,FILE_APPEND | LOCK_EX);
      //sessionに保存
      $_SESSION['user'] = $_SESSION['user_tmp'];
      $_SESSION['pass'] = $_SESSION['pass_tmp'];
      echo '<script type="text/javascript">window.location.reload();</script>';
      exit;
    }
  }
}

function thread_write() {
  global $maxline;
  if (isset($_GET['page']) === true) {
    $page = $_GET['page'];
    if ($page != "") {
      //行数の入手&整形
      $line = shell_exec('wc -l ./thread/'.$page.".txt | sed \"s|./thread/${page}.txt||\"");
      $line_text = $line + 1;
      if (isset($_POST['send']) === true) {
        //表示限界チェック
        if ($line >= $maxline) {
          echo "<div id='text_box'>メッセージが".$maxline."を超えました\n新しく立ててください</div>";
          exit;
        }
        //メッセージのいろいろ
        if (isset($_POST['name']) == true) {
          $name = $_POST["name"];
        } else if (isset($_SESSION['user']) == true) {
          $name = $_SESSION['user'];
        }
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
        $url = ((empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
        header("Location: ".$url);
        exit;
      }
    }
  }
}

function thread_command() {
  if (isset($_GET['newpage']) === true && isset($_GET['type']) === true) {
    //変数取得
    $newpage = $_GET['newpage'];
    $type = $_GET['type'];
    //処理するために変形
    $newpage = ("./thread/".$newpage.".txt");
    //page生成
    if ($type == "create") {
      touch($newpage);
      chmod($newpage,0677);
    } else if ($type == "delete") {
      unlink($newpage);
    }
  }
}

function thread_log() {
  //ファイル名入手
  $file= $_GET['page'];
  //スレッド名表示
  echo ("<div id='top'>Thread : ".$file."</div>");
  //メッセージを入手
  $message= file_get_contents("./thread/".$file.".txt");
  //メッセージ変換 \r\n \r \n >> <br>
  $message = str_replace(array("\r\n","\r","\n"), '<br>', $message);
  //メッセージ変換 No Name Date Text >> table
  $message = str_replace("No.","</table><br><table border='5' width=30% bgcolor='f5f5f5'><tr height='10'><td><div id='text_box'>No.",$message);
  $message = str_replace(",Name:","&ensp;&ensp;Name:",$message);
  $message = str_replace(",Date:","&ensp;&ensp;Date:",$message);
  $message = str_replace(",Text:","</div></td></tr><tr><td><div id='text_box'>",$message);
  $message = ($message."</table>");
  //メッセージ表示
  echo ($message);
  //見た目用改行
  echo "<br><br>";
}

function thread_list() {
  //TOP表示
  echo "<div id='top'>スレッド一覧</div><br><br>";
  //URL入手
  $url = ((empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
  //URL必要なとこ以外削除
  $url = preg_replace("|\?.*|","",$url);
  //file一覧入手
  $file = glob('./thread/*.txt');
  //Arrayを変換
  $file = implode("",$file);
  //邪魔なのを削除
  $file = str_replace("./thread/","",$file);
  //thread一覧表示
  do {
    //最初の一つをにゅしゅ
    $source = preg_replace("|\.txt.*|",'',$file);
    //表示
    echo ("<br><div id='text_box'><a href=".$url."?page=".$source.">Thread : ".$source."</a></div>");
    //削除
    $file = str_replace($source.".txt","",$file);
  } while ($file != "");
}

function file() {
  global $save_path;
      //アップロードのためにecho
      echo "<br><br>";
      echo "\n    <form method=\"post\" enctype=\"multipart/form-data\">";
      echo "\n      <font size=5>File:</font>";
      echo "\n      <input type=\"file\" name=\"up_file\">";
      echo "\n      <font size=5>Pass:</font>";
      echo "\n      <input type=\"text\" name=\"up_pass\"<br>";
      echo "\n      <input type=\"submit\" name=\"up_send\" value=\"アップロード\">";
      echo "\n    </form>";
      echo "\n    <br><br>";
      //postをcheck
      if (isset($_POST['up_send']) === true ) {
        //passとファイルのチェック
        if (isset($_FILES['up_file']) === true) {
          //ファイルサイズを保存
          $file_size = $_FILES["up_file"]["size"];
          //日付を保存
          $date = date("Y.m.d,H_i_s");
          //ファイル名(pass無し)を保存
          $file_name = ($date.",".$_FILES["up_file"]["name"]);
          //名前から特殊文字を消す
          if ( preg_match("|__|",$file_name) != "" ) {
            $file_name = preg_replace("|__|",".",$file_name);
            echo ("change file name to ".$file_name."<br>");
          }
          //一時ファイルとpassを入手
          $file_tmp = $_FILES["up_file"]["tmp_name"];
          $file_pass = $_POST['up_pass'];
          //メッセージを表示
          echo ("upload to server : ".$file_name." , Size : ".$file_size."byte password : ".$file_pass."<br>");
          //アップロードに成功するか確認
          if (is_uploaded_file($file_tmp)) {
            //一時ファイルから通常ファイルに変更
            if ( move_uploaded_file($file_tmp , $save_path.$file_name."__".$file_pass)) {
              //終了メッセージ
              echo $file_name . "をアップロードしました。<br><br><br>";
            } else {
              //失敗メッセージ
              echo "ファイルをアップロードできません。";
            }
            $url = ((empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);
            header("Location: ".$url);
            exit;
          }
        } else {
          //passとファイル どっちかがおかしいときに
          echo "ファイルが設定されていません<br><br>";
        }
      }
      //ファイルの一覧表示
      $files=shell_exec("ls -1 ".$save_path.' | sed -e "s|__.*$||g"');
      //ファイルをradio型のhtmlに変換
      while($files != "") {
        $file_name=preg_replace("|\n.*|u","",$files);
        $file_list=($file_list."\n".'      <br><input type="radio" name="down_file" value="'.$file_name.'">'.$file_name);
        $files=str_replace($file_name."\n","",$files);
      }
      //一覧表示
      echo "\n    ～～～ファイル一覧～～～～<br>";
      echo "\n    <form method=\"post\">";
      echo "\n      <font size=5>File:</font>";
      echo "\n       ".$file_list."<br>";
      echo "\n      <font size=5>DownloadPass:</font>";
      echo "\n      <input type=\"text\" name=\"down_pass\"><br>";
      echo "\n      <input type=\"submit\" name=\"down_send\" value=\"ダウンロード\">";
      echo "\n    </form>";
      //postチェック
      if (isset($_POST['down_send']) === true && isset($_POST['down_file']) === true ) {
        //ファイル名保存
        $file_name = shell_exec("ls -1 ".$save_path."| grep \"".$_POST['down_file']."\"");
        //ファイル名からpassを入手
        $file_pass = preg_replace("|.*__|","",$file_name);
        $file_pass = preg_replace("|\n|","",$file_pass);
        //入力
        $pass_word = preg_replace("|\n|","",$_POST['down_pass']);
        //postからpassを確認
        if ($_POST['down_pass'] === $file_pass ) {
          // ファイルのパス
          $filepath = ($save_path.$_POST['down_file']."__".$file_pass);
          // ファイルタイプを指定
          header('Content-Type: application/force-download');
          // ファイルサイズを取得し、ダウンロードの進捗を表示
          header('Content-Length: '.filesize($filepath));
          // ファイルのダウンロード、リネームを指示
          header('Content-Disposition: attachment; filename="'.$_POST['down_file'].'"');
          // ファイルを読み込みダウンロードを実行
          readfile($filepath);
        } else {
          //パスワードチェック
          echo "ダウンロードパスワードが間違っています<br><br>";
        }
      } else {
        //失敗時に表示
        echo "ダウンロードに失敗しました";
      }
}
?>
