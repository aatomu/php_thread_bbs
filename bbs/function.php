<?php
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

thread_command();
if (isset($_GET['page']) === true) {
  thread_log();
  } else {
  thread_list();
}
?>
