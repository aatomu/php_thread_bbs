url=${1}
url=$(echo ${url} | sed -e "s|/|\/|" -e "s|/?.*|/|")
file=$(ls ./thread/*.txt)
echo "<div id='top'>スレッド一覧</div><br><br>"
while :
do
  source=$(echo "${file}" | head -n 1 | sed -e "s|^\./thread/||" -e "s|.txt$||")
  href=$(echo "${source}" | sed -e "s|^|<a href=${url}?page=|" -e "s|$|>Thread : ${source}</a>|")
  link="<br><div id='text_box'>${href}</div>"
  echo "${link}"
  file=$(echo -e "${file}" | sed '1d')
  if [ "${file}" = "" ]
   then
    echo "<br>"
    exit
  fi
done
