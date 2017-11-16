#!/bin/bash
ping -c 4 $1 > /dev/null 2>&1
if [ "$?" -eq 0 ]; then
  echo "PINGが成功しました。"
else
  echo "エラーが発生しました。サーバを確認できませんでした。"
  exit 1
fi
