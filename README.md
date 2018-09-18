# Pivotal to Google Spread Sheet

### This is code that get data from [Pivotal Tracker](http://pivotaltracker.com/) and write in Google Sprtead Sheet by PHP. Procedure is below.

1. [Set up Google Sheet API (1)](https://developers.google.com/sheets/api/quickstart/php)
2. install composer by ```brew install composer```
3. conduct ```composer require google/apiclient:^2.0``` in your working directory.
4. [Set up Google Sheets API (2)](http://www.sharkpp.net/blog/2016/09/22/how-to-use-google-spreadsheets-api-for-php.html)  
  (1) Make project  
  (2) Enable google sheets API  
  (3) Make new credential  
     - Credentials type → `service account key`  
     - Service account → `new service account`  
     - Service account name → You can decide  
     - Role → `app engine service admin`  
     - key type → `Json`  
5. Set json file which is created by [4] in your directory and write file path at `Path to Json` in PHP file (Picture2).
6. Go to your pivotal tracker my page and copy API token, and paste in `PIVOTAL TOKEN` (Picture1).
7. make new google spread sheet file and add API mail address as editor.
[Reference](https://www.fillup.io/post/read-and-write-google-sheets-from-php/)
8. write last last of the spread sheet URL in `SPREAD SHEET ID` (Picture1)
9. conduct ```php pivotal_to_spreadsheet.php```

### Picture1
![token and spread sheet id](https://github.com/ShotaOnishi/Pivotal-to-GoogleSpreadSheet/blob/dev_0911/picture/place_of_token_and_id.png?raw=true "pic1")

### Picture2
![Path to Json](https://github.com/ShotaOnishi/Pivotal-to-GoogleSpreadSheet/blob/dev_0911/picture/place_of%20_json_path.png?raw=true "pic2")
