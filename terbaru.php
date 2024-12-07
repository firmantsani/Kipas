<?php
function generateRandomDeviceId($length = 16) {
    $characters = '0123456789abcdef';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$deviceId = generateRandomDeviceId();

echo "Masukkan nomor telepon: ";
$phoneNumber = trim(fgets(STDIN));

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api-main.kipaskipas.com/api/v1/auth/otp");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "No-Authentication:true",
    "deviceId:$deviceId",
    "Authorization:Bearer null",
    "x-kk-buildversion:ANDROID-2.0.6",
    "model:Redmi-M2101K6G",
    "sentry-trace:3e981dbad95a44839b54289432a139f4-6f2326c5b4084f10",
    "baggage:sentry-environment=prd,sentry_public_key=9ac581eafc4947ffb55167d21888c7c7,sentry-release=com.koanba.kipaskipas@2.0.6+335,sentry-trace_id=3e981dbad95a44839b54289432a139f4",
    "Content-Type:application/json; charset=UTF-8",
    "Host:api-main.kipaskipas.com",
    "Connection:Keep-Alive",
    "User-Agent:okhttp/4.12.0"
]);

$data = json_encode([
    "phoneNumber" => $phoneNumber,
    "platform" => "WHATSAPP",
    "type" => "LOGIN"
]);

curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

$response = curl_exec($ch);
curl_close($ch);

$responseData = json_decode($response, true);
$message = $responseData['message'] ?? 'Tidak ada pesan';

echo "Respons: $message\n";

echo "Masukkan OTP Code: ";
$otpCode = trim(fgets(STDIN));

$userNotifId = uniqid();

$ch2 = curl_init();

curl_setopt($ch2, CURLOPT_URL, "https://api-main.kipaskipas.com/api/v1/auth/login/v2");
curl_setopt($ch2, CURLOPT_POST, 1);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_HTTPHEADER, [
    "No-Authentication:true",
    "deviceId:$deviceId",
    "Authorization:Bearer null",
    "x-kk-buildversion:ANDROID-2.0.6",
    "model:Redmi-M2101K6G",
    "sentry-trace:f24c038c181f43d6b077211d8cbabc7c-6f0307e82b054722",
    "baggage:sentry-environment=prd,sentry_public_key=9ac581eafc4947ffb55167d21888c7c7,sentry-release=com.koanba.kipaskipas@2.0.6+335,sentry_trace_id=f24c038c181f43d6b077211d8cbabc7c",
    "Content-Type:application/json; charset=UTF-8",
    "Host:api-main.kipaskipas.com",
    "Connection:Keep-Alive",
    "User-Agent:okhttp/4.12.0"
]);

$data2 = json_encode([
    "deviceId" => $deviceId,
    "otpCode" => $otpCode,
    "platform" => "WHATSAPP",
    "userNotifId" => $userNotifId,
    "username" => $phoneNumber
]);

curl_setopt($ch2, CURLOPT_POSTFIELDS, $data2);

$response2 = curl_exec($ch2);
curl_close($ch2);

$responseData2 = json_decode($response2, true);
$message2 = $responseData2['message'] ?? 'Tidak ada pesan';

echo "Respons Login: $message2\n";

$ch3 = curl_init();

curl_setopt($ch3, CURLOPT_URL, "https://api-main.kipaskipas.com/api/v1/auth/registers");
curl_setopt($ch3, CURLOPT_POST, 1);
curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch3, CURLOPT_HTTPHEADER, [
    "No-Authentication:true",
    "deviceId:$deviceId",
    "Authorization:Bearer null",
    "x-kk-buildversion:ANDROID-2.0.6",
    "model:Redmi-M2101K6G",
    "sentry-trace:9127c51bd9a1430696f7672994c65a70-378dd3b50b3548c2",
    "baggage:sentry-environment=prd,sentry_public_key=9ac581eafc4947ffb55167d21888c7c7,sentry-release=com.koanba.kipaskipas@2.0.6+335,sentry-trace_id=9127c51bd9a1430696f7672994c65a70",
    "Content-Type:application/json; charset=UTF-8",
    "Host:api-main.kipaskipas.com",
    "Connection:Keep-Alive",
    "User-Agent:okhttp/4.12.0"
]);

echo "Masukkan Kode Referral (kosongkan jika tidak ada): ";
$referralCode = trim(fgets(STDIN));
if (empty($referralCode)) {
    $referralCode = "fifzrvmo";
}
echo "kode reff : $referralCode\n";
$data3 = json_encode([
    "birthDate" => "1995-09-05",
    "deviceId" => $deviceId,
    "mobile" => $phoneNumber,
    "otpCode" => $otpCode,
    "password" => "@Cuan2024",
    "referralCode" => $referralCode,
    "userNotifId" => $userNotifId
]);

curl_setopt($ch3, CURLOPT_POSTFIELDS, $data3);

