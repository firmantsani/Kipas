<?php
echo "\n\nJoin diskusi channel https://t.me/Si_New_Bie\n\n";
function generateRandomDeviceId($length = 16) {
    $characters = '0123456789abcdef';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; i < $length; $i++) {
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

$data3 = json_encode([
    "birthDate" => "1995-09-05",
    "deviceId" => $deviceId,
    "mobile" => $phoneNumber,
    "otpCode" => $otpCode,
    "password" => "@Mamen123",
    "referralCode" => "fifzrvmo",
    "userNotifId" => $userNotifId
]);

curl_setopt($ch3, CURLOPT_POSTFIELDS, $data3);

$response3 = curl_exec($ch3);
curl_close($ch3);

$responseData3 = json_decode($response3, true);
$message3 = $responseData3['message'] ?? 'Tidak ada pesan';
$accessToken = $responseData3['access_token'] ?? 'Tidak ada access token';
$refreshToken = $responseData3['refresh_token'] ?? 'Tidak ada refresh token';
$userNo = $responseData3['userNo'] ?? 'Tidak ada userNo';
$userName = $responseData3['userName'] ?? 'Tidak ada userName';

echo "Respons Registrasi: $message3\n";
echo "Access Token: $accessToken\n";
echo "Refresh Token: $refreshToken\n";
echo "User No: $userNo\n";
echo "User Name: $userName\n";

echo "Masukkan Nama: ";
$nama = trim(fgets(STDIN));

$ch4 = curl_init();

curl_setopt($ch4, CURLOPT_URL, "https://api-main.kipaskipas.com/api/v1/profile/$userNo");
curl_setopt($ch4, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch4, CURLOPT_HTTPHEADER, [
    "deviceId:$deviceId",
    "Authorization:Bearer $accessToken",
    "x-kk-buildversion:ANDROID-2.0.6",
    "model:Redmi-M2101K6G",
    "sentry-trace:b89deeea025f41a38df061c4c72a63e8-a4bf28881d124e72",
    "baggage:sentry-environment=prd,sentry_public_key=9ac581eafc4947ffb55167d21888c7c7,sentry-release=com.koanba.kipaskipas@2.0.6+335,sentry-trace_id=b89deeea025f41a38df061c4c72a63e8",
    "Content-Type:application/json; charset=UTF-8",
    "Content-Length:124",
    "Host:api-main.kipaskipas.com",
    "Connection:Keep-Alive",
    "Accept-Encoding:gzip",
    "User-Agent:okhttp/4.12.0"
]);

$data4 = json_encode([
    "name" => $nama,
    "photo" => "https://koanba-storage-prod.oss-cn-hongkong.aliyuncs.com/img/media/noGender.png",
    "socialMedias" => []
]);

curl_setopt($ch4, CURLOPT_POSTFIELDS, $data4);

$response4 = curl_exec($ch4);
curl_close($ch4);

$responseData4 = json_decode($response4, true);
$message4 = $responseData4['message'] ?? 'Tidak ada pesan';

echo "Respons Update Profile: $message4\n";
?>
