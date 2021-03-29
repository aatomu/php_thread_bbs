url=${1}
url=$(echo ${url} | sed -e "s|/|\/|" -e "s|/?.*|/|")
echo "<div id='top'>スレッド一覧</div><br><br>"
echo "<div id='text_box'>$(ls ./thread/*.txt | sed -e "s|^\./thread/|${url}?page=|" -e "s|.txt|<br>|")</div>"