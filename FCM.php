<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   
    $title = $_GET['title'] ?? null;
    $description = $_GET['description'] ?? null;


    if ($title !== null && $description !== null) {


//https://web.com/FCM.php?title=Hello%20user!%20%F0%9F%98%8E&description=Go%20to%20puri%20tomorrow!

// FCM API Url
$url = 'https://fcm.googleapis.com/fcm/send';

//add your key 
$apiKey = "AAAAVuvX8fc:APA91bHhAa_JQW6fCYe6iCK2uuYcwVAVNRFDj-f5myRk9cza5AZu7hUy7rS0FCI0u4dQb0cE-Ark0ix1KunDDxCex8iAC2x7fWnoo0jRkUoEI96khHwWsnkzciOQ2RSd5";


$headers = array (
    'Authorization:key=' . $apiKey,
    'Content-Type:application/json'
  );


  $notifData = [
    'title' => $title,
    'body' => $description,
    'image' => ""
    ];


    $apiBody = [
        'notification' => $notifData,
        'time_to_live' => 600, 
         'to' => '/topics/all'
      ]; 


      $ch = curl_init();
      curl_setopt ($ch, CURLOPT_URL, $url);
      curl_setopt ($ch, CURLOPT_POST, true);
      curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt ($ch, CURLOPT_POSTFIELDS, json_encode($apiBody));

     
      $result = curl_exec($ch);
      print($result);
      // Close curl after call
      curl_close($ch);

      return $result;




        // Send JSON response
        header('Content-Type: application/json');
        echo json_encode($result);
    } else {
        // Error handling for missing input
        http_response_code(400); // Bad Request
        echo json_encode(array('error' => 'Missing input data.'));
    }
} else {
    // If not a GET request, return error
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('error' => 'Method not allowed.'));
}
?>