$response3 = curl_exec($ch3);
curl_close($ch3);

$responseData3 = json_decode($response3, true);
$message3 = $responseData3['message'] ?? 'Tidak ada pesan';
$accessToken = $responseData3['access_token'] ?? 'Tidak ada access token';
$refreshToken = $responseData3['refresh_token'] ?? 'Tidak ada refresh token';
$accountId = $responseData3['accountId'] ?? 'Tidak ada accountId';
$userName = $responseData3['userName'] ?? 'Tidak ada userName';

//echo "Respons Registrasi: $message3\n";
//echo "Access Token: $accessToken\n";
//echo "Refresh Token: $refreshToken\n";
//echo "accountId: $accountId\n";
//echo "User Name: $userName\n";
//$fileContent = "Access Token: $accessToken\naccountId: $accountId\nUser Name: $userName\n";
//file_put_contents($accountId.'.txt', $fileContent);

echo "Data disimpan ke $accountId.txt\n";
goto skipnama;
echo "Masukkan Nama: ";
$nama = trim(fgets(STDIN));

$ch4 = curl_init();

curl_setopt($ch4, CURLOPT_URL, "https://api-main.kipaskipas.com/api/v1/profile/".$accountId);
curl_setopt($ch4, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch4, CURLOPT_HTTPHEADER, [
    "deviceId: $deviceId",
    "Authorization: Bearer $accessToken",
    "x-kk-buildversion: ANDROID-2.0.6",
    "model: Redmi-M2101K6G",
    "sentry-trace: b89deeea025f41a38df061c4c72a63e8-a4bf28881d124e72",
    "baggage: sentry-environment=prd,sentry_public_key=9ac581eafc4947ffb55167d21888c7c7,sentry-release=com.koanba.kipaskipas@2.0.6+335,sentry-trace_id=b89deeea025f41a38df061c4c72a63e8",
    "Content-Type: application/json; charset=UTF-8",
    "Connection: Keep-Alive",
    "User-Agent: okhttp/4.12.0"
]);

$data4 = json_encode([
    "name" => $nama,
    "photo" => "https://koanba-storage-prod.oss-cn-hongkong.aliyuncs.com/img/media/noGender.png",
    "socialMedias" => []
]);

curl_setopt($ch4, CURLOPT_POSTFIELDS, $data4);

$response4 = curl_exec($ch4);
curl_close($ch4);
///var_dump($response4);

$responseData4 = json_decode($response4, true);
$message4 = $responseData4['message'] ?? 'Tidak ada pesan';

echo "Respons Update Profile: $message4\n";
skipnama:
echo "Login ulang.....\n";
//sleep(3);

$url = "https://api-main.kipaskipas.com/api/v1/auth/login/v2";

$data = [
    "deviceId" => $deviceId,
    "password" => "@Cuan2024",
    "userNotifId" => $userNotifId,
    "username" => $phoneNumber
];

$headers = [
    "Host: api-main.kipaskipas.com",
    "no-authentication: true",
    "deviceid: ".$deviceId,
    "authorization: Bearer null",
    "x-kk-buildversion: ANDROID-2.0.6",
    "model: Redmi-M2101K6G",
    "sentry-trace: c50c9bc3511946509d3dec08bd20f1bd-4e286ab33d894298",
    "baggage: sentry-environment=prd,sentry-public_key=9ac581eafc4947ffb55167d21888c7c7,sentry-release=com.koanba.kipaskipas@2.0.6+335,sentry-trace_id=c50c9bc3511946509d3dec08bd20f1bd",
    "content-type: application/json; charset=UTF-8",
    "user-agent: okhttp/4.12.0"
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_2_0);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    //echo $response;
$responseData = json_decode($response, true);
$message3 = $responseData['message'] ?? 'Tidak ada pesan';
$accessToken = $responseData['access_token'] ?? 'Tidak ada access token';
$refreshToken = $responseData['refresh_token'] ?? 'Tidak ada refresh token';
$accountId = $responseData['accountId'] ?? 'Tidak ada accountId';
$userName = $responseData['userName'] ?? 'Tidak ada userName';

echo "Respons Registrasi: $message3\n";
echo "Access Token: $accessToken\n";
echo "Refresh Token: $refreshToken\n";
echo "accountId: $accountId\n";
echo "User Name: $userName\n";

$fileContent = "Access Token: $accessToken\naccountId: $accountId\nUser Name: $userName\n";
file_put_contents($accountId.'.txt', $fileContent);

echo "Data disimpan ke $accountId.txt\n";
}

curl_close($ch);

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
    "bio" => "noting",
    "birthDate" => generateRandomBirthDate(),
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
    echo "Referral Code: $referralCode\n";
} else {
    echo "Data tidak ditemukan dalam respons.\n";
}
}

curl_close($ch);

?>
