file=${1}.txt
echo "<div id='top'>Thread : $(echo $file | sed -e 's/.txt//')</div>"
echo "$(cat ./thread/$file | sed -z 's/\n/<br>/g' | sed -e 's/No.:/<\/table><br><table border="5" width="30%" bgcolor="f5f5f5"><tr  height="10"><td><div id='text_box'>No./g' -e 's/,Name:/  Name:/g' -e 's/,Date:/  Date:/g' -e 's/,Text:/<\/div><\/td><\/tr><tr><td><div id='text_box'>/g')</table>"
echo "<br><br>"
