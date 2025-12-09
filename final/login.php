<?php
session_start();

//fill in php stuff
$host = 'localhost';
$dbname = 'users_db';
$db_username = 'your_username';
$db_password = 'your_password';

$conn = mysqli_connect($host, $db_username, $db_password, $dbname);
if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

$client_id = '848625515070-t1uqu7tvg0b0lraqqo19c7n768pak6jq.apps.googleusercontent.com';
$client_secret = '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';
$redirect_uri = 'https://emmal.sgedu.site/login.php';  // UPDATE THIS 

if (!isset($_GET['code'])) {
    $auth_url = 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query([
        'client_id' => $client_id,
        'redirect_uri' => $redirect_uri,
        'response_type' => 'code',
        'scope' => 'email profile',
        'access_type' => 'offline',
        'prompt' => 'consent'
    ]);
    header('Location: ' . $auth_url);
    exit;
}

$post_fields = http_build_query([
    'code' => $_GET['code'],
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri' => $redirect_uri,
    'grant_type' => 'authorization_code'
]);

$context = stream_context_create([
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => $post_fields,
    ],
    'ssl' => [
        'verify_peer' => true,
        'verify_peer_name' => true
    ]
]);

$response = file_get_contents('https://oauth2.googleapis.com/token', false, $context);
$token_data = json_decode($response, true);

if (!isset($token_data['access_token'])) {
    die('Token exchange failed: ' . htmlspecialchars($response));
}

$access_token = $token_data['access_token'];

$user_info_context = stream_context_create([
    'http' => [
        'header' => "Authorization: Bearer " . $access_token . "\r\n"
    ],
    'ssl' => [
        'verify_peer' => true,
        'verify_peer_name' => true
    ]
]);

$user_info_json = file_get_contents('https://openidconnect.googleapis.com/v1/userinfo', false, $user_info_context);

if ($user_info_json === false) {
    die('Failed to fetch user info from Google');
}

$user_info = json_decode($user_info_json, true);

if (!$user_info) {
    die('Failed to parse user info: ' . htmlspecialchars($user_info_json));
}

$google_id = $user_info['sub'] ?? '';
$email = $user_info['email'] ?? '';
$name = $user_info['name'] ?? '';
$picture = $user_info['picture'] ?? '';

if (empty($google_id)) {
    die('Invalid user data from Google');
}

// check if user in database
$stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE google_id = ?");
mysqli_stmt_bind_param($stmt, "s", $google_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) { //login
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $row['user_id'];
    
    $update_stmt = mysqli_prepare($conn, "UPDATE users SET last_login = NOW() WHERE user_id = ?");
    mysqli_stmt_bind_param($update_stmt, "i", $row['user_id']);
    mysqli_stmt_execute($update_stmt);
    mysqli_stmt_close($update_stmt);
} else { //signup
    $insert_stmt = mysqli_prepare($conn, "INSERT INTO users (google_id, email, name, profile_picture) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($insert_stmt, "ssss", $google_id, $email, $name, $picture);
    mysqli_stmt_execute($insert_stmt);
    
    $_SESSION['user_id'] = mysqli_insert_id($conn);
    mysqli_stmt_close($insert_stmt);
}

$_SESSION['user_email'] = $email;
$_SESSION['user_name'] = $name;
$_SESSION['user_picture'] = $picture;

mysqli_stmt_close($stmt);
mysqli_close($conn);

header('Location: /index.html');
exit;
?>
