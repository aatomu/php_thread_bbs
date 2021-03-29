page_name=${1}
run_type=${2}
if [ ${page_name} != "" ]
  then
   cd ./thread/
   case "${run_type}" in
   create) touch ${page_name}.txt ;;
   delete) rm ${page_name}.txt ;;
   esac
fi