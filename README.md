### Pivotal to Google Spread Sheet
タスク管理ツールである[Pivotal Tracker](http://pivotaltracker.com/)のデータをGoogle Sprtead Sheetに書き出すコードです。意外と文献が少なかったので下記に手順を書いてまとめてみました。

1. [Set up Google Sheet API](https://developers.google.com/sheets/api/quickstart/php)
2. Go to your pivotal tracker my page and copy API token, and paste in 'PIVOTAL TOKEN'.
3. Set json file which is made by [1] in your dictionary and write file path in 'Path to Json'
4. install composer by ```brew install composer```
5. conduct ```composer require google/apiclient:^2.0``` in your developing directory.
6. make new google spread sheet file and add API mail address as editor.
[Reference](https://www.fillup.io/post/read-and-write-google-sheets-from-php/)
7. write spread sheet URL in 'SPREAD SHEET ID'
8. conduct ```pivotal_to_spreadsheet.php```
