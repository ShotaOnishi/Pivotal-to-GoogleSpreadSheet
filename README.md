# Pivotal evaluation

### This is code that get data from [Pivotal Tracker](http://pivotaltracker.com/) and write in Google Sprtead Sheet by PHP. Procedure is below.
1. clone this directory to your local environment
2. [Set up Google Sheet API (1)](https://developers.google.com/sheets/api/quickstart/php)
  (1) Set Sheets API Enable
  (2) Download `credentials.json` and put in the working directory
3. install composer by ```brew install composer```
4. conduct ```composer require google/apiclient:^2.0``` in your working directory.
5. Go to your pivotal tracker my page and copy API token, and paste in `PIVOTAL TOKEN` (Picture2).
6. make new google spread sheet file and add API mail address as editor.
[Reference](https://www.fillup.io/post/read-and-write-google-sheets-from-php/)
7. write last last of the spread sheet URL in `SPREAD SHEET ID` (Picture2)
8. conduct ```php pivotal_to_spreadsheet.php```

### Picture1
![token and spread sheet id](https://github.com/ShotaOnishi/Pivotal-to-GoogleSpreadSheet/blob/dev_0911/picture/place_of_token_and_id.png?raw=true "pic2")
