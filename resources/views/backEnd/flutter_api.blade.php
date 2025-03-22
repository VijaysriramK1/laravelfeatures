<?php

if (isset($_GET['send_notification'])) {
    send_notification();
}

function send_notification()
{
    define('API_ACCESS_KEY', '');
    //   $registrationIds = ;
    #prep the bundle
    $msg = [
        'body' => $_REQUEST['body'],
        'title' => $_REQUEST['title'],
    ];
    $fields = [
        'to' => $_REQUEST['token'],
        'notification' => $msg,
    ];

    $headers = ['Authorization: key=' . API_ACCESS_KEY, 'Content-Type: application/json'];
    #Send Reponse To FireBase Server
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    echo $result;
    curl_close($ch);
}
?>
