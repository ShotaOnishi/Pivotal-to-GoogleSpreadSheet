# Pivotal to Google Spread Sheet

### This is code that get data from [Pivotal Tracker](http://pivotaltracker.com/) and write in Google Sprtead Sheet by PHP. Procedure is below.

1. [Set up Google Sheet API](https://developers.google.com/sheets/api/quickstart/php)
2. Go to your pivotal tracker my page and copy API token, and paste in `PIVOTAL TOKEN` (Picture1).
3. Set json file which is made by [1] in your directory and write file path at `Path to Json` in PHP file (Picture2).
4. install composer by ```brew install composer```
5. conduct ```composer require google/apiclient:^2.0``` in your developing directory.
6. make new google spread sheet file and add API mail address as editor.
[Reference](https://www.fillup.io/post/read-and-write-google-sheets-from-php/)
7. write spread sheet URL in `SPREAD SHEET ID` (Picture1)
8. conduct ```php pivotal_to_spreadsheet.php```

### Picture1
![token and spread sheet id](https://github.com/ShotaOnishi/Pivotal-to-GoogleSpreadSheet/blob/dev_0911/picture/place_of_token_and_id.png?raw=true "pic1")

### Picture2
![Path to Json](https://github.com/ShotaOnishi/Pivotal-to-GoogleSpreadSheet/blob/dev_0911/picture/place_of%20_json_path.png?raw=true "pic2")
