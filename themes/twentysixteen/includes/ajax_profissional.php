<?php
$db = mysql_connect('localhost','root',''); //Don't forget to change

mysql_select_db('treinamento', $db);          //theses parameters



//$req = mysql_query($sql) or die();


$query = "select wu.user_login
from wp_users wu
JOIN wp_usermeta wm ON wm.user_id = wu.ID
WHERE wm.meta_key = 'profissao' and wm.meta_value = 1";

$dataset = mysql_query($query);
$xml = "<?xml version='1.0' ?>";
$xml .= "<profissional>";
while($registros = mysql_fetch_assoc($dataset)){
    $xml .= "<pessoa tag='".$registros['ID']." value='".$registros['user_login']."'>";
}
$xml .= "</profissional>";
echo $xml;

