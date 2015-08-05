<?php
session_start();
$myusername=$_SESSION['email'];

$host="navigatingknowledge.com";  
$username="danieljclark1";
$password="NULL";
$db_name="NK_Map_Login"; 
$tbl_name="Users"; 

mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
mysql_select_db("$db_name")or die("cannot select DB");

$myusername=$_POST['email']; 
$mypassword=$_POST['email_password']; 

$email_validation = filter_var( $myusername, FILTER_VALIDATE_EMAIL );
if($email_validation == false) {
  echo "Please enter your email address.";
} 

$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$sql="SELECT * FROM $tbl_name WHERE email='$myusername'";
$result=mysql_query($sql);
$count=mysql_num_rows($result);

if($count>=1){
session_start();
$_SESSION['email']=$myusername;
header("location:http://www.navigatingknowledge.com/map.php");
}
else {
session_start();
$_SESSION['email']=$myusername;
header("location:http://www.navigatingknowledge.com/php/confirmation.php");


$sql1="INSERT INTO Users (email) VALUES ('$_POST[email]')";
mysql_query($sql1);

$sql2="INSERT INTO `Overlays` (email, visible, concept, file, owner, subject, source, link) SELECT '$_POST[email]', visible, concept, file, owner, subject, source, link FROM `Overlays` WHERE `ID`='2365';";
mysql_query($sql2);

$sql3="INSERT INTO Overlays (email,source,owner,file,visible,link,concept,subject) VALUES ('$_POST[email]','Understanding NK Concepts','layers@navigatingknowledge.com','completeAllNotecards.addTo(map)',1,'https://squareup.com/market/navigatingknowledge','0000.99.php','Navigating Knowledge')";
mysql_query($sql3);

$sql4="INSERT INTO `Overlays` (email, visible, concept, file, owner, subject, source, link) SELECT '$_POST[email]', visible, concept, file, owner, subject, source, link FROM `Overlays` WHERE `ID`='3889';";
mysql_query($sql4);

$to = $_POST[email];
$to .= ", dan.clark@navigatingknowledge.com";
$subject = 'Let\'s start exploring Navigating Knowledge';
$headers = "From: Navigating Knowledge <dan.clark@navigatingknowledge.com>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message = "<html><head><style>html,body {width:85%;margin:0 auto;margin-top:15px} </style></head><body>";
$message .= "<a href='http://www.navigatingknowledge.com'> <img src='http://www.navigatingknowledge.com/images/logo.png' height='45px'/> </a>";
$message .= "<div style='font-family:HelveticaNeue-Light;margin-bottom:25px;margin-top:25px'><h4 style='font-family:helvetica'>With words like academic <em>fields</em> and <em>courses</em> it seems odd that we haven't been using a standardized map for education all along.</h4>";
$message .= "<p>Now <em>you</em> have the advantage. When you use <a href='http://www.navigatingknowledge.com' style='text-decoration:none;color:black'> Navigating Knowledge</a> you are utilizing the part of your brain that is built for memorization.</p>";
$message .= "<p>Sign-in with your email (<a href='' style='text-decoration:none;color:black'>$_POST[email]</a>), and you'll be guided to the Navigating Knowledge Map and all of its features for free.</p>";

$message .= "<p>Thank you for pioneering this powerful tool for education.<br></p>";
$message .= "Sincerely,<br> Dan Clark <br><br><em>founder and director Navigating Knowledge</em><br><a href='http://www.navigatingknowledge.com'>www.navigatingknowledge.com</a>";
$message .= "<br><br><p style='font-size:8px;color:gray;text-align:center'> Navigating Knowledge. Copyright &copy; 2014-2015 Daniel Clark. All rights reserved.</p>";
$message .= '</div>';
$message .= '</body></html>';
mail($to, $subject, $message, $headers);
}
?>
