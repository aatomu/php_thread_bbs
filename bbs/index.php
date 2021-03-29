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
