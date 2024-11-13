<?php

$apiKey = '7834360808:AAEZ6TwLiSqADkw2967IgbZsJYazQFPj1z4'; // Your Telegram bot API key
$apiUrl = "https://api.telegram.org/bot$apiKey/";

// Get the incoming message
$content = file_get_contents("php://input");
$update = json_decode($content, true);

// Extract necessary information from the update
$chat_id = $update['message']['chat']['id'];
$text = $update['message']['text'];
$message_id = $update['message']['message_id'];

// Check if the received message is the "/start" command
if ($text === '/start') {

    // Send a photo with caption
    $photoPath = 'home.png'; // Local path to the image

    // Debugging: Check if file exists and print path
    if (file_exists($photoPath)) {
        $realPath = realpath($photoPath);
    } else {
        error_log("File does not exist: " . $photoPath);
        $realPath = '';
    }

    $caption = "hello to bot star dogs 
    if you want code dm me @eraxdev
    ";

    // Send photo to Telegram
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl . "sendPhoto");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);

    $post_fields = [
        'chat_id' => $chat_id,
        'photo' => ($realPath ? new CURLFILE($realPath) : ''), // Use realpath to ensure correct path
        'caption' => $caption,
        'parse_mode' => 'Markdown', // Use Markdown for basic formatting
        'reply_to_message_id' => $message_id,
        'reply_markup' => json_encode([
            'inline_keyboard' => [
                [
                    ['text' => 'Play GamaDog Now', 'web_app' => ['url' => 'https://app.companybro.com']],
                    ['text' => 'contact to dev', 'url' => 'https://t.me/eraxdev']]
            ]
        ])
    ];

    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    $result = curl_exec($ch);

    if ($result === false) {
        error_log("CURL Error: " . curl_error($ch));
    } else {
        // Optionally, log the result for debugging
        error_log("Result: " . $result);
    }

    curl_close($ch);
}

?>
