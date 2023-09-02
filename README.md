# php_thread_bbs

PHPで2ch(5ch?)っぽいのを作りました.  
開発環境:apache2,php7.3

ディレクトリ構造:  
/var/www/html/bbs/  
├function.sh(閲覧 作成,消去 一覧表示 のプログラム)  
├index.php(ここが閲覧&一覧表示&スレッドの消去,作成 ページ)
├user.txt(ここにデータが保存されます)
└thread(この下にthreadのlogがたまります)  
　├test.txt  
　├おすきなように.txt  
　└以下略 
# インストール&使い方  
## 1.インストール(ダウンロード)  
 * cd /web/server/path  
 * git clone https://github.com/aatomu/php_thread_bbs.git  
## 2.インストール(設定 *念のためやります) 要検証  
 * chmod 775 ./index.php  
 * chmod 775 ./function.php  
 * chmod 777 ./thread/  
 * chmod 776 ./thread/*
 * (任意) 任意のエディターでindex.phpの$maxlineを設定(初期は500) これの数値によって保存限界(≒表示限界)が変わります
　※また多すぎると2回リロードしないと表示されない可能性あり  
 * (任意) 任意のエディターでindex.phpの$user_lockを設定(初期はfalse) これによってsignupが必要かが変わります
  > 楽をする用: git clone https://github.com/aatomu/php_thread_bbs.git ; cd ./php_thread_bbs/bbs/ ; chmod 775 ./* ; chmod 777 ./thread ;chmod 776 ./thread/*  
## 3.使い方(ぺージの作成)  
 * ブラウザからweb鯖にはいりbbs/?select_page=<任意>&type=create  
## 4.使い方(実際に読み書きする)  
 * ブラウザからweb鯖にはいりbbs/?page=<任意>  
 * なにがあるかわからない場合は  
 * ブラウザからweb鯖にはいりbbs/ で一覧がでます
