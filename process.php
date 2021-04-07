<?php

$UserCode = "A10AE";
$APIToken = "659630-DGQq6T0GFZsKQHRpk5RBJ4n5QJ2MU2zQ3ZWGInk69myTZ0qFkn";
 
 
//The first step is to create a contact
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
 
//...And then use the "CallAPI" function to send the information to LACRM
$Result = CallAPI($UserCode, $APIToken, $Function, $Parameters);
//That's it, the contact will now show up in the CRM!
 
//Now let's enter the "Comment" field from the HTML form as a note on the contact's record
//Get the new ContactId
$ContactId = $Result['ContactId'];
 
 
$Function = "CreateNote";
$Parameters = array(
    "ContactId"=>$ContactId,
    "Note"=>$_REQUEST['Comment']
);
 
//And pass that note to the API
$Result = CallAPI($UserCode, $APIToken, $Function, $Parameters);
 
/*
There are all kinds of other things you might want to do here as well such as:
    -Set a task to follow up with the contact (https://www.lessannoyingcrm.com/help/topic/API_Example_Code_PHP/11/)
    -Add the contact as a lead (https://www.lessannoyingcrm.com/help/topic/API_Example_Code_PHP/87/)
    -Add the contact to a group (https://www.lessannoyingcrm.com/help/topic/API_Example_Code_PHP/13/)
    -Send an email to yourself letting you know a form was submitted (you can use the PHP "mail" function)
*/
 
 
//Now forward the visitor to an html page confirming that we got their contact info
header('location:confirm.html');
 
  
/*
    This function takes all of the settings needed to call the API and puts them into
    one long URL, and then it makes an HTTP request to that URL.
*/
function CallAPI($UserCode, $APIToken, $Function, $Parameters){
    $APIResult = file_get_contents("https://api.lessannoyingcrm.com?UserCode=$UserCode&APIToken=$APIToken&".
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
