# php_thread_bbs

PHPで2ch(5ch?)っぽいのを作りました.  
開発環境:apache2,php7.3

ディレクトリ構造:  
/var/www/html/bbs/  
├log.sh(閲覧時に使います)  
├list.sh(一覧表示に使います)  
├run.sh(スレッドの消去,作成に使います)  
├index.php(ここが閲覧&一覧表示&スレッドの消去,作成 ページ)  
└thread(この下にthreadのlogがたまります)  
　├テスト.txt  
　├おすきなように.txt  
　└以下略 
# インストール&使い方  
## 1.インストール(ダウンロード)  
 * cd /web/server/path  
 * git clone https://github.com/atomu21263/php_thread_bbs.git  
## 2.インストール(設定 *念のためやります) 要検証  
 * chmod 775 ./index.php  
 * chmod 775 ./log.sh  
 * chmod 775 ./list.sh  
 * chmod 775 ./run.sh  
 * chmod 777 ./thread/  
 * chmod 777 ./thread/*
 * (任意) 任意のエディターでindex.phpの$maxlineを設定(初期は100) これの数値によって表示(保存)限界が変わります  
　※また多すぎると2回リロードしないと表示されない可能性あり  
## 3.使い方(ぺージの作成)  
 * ブラウザからweb鯖にはいりbbs/?select_page=<任意>&type=create  
## 4.使い方(実際に読み書きする)  
 * ブラウザからweb鯖にはいりbbs/?page=<任意>  
 * なにがあるかわからない場合は  
 * ブラウザからweb鯖にはいりbbs/ で一覧がでます
