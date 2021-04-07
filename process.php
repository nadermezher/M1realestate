<html>

<body>
<?php
$UserCode = "A10AE";
$APIToken = "659630-DGQq6T0GFZsKQHRpk5RBJ4n5QJ2MU2zQ3ZWGInk69myTZ0qFkn";
$EndpointURL = "https://api.lessannoyingcrm.com";
 
$Function = "CreateContact";
 
/*
Notes:
The only required field is a contact or company name. If you enter a company name
but not a contact name, we will only create a company and all the other info (phone,
email, etc.) will be stored with the company. If you enter both a contact AND a company
name, we'll create both records and all the other info will be stored with the contact.
*/
 
/*
When entering a contact, you can either enter a FullName, or five separate fields
(Salutation, FirstName, MiddleName, LastName, Suffix). If you enter the separate
names, you are required to have at least a first or a last name (everything else
is optional). Here are the different formats:
*/
$Parameters = array(
    "FullName"=>$_REQUEST['ContactName'],
    "Email"=>array(
                0=>array(
                    "Text"=>$_REQUEST['Email'],
                    "Type"=>"Work"
                )
            ),
    "Phone"=>array(
                0=>array(
                    "Text"=>$_REQUEST['Phone'],
                    "Type"=>"Work"
                )
            ),
);
 
//The CallAPI function is at the bottom of this file
CallAPI($EndpointURL, $UserCode, $APIToken, $Function, $Parameters);
 
function CallAPI($EndpointURL, $UserCode, $APIToken, $Function, $Parameters){
    $PostData = array(
      'UserCode' => $UserCode,
      'APIToken' => $APIToken,
      'Function' => $Function,
      'Parameters' => json_encode($Parameters),
    );
    $Options = array(
        'http' =>
            array(
                'method'  => 'POST', //We are using the POST HTTP method.
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($PostData) // URL-encoded query string.
            )
    );
    $StreamContext  = stream_context_create($Options);
    $APIResult = file_get_contents("$EndpointURL?UserCode=$UserCode", false, $StreamContext);
    $APIResult = json_decode($APIResult, true);
    if(@$APIResult['Success'] === true){
        echo "Success!";
    }
    else{
        echo "API call failed. Error:".@$APIResult['Error'];
        exit;
    }
    return $APIResult;
}
?>
</body>
</html>
