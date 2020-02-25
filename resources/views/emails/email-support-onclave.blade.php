<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Support Mail</title>
</head>
<body>
Dear Onclave, <br>
We(SCPwD) are facing some issue with resolving one of our Client's Query Regarding PMS (Partner Management System). <br>
We do need little Support from you to Slove this ASAP. We Have Attached everything we have received from our Client. <br>
It will be very much helpful if you connect us on the same with proper solution. Thank you.

<h4>Token ID : {{$data->token_id}} <br>
Raised By : {{$data->username.' ('.$data->userid.') on '.\Carbon\Carbon::parse($data->created_at)->format('d-m-Y')}} <br>
Issue Type : {{$data->issue}} <br>
Subject : {{$data->subject}} <br>
Description : <br>
    {{$data->description}}
</h4>
</body>
</html>