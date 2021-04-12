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
            unknown
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
      $users = "./user.txt";
      $user_lock = false;
      session_start();
      require('./function.php');
      thread_write();
      thread_command();
      if (isset($_GET['page']) === true) {
        thread_log();
      } else {
        thread_list();
      }
      echo '    <hr size=5 color="gray">';
      if ($user_lock === false) {
        thread_box();
      } else {
        thread_box_user();
      }
/*      $save_path = "./file/";
      file_box();
      file_upload();
      file_download();
      file_view();
    ?>*/
  </body>
</html>
