
<html>

<body>
<?php
$UserCode = "A10AE";
$APIToken = "659630-DGQq6T0GFZsKQHRpk5RBJ4n5QJ2MU2zQ3ZWGInk69myTZ0qFkn";
$EndpointURL = "https://api.lessannoyingcrm.com";
 
$Function = "CreateContact";
      
    //Just put the contact info into an array...
    $Parameters = array(
        "FullName"=>$_REQUEST['ContactName'],
        "Email"=>array(
                    0=>array(
                        "Text"=>"$_REQUEST[Email]",
                        "Type"=>"Work"
                    )
                ),
        "Phone"=>array(
                    0=>array(
                        "Text"=>"$_REQUEST[Phone]",
                        "Type"=>"Work"
                    )
                ),
    );
 
 $ContactId = $Result['ContactId'];
  
$Function = "CreateNote";
$Parameters = array(
    "ContactId"=>$ContactId,
    "Note"=>$_REQUEST['Comment']
);
$Results = CallAPI($EndpointURL, $UserCode, $APIToken, $Function, $Parameters);

header('location:confirm.html');
 
//The CallAPI function is at the bottom of this file
CallAPI($EndpointURL, $UserCode, $APIToken, $Function, $Parameters);
 
function CallAPI($EndpointURL, $UserCode, $APIToken, $Function, $Parameters){
    $APIResult = file_get_contents("$EndpointURL?UserCode=$UserCode&APIToken=$APIToken&".
                "Function=$Function&Parameters=".urlencode(json_encode($Parameters)));
    $APIResult = json_decode($APIResult, true);
       
    if(@$APIResult['Success'] === true){
        //echo "Success!";
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
