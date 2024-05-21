<?php

echo "Shorten links. Promt example 'google.com' or 'www.google.com'" . PHP_EOL;
$inputLink = trim(strtolower(readline("Enter a link to shorten: ")));

$linkToShorten = "https://{$inputLink}";

$url = "https://cleanuri.com/api/v1/shorten";

$ch = curl_init($url);

$postData = [
    'url' => $linkToShorten
];

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));


try {
    $response = curl_exec($ch);

    if ($response === false) {
        throw new Exception('Curl error: ' . curl_error($ch));
    }

    curl_close($ch);

    $shortenedData = json_decode($response);

    if ($shortenedData === null) {
        throw new Exception("Error parsing response data");
    }

    if (isset($shortenedData->result_url)) {
        echo "Shortened URL: " . $shortenedData->result_url . PHP_EOL;
    } else {
        throw new Exception("Error: " . $shortenedData->error ?? "Unknown error");
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}