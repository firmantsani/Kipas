<?php
//require "iden.php";
function generate_uuid_v4() {
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}
function generateRandomBirthDate($startDate = '1950-01-01', $endDate = '2000-12-31') {
    $startTimestamp = strtotime($startDate);
    $endTimestamp = strtotime($endDate);
    $randomTimestamp = rand($startTimestamp, $endTimestamp);
    return date('Y-m-d', $randomTimestamp);
}
function nama() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ninjaname.horseridersupply.com/indonesian_name.php");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $ex = curl_exec($ch);
    preg_match_all('~(&bull; (.*?)<br/>&bull; )~', $ex, $name);
    $fullName = $name[2][mt_rand(0, 14)];
    $nameParts = explode(' ', $fullName);
    
    if (count($nameParts) > 2) {
        $firstName = $nameParts[0];
        $lastName = $nameParts[1];
    } else {
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';
    }
    
    return [$firstName, $lastName];
}
function generateRandomString($length = 16) {
    return bin2hex(random_bytes($length / 2));
}
function generateRandomDeviceId($length = 16) {
    $characters = '0123456789abcdef';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function generateRandomBirthDates($startDate = '1950-01-01', $endDate = '2000-12-31') {
    $startTimestamp = strtotime($startDate);
    $endTimestamp = strtotime($endDate);
    $randomTimestamp = rand($startTimestamp, $endTimestamp);
    return date('Y-m-d', $randomTimestamp);
}
$birtdate = generateRandomBirthDate();
$deviceId = generateRandomDeviceId();
$userNotifId = uniqid();
$email = readline("Masukkan email: ");
//$otpCode = readline("Masukkan Kode OTP: ");
//$deviceId = generateRandomString();

//cek email
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api-main.kipaskipas.com/api/v1/auth/registers/accounts/exists-by?email=' . urlencode($email),
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'deviceId: ' . $deviceId,
    'Authorization: Bearer null',
    'x-kk-buildversion: ANDROID-2.0.6',
    'model: Redmi-M2101K6G',
    'sentry-trace: 11f2f1e80de74606b5345babf538bbd7-0615009feda343f0',
    'baggage: sentry-environment=prd,sentry-public_key=9ac581eafc4947ffb55167d21888c7c7,sentry-release=com.koanba.kipaskipas%402.0.6%2B335,sentry-trace_id=11f2f1e80de74606b5345babf538bbd7',
    'Host: api-main.kipaskipas.com',
    'Connection: Keep-Alive',
    'User-Agent: okhttp/4.12.0'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response."\n";

// send otp
$curl = curl_init();

$data = array(
  'deviceId' => $deviceId,
  'email' => $email,
  'platform' => 'EMAIL',
  'type' => 'REGISTER'
);

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api-main.kipaskipas.com/api/v1/auth/otp/email',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode($data),
  CURLOPT_HTTPHEADER => array(
    'No-Authentication: true',
    'deviceId: ' . $deviceId,
    'Authorization: Bearer null',
    'x-kk-buildversion: ANDROID-2.0.6',
    'model: Redmi-M2101K6G',
    'sentry-trace: 11f2f1e80de74606b5345babf538bbd7-0615009feda343f0',
    'baggage: sentry-environment=prd,sentry-public_key=9ac581eafc4947ffb55167d21888c7c7,sentry-release=com.koanba.kipaskipas%402.0.6%2B335,sentry-trace_id=11f2f1e80de74606b5345babf538bbd7',
    'Content-Type: application/json; charset=UTF-8',
    'Content-Length: ' . strlen(json_encode($data)),
    'Host: api-main.kipaskipas.com',
    'Connection: Keep-Alive',
    'User-Agent: okhttp/4.12.0'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response."\n";
$otpCode = readline("Masukkan Kode OTP: ");
// verif otp
$curl = curl_init();

$data = array(
  'code' => $otpCode,
  'deviceId' => $deviceId,
  'email' => $email,
  'platform' => 'EMAIL',
  'type' => 'REGISTER'
);

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api-main.kipaskipas.com/api/v1/auth/otp/verification/email',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode($data),
  CURLOPT_HTTPHEADER => array(
    'No-Authentication: true',
    'deviceId: ' . $deviceId,
    'Authorization: Bearer null',
    'x-kk-buildversion: ANDROID-2.0.6',
    'model: Redmi-M2101K6G',
    'sentry-trace: 1e541ce88e4f418da36975ddc4d5c759-399fe9f1be564b3e',
    'baggage: sentry-environment=prd,sentry-public_key=9ac581eafc4947ffb55167d21888c7c7,sentry-release=com.koanba.kipaskipas%402.0.6%2B335,sentry-trace_id=1e541ce88e4f418da36975ddc4d5c759',
    'Content-Type: application/json; charset=UTF-8',
    'Content-Length: ' . strlen(json_encode($data)),
    'Host: api-main.kipaskipas.com',
    'Connection: Keep-Alive',
    'User-Agent: okhttp/4.12.0'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response."\n";

// kirim data dtatustik
$curl = curl_init();

$data = array(
  'app_id' => '0721e737-a447-466c-b987-c84f7fdc3d4b'
);

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.onesignal.com/players/c851c94f-a31c-4e08-864d-8f829aecf617/on_session',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode($data),
  CURLOPT_HTTPHEADER => array(
    'SDK-Version: onesignal/android/040807',
    'Accept: application/vnd.onesignal.v1+json',
    'Content-Type: application/json; charset=UTF-8',
    'Content-Length: ' . strlen(json_encode($data)),
    'User-Agent: Dalvik/2.1.0 (Linux; U; Android 14; M2101K6G Build/UKQ1.230917.001)',
    'Host: api.onesignal.com',
    'Connection: Keep-Alive'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response."\n";
echo "Masukkan Kode Referral (kosongkan jika tidak ada): ";
$referralCode = trim(fgets(STDIN));
if (empty($referralCode)) {
    $referralCode = "d4tz9qhz";
}
echo "kode reff : $referralCode\n";
$curl = curl_init();

$data = array(
  'birthDate' => $birtdate,
  'deviceId' => $deviceId,
  'email' => $email,
  'otpCode' => $otpCode,
  'password' => '@Cuan2024',
  'referralCode' => $referralCode,
  'userNotifId' => $userNotifId
);

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api-main.kipaskipas.com/api/v1/auth/registers',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => json_encode($data),
  CURLOPT_HTTPHEADER => array(
    'No-Authentication: true',
    'deviceId: ' . $deviceId,
    'Authorization: Bearer null',
    'x-kk-buildversion: ANDROID-2.0.6',
    'model: Redmi-M2101K6G',
    'sentry-trace: fb5f16b3a93b4f40b7faac27b8d66f1e-6f3acf46587648a0',
    'baggage: sentry-environment=prd,sentry-public_key=9ac581eafc4947ffb55167d21888c7c7,sentry-release=com.koanba.kipaskipas%402.0.6%2B335,sentry-trace_id=fb5f16b3a93b4f40b7faac27b8d66f1e',
    'Content-Type: application/json; charset=UTF-8',
    'Content-Length: ' . strlen(json_encode($data)),
    'Host: api-main.kipaskipas.com',
    'Connection: Keep-Alive',
    'User-Agent: okhttp/4.12.0'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response."\n";
$responseData = json_decode($response, true);
$message3 = $responseData['message'] ?? 'Tidak ada pesan';
$accessToken = $responseData['access_token'] ?? 'Tidak ada access token';
$refreshToken = $responseData['refresh_token'] ?? 'Tidak ada refresh token';
$accountId = $responseData['accountId'] ?? 'Tidak ada accountId';
$userName = $responseData['userName'] ?? 'Tidak ada userName';

list($firstName, $lastName) = nama();

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api-main.kipasapi.com/api/v1/profile/293343");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Host:api-main.kipasapi.com",
    "deviceId:$deviceId",
    "Authorization:Bearer $accessToken",
    "x-kk-buildversion:ANDROID-2.0.6",
    "model:Redmi-M2101K6G",
    "sentry-trace:2e60d2eb7d0d46f8a49c69ce97641e5e-92e9dc1263d14933",
    "baggage:sentry-environment=prd,sentry-public_key=9ac581eafc4947ffb55167d21888c7c7,sentry-release=com.koanba.kipaskipas@2.0.6+335,sentry-trace_id=2e60d2eb7d0d46f8a49c69ce97641e5e",
    "content-type:application/json; charset=UTF-8",
    "user-agent:okhttp/4.12.0"
]);

$data = json_encode([
    "bio" => $firstName." ".$lastName,
    "birthDate" => $birtdate,
    "gender" => "MALE",
    "name" => $firstName." ".$lastName,
    "photo" => "https://koanba-storage-prod.oss-cn-hongkong.aliyuncs.com/img/media/noGender.png",
    "socialMedias" => [
        [
            "socialMediaType" => "INSTAGRAM",
            "urlSocialMedia" => "https://instagram.com/".$firstName.$lastName.rand(11111,99999)
        ],
        [
            "socialMediaType" => "TIKTOK",
            "urlSocialMedia" => "https://tiktok.com/".$firstName.$lastName.rand(11111,99999)
        ],
        [
            "socialMediaType" => "WIKIPEDIA",
            "urlSocialMedia" => "https://id.wikipedia.org/wiki/".$firstName.$lastName.rand(11111,99999)
        ],
        [
            "socialMediaType" => "FACEBOOK",
            "urlSocialMedia" => "https://www.facebook.com/".$firstName.$lastName.rand(11111,99999)
        ],
        [
            "socialMediaType" => "TWITTER",
            "urlSocialMedia" => "https://twitter.com/".$firstName.$lastName.rand(11111,99999)
        ]
    ]
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

$response = curl_exec($ch);
curl_close($ch);

$url = "https://api-main.kipaskipas.com/api/v1/profile/".$accountId;

$headers = [
    "Host: api-main.kipaskipas.com",
    "deviceId: $deviceId",
    "Authorization: Bearer $accessToken",
    "x-kk-buildversion: ANDROID-2.0.6",
    "model: Redmi-M2101K6G",
    "sentry-trace: 08f96aa87ce841edbd1b6a2f46f8baf0-80f987cf248b4668",
    "baggage: sentry-environment=prd,sentry-public_key=9ac581eafc4947ffb55167d21888c7c7,sentry-release=com.koanba.kipaskipas@2.0.6+335,sentry-trace_id=08f96aa87ce841edbd1b6a2f46f8baf0",
    "user-agent: okhttp/4.12.0"
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
$data = json_decode($response, true);
if (isset($data['data'])) {
    $userData = $data['data'];
    $id = $userData['id'] ?? 'kosong';
    $username = $userData['username'] ?? 'kosong';
    $name = $userData['name'] ?? 'kosong';
    $referralCode = $userData['referralCode'] ?? 'kosong';
    echo "ID: $id\n";
    echo "Username: $username\n";
    echo "Name: $name\n";
    echo "Referer BY : $referralCode\n";
} else {
    echo "Data tidak ditemukan dalam respons.\n";
}
}

curl_close($ch);

///////googlefirebase
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://firebaseremoteconfig.googleapis.com/v1/projects/59800204241/namespaces/firebase:fetch');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);

$headers = [
    'If-None-Match: etag-59800204241-firebase-fetch--783684886',
    'X-Goog-Api-Key: AIzaSyAeyBjkRPG0HODB9wgXKMjuUfrCD4fQU4Y',
    'X-Android-Package: com.koanba.kipaskipas',
    'X-Android-Cert: A317B04BD72446A5EA92659E6D559EB4897FE5B7',
    'X-Google-GFE-Can-Retry: yes',
    'X-Goog-Firebase-Installations-Auth: eyJhbGciOiJFUzI1NiIsInR5cCI6IkpXVCJ9.eyJhcHBJZCI6IjE6NTk4MDAyMDQyNDE6YW5kcm9pZDpjOGU3ZjRjOGRhZmJmOWVhMDlhNmYwIiwiZXhwIjoxNzM0MTYzNTg5LCJmaWQiOiJkQTd6alQzYlIwU0c4TFJqX1pteER6IiwicHJvamVjdE51bWJlciI6NTk4MDAyMDQyNDF9.AB2LPV8wRQIgcsLbFNJlL3EVYucy5oN7_YML0nQJy3Cz65P4IhCkULICIQCKhI6ezPcmUGzNLWTTE8cCEDkWJ-D_P-fbH11360ILUA',
    'Content-Type: application/json',
    'Accept: application/json',
    'X-Firebase-RC-Fetch-Type: BASE/1',
    'User-Agent: Dalvik/2.1.0 (Linux; U; Android 14; M2101K6G Build/UKQ1.230917.001)',
    'Host: firebaseremoteconfig.googleapis.com',
    'Connection: Keep-Alive'
];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$data = [
    'appVersion' => '2.0.6',
    'firstOpenTime' => date('Y-m-d\TH:i:s.v\Z'),
    'timeZone' => 'Asia/Jakarta',
    'appInstanceIdToken' => 'eyJhbGciOiJFUzI1NiIsInR5cCI6IkpXVCJ9.eyJhcHBJZCI6IjE6NTk4MDAyMDQyNDE6YW5kcm9pZDpjOGU3ZjRjOGRhZmJmOWVhMDlhNmYwIiwiZXhwIjoxNzM0MTYzNTg5LCJmaWQiOiJkQTd6alQzYlIwU0c4TFJqX1pteER6IiwicHJvamVjdE51bWJlciI6NTk4MDAyMDQyNDF9.AB2LPV8wRQIgcsLbFNJlL3EVYucy5oN7_YML0nQJy3Cz65P4IhCkULICIQCKhI6ezPcmUGzNLWTTE8cCEDkWJ-D_P-fbH11360ILUA',
    'languageCode' => 'id-ID',
    'appBuild' => '335',
    'appInstanceId' => 'dA7zjT3bR0SG8LRj_ZmxDz',
    'countryCode' => 'ID',
    'analyticsUserProperties' => (object)[],
    'appId' => '1:59800204241:android:c8e7f4c8dafbf9ea09a6f0',
    'platformVersion' => '34',
    'sdkVersion' => '21.6.0',
    'packageName' => 'com.koanba.kipaskipas'
];
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

echo $response."\n";
//generate links reff
$ch = curl_init();

$data = [
    "data" => [
        "af_dp" => "kipasapp%3A%2F%2Fweb.kipaskipas.com%2Fprofile",
        "af_referrer_customer_id" => $accountId,
        "af_referrer_uid" => "1733558788130-1034638454216073913",
        "pid" => "af_app_invites",
        "af_channel" => "mobile_share",
        "deep_link_sub1" => "profile",
        "deep_link_sub2" => "qr",
        "af_siteid" => "com.koanba.kipaskipas",
        "deep_link_value" => $accountId
    ],
    "meta" => [
        "build_number" => "6.15.1",
        "model" => "M2101K6G",
        "counter" => 4,
        "sdk" => "34",
        "app_version_name" => "2.0.6",
        "brand" => "Redmi",
        "app_id" => "com.koanba.kipaskipas",
        "platformextension" => "android_native"
    ],
    "ttl" => "-1",
    "uuid" => generate_uuid_v4()
];

$data_json = json_encode($data);
$content_length = strlen($data_json);

curl_setopt($ch, CURLOPT_URL, "https://bzttid-onelink.appsflyersdk.com/shortlink-sdk/v2/4CGW");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Af-Signature: 86ddc20e2eabfd5af5cba6129c0f338c394fac96b02cbba3f141813971b1bfe8",
    "Content-Length: $content_length",
    "User-Agent: Dalvik/2.1.0 (Linux; U; Android 14; M2101K6G Build/UKQ1.230917.001)",
    "Host: bzttid-onelink.appsflyersdk.com",
    "Connection: Keep-Alive"
]);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);

curl_close($ch);

echo $server_output;
$fileContent = "accountId: $accountId\nUser Name: $userName\nReferer By: $referralCode\nLink reff: $server_output";
file_put_contents($accountId.'.txt', $fileContent);

?>
