<?php require_once('../../Connections/appconn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "")
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
//print_r($_GET['cat']);

if(isset($_GET['cat'])) {

$arr = array();

foreach($_GET['cat'] as $value) {
	array_push($arr, "".$value."");
}

/*

SELECT COUNT( * ) AS Result
FROM (

SELECT COUNT( usr )
FROM newsletter_usr_cat
WHERE cat
IN (".implode(',', $arr).")
GROUP BY usr
HAVING COUNT( * ) = ".count($arr)."
) AS temp



SELECT COUNT( * ) AS Result
FROM (
SELECT  email_nwsl
FROM newsletter where id_nwsl IN(
SELECT usr
FROM newsletter_usr_cat
WHERE cat
IN (".implode(',', $arr).")
GROUP BY usr
HAVING COUNT( * ) = ".count($arr).") AS temp

*/



$getEU =($_GET['allm'] != 'ok' && $_GET['langt'] != '')?"lang_usr = '".$_GET['langt']."' AND":"";


$arr2 = array();



$no_mail = explode(',', $_GET['nm']);


foreach($no_mail as $value) {
  array_push($arr2, "'".trim($value)."'");
}

$nomails = implode(',', $arr2);

if($nomails != '') {
  $nmls = " AND  email_usr NOT IN (".$nomails.") ";
} else {
  $nmls = "";
}


$query_rsUsers = "

SELECT  count(email_usr) as Result
FROM newsletter_users
 where  ".$getEU."   id_usr IN (
SELECT usr
FROM newsletter_usr_cat
WHERE cat
IN (".implode(',', $arr).")
GROUP BY id_usr  )
  $nmls
";
// HAVING COUNT( * ) = ".count($arr)."

$rsUsers = mysqli_query($appconn, $query_rsUsers) or die(mysqli_error());
$row_rsUsers = mysqli_fetch_assoc($rsUsers);
$totalRows_rsUsers = mysqli_num_rows($rsUsers);

//echo $query_rsUsers;

// echo $query_rsUsers;
?>
<?php echo $row_rsUsers['Result'] ?>
<?php
mysqli_free_result($rsUsers);

} else { echo 0;}

?>
