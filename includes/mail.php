<?php
require_once "Mail.php";  //this includes the pear SMTP mail library
$from = "Password System Reset <noreply@loki.trentu.ca>";
$to = "David <davidehibello@trentu.ca>";  //put user's email here
$subject = "Asty account password reset link";
$body = "Follow the attached link to reset the password to your Asty account: https://loki.trentu.ca/~davidehibello/3420/assn/assn3/reset.php";
$host = "smtp.trentu.ca";
$headers = array ('From' => $from,
  'To' => $to,
  'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host));
  
$mail = $smtp->send($to, $headers, $body);
if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>");
 } else {
  echo("<p>Message successfully sent!</p>");
 }

?>