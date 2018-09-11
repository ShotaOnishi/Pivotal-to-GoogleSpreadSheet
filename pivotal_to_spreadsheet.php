<?php
require_once __DIR__ . '/vendor/autoload.php';

$token = 'PIVOTAL TOKEN';
$base_url = 'https://www.pivotaltracker.com';
$spreadsheetId = 'SPREAD SHEET ID';
$header = [
  'X-TrackerToken:'.$token,
  'Content-Type: application/json'
];

//Projects
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $base_url.'/services/v5/projects');
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl);
$result = json_decode($response, true);
$json = json_encode($result);

$ids = array_column($result, "id");
$name_array = array_column($result, "name", "id");

//Member List
$curl_member = curl_init();
//メンバー名がIDになっているので、名前で表示できるようにする
curl_setopt($curl_member, CURLOPT_URL, $base_url.'/services/v5/projects/'.'Your Project ID'.'/memberships');
curl_setopt($curl_member, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($curl_member, CURLOPT_HTTPHEADER, $header);
curl_setopt($curl_member, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl_member, CURLOPT_RETURNTRANSFER, true);

$response_member = curl_exec($curl_member);
$result_member = json_decode($response_member, true);
$json_member = json_encode($result_member);
$member_list = array();
foreach($result_member as $value){
  array_push($member_list,$value['person']);
}
$member_list = array_merge($member_list);

//Stories
$result_all=array();
$key_list = array();
$isFirst = true;
foreach($ids as $id){
  $curl2 = curl_init();
  curl_setopt($curl2, CURLOPT_URL, $base_url.'/services/v5/projects/'.$id.'/stories?with_state=accepted&limit=2000');
  curl_setopt($curl2, CURLOPT_CUSTOMREQUEST, 'GET');
  curl_setopt($curl2, CURLOPT_HTTPHEADER, $header);
  curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);

  $response2 = curl_exec($curl2);
  $result2 = json_decode($response2, true);
  $json2 = json_encode($result2);

  foreach($result2 as $value){
    //The case of lack value
    if(!(array_key_exists("accepted_at", $value)))
      $value = array_merge($value, array('accepted_at'=>999));
    if(!(array_key_exists("created_at", $value)))
      $value = array_merge($value, array('created_at'=>999));
    if(!(array_key_exists("current_state", $value)))
      $value = array_merge($value, array('current_state'=>999));
    if(!(array_key_exists("description", $value)))
      $value = array_merge($value, array('description'=>999));
    if(!(array_key_exists("estimate", $value)))
      $value = array_merge($value, array('estimate'=>999));
    if(!(array_key_exists("id", $value)))
      $value = array_merge($value, array('id'=>999));
    if(!(array_key_exists("kind", $value)))
      $value = array_merge($value, array('kind'=>999));
    if(!(array_key_exists("name", $value)))
      $value = array_merge($value, array('name'=>999));
    if(!(array_key_exists("owned_by_id", $value)))
      $value = array_merge($value, array('owned_by_id'=>999));
    if(!(array_key_exists("owner_ids", $value)))
      $value = array_merge($value, array('owner_ids'=>999));
    if(!(array_key_exists("project_name", $value)))
      $value = array_merge($value, array('project_name'=>999));
    if(!(array_key_exists("requested_by_id", $value)))
      $value = array_merge($value, array('requested_by_id'=>999));
    if(!(array_key_exists("updated_at", $value)))
      $value = array_merge($value, array('updated_at'=>999));
    if(!(array_key_exists("url", $value)))
      $value = array_merge($value, array('url'=>999));

    //Array to String
    $owner_ids = json_encode($value['owner_ids']);
    $value = array_merge($value, array('owner_ids'=>$owner_ids));
    $labels = json_encode($value['labels']);
    $value = array_merge($value, array('labels'=>$labels));

    $value = array_merge($value, array('project_name'=>$name_array[$id]));

    foreach ($member_list as $key => $val) {
      if($val['id'] == $value['owned_by_id']){
        $value = array_merge($value, array('owned_member'=>$val['name']));
        break;
      }
    }
    if(!(array_key_exists("owned_member", $value))){
      $value = array_merge($value, array('owned_member'=>999));
    }

    ksort($value);

    if($isFirst){
      $key_list=array_keys($value);
      $isFirst = false;
    }
    array_push($result_all,$value);
  }

}
curl_close($result);

//Update Google Spread Sheet
define('APPLICATION_NAME', 'Google Sheets API PHP Quickstart');
define('CREDENTIALS_PATH', '~/.credentials/sheets.googleapis.com-php-quickstart.json');
define('CLIENT_SECRET_PATH', __DIR__ . 'Path to Json');
define('SCOPES', implode(' ', array(
  Google_Service_Sheets::SPREADSHEETS)
));

if (php_sapi_name() != 'cli') {
  throw new Exception('This application must be run on the command line.');
}

/**
 * Returns an authorized API client.
 * @return Google_Client the authorized client object
 */
function getClient() {
  $client = new Google_Client();
  $client->setApplicationName(APPLICATION_NAME);
  $client->setScopes(SCOPES);
  $client->setAuthConfig(CLIENT_SECRET_PATH);
  $client->setAccessType('offline');

  // Load previously authorized credentials from a file.
  $credentialsPath = expandHomeDirectory(CREDENTIALS_PATH);
  if (file_exists($credentialsPath)) {
    $accessToken = json_decode(file_get_contents($credentialsPath), true);
  } else {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, json_encode($accessToken));
    printf("Credentials saved to %s\n", $credentialsPath);
  }
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, json_encode($client->getAccessToken()));
  }
  return $client;
}

/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */
function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv('HOMEDRIVE') . getenv('HOMEPATH');
  }
  return str_replace('~', realpath($homeDirectory), $path);
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Sheets($client);
//labelカラムがいらないので削除
$key_list = array_diff($key_list, array('labels'));
$key_list = array_values($key_list);
$column_title=array();
array_push($column_title, $key_list);
//スプレットシートに合うようにデータの形を整形 & いらないデータを削除
foreach($result_all as $result_key => $result_value) {
  unset($result_value['labels']);
  $result_all[$result_key] = array_values($result_value);
}

//Update Data label
$data = [];
$range= 'A1:Z';
$data[] = new Google_Service_Sheets_ValueRange([
  'range' => $range,
  'values' =>  $column_title
]);
// Additional ranges to update ...
$body = new Google_Service_Sheets_BatchUpdateValuesRequest([
  'valueInputOption' => 'RAW',
  'data' => $data
]);
$result = $service->spreadsheets_values->batchUpdate($spreadsheetId, $body);

//Update Data
$data = [];
$range= 'A2:Z';
$data[] = new Google_Service_Sheets_ValueRange([
  'range' => $range,
  'values' => $result_all
]);
// Additional ranges to update ...
$body = new Google_Service_Sheets_BatchUpdateValuesRequest([
  'valueInputOption' => 'RAW',
  'data' => $data
]);

$result = $service->spreadsheets_values->batchUpdate($spreadsheetId, $body);
printf("%d cells updated.", $result->getTotalUpdatedCells());

?>
