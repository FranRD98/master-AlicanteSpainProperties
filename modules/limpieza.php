<?php

// require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

// mysqli_select_db($database_inmoconn, $inmoconn);
// $query_rsLoc4 = "SELECT * FROM properties_property_feature_priv";
// $rsLoc4 = mysqli_query($query_rsLoc4, $inmoconn) or die(mysqli_error());
// $row_rsLoc4 = mysqli_fetch_assoc($rsLoc4);
// $totalRows_rsLoc4 = mysqli_num_rows($rsLoc4);

// do {

//     mysqli_select_db($database_inmoconn, $inmoconn);
//     $query_rsProperty = "SELECT * FROM properties_properties WHERE id_prop = '" . $row_rsLoc4['property'] . "'";
//     $rsProperty = mysqli_query($query_rsProperty, $inmoconn) or die(mysqli_error());
//     $row_rsProperty = mysqli_fetch_assoc($rsProperty);
//     $totalRows_rsProperty = mysqli_num_rows($rsProperty);

//     if ( $totalRows_rsProperty == 0) {

//         mysqli_select_db($database_inmoconn, $inmoconn);
//         $query_rsProperty = "DELETE FROM properties_property_feature_priv WHERE property = '" . $row_rsLoc4['property'] . "'";
//         $rsProperty = mysqli_query($query_rsProperty, $inmoconn) or die(mysqli_error());
//         echo $row_rsLoc4['property'];
//         echo "<br>";
//         echo $row_rsLoc4['feature'];
//         echo "<hr>";
//     }

// } while ($row_rsLoc4 = mysqli_fetch_assoc($rsLoc4));

// mysqli_select_db($database_inmoconn, $inmoconn);
// $query_rsLoc4 = "SELECT * FROM properties_features_priv";
// $rsLoc4 = mysqli_query($query_rsLoc4, $inmoconn) or die(mysqli_error());
// $row_rsLoc4 = mysqli_fetch_assoc($rsLoc4);
// $totalRows_rsLoc4 = mysqli_num_rows($rsLoc4);

// do {

//     mysqli_select_db($database_inmoconn, $inmoconn);
//     $query_rsProperty = "SELECT * FROM properties_property_feature_priv WHERE feature = '" . $row_rsLoc4['id_feat'] . "'";
//     $rsProperty = mysqli_query($query_rsProperty, $inmoconn) or die(mysqli_error());
//     $row_rsProperty = mysqli_fetch_assoc($rsProperty);
//     $totalRows_rsProperty = mysqli_num_rows($rsProperty);

//     if ( $totalRows_rsProperty == 0) {

//         mysqli_select_db($database_inmoconn, $inmoconn);
//         $query_rsProperty = "DELETE FROM properties_features_priv WHERE id_feat = '" . $row_rsLoc4['id_feat'] . "'";
//         $rsProperty = mysqli_query($query_rsProperty, $inmoconn) or die(mysqli_error());
//         echo $row_rsLoc4['id_feat'];
//         echo "<br>";
//         echo $row_rsLoc4['feature_en_feat'];
//         echo "<hr>";
//     }

// } while ($row_rsLoc4 = mysqli_fetch_assoc($rsLoc4));

// mysqli_select_db($database_inmoconn, $inmoconn);
// $query_rsLoc4 = "SELECT * FROM properties_types";
// $rsLoc4 = mysqli_query($query_rsLoc4, $inmoconn) or die(mysqli_error());
// $row_rsLoc4 = mysqli_fetch_assoc($rsLoc4);
// $totalRows_rsLoc4 = mysqli_num_rows($rsLoc4);

// do {

//     mysqli_select_db($database_inmoconn, $inmoconn);
//     $query_rsProperty = "SELECT * FROM properties_properties WHERE tipo_prop = '" . $row_rsLoc4['id_typ'] . "'";
//     $rsProperty = mysqli_query($query_rsProperty, $inmoconn) or die(mysqli_error());
//     $row_rsProperty = mysqli_fetch_assoc($rsProperty);
//     $totalRows_rsProperty = mysqli_num_rows($rsProperty);

//     if ( $totalRows_rsProperty == 0) {

//         mysqli_select_db($database_inmoconn, $inmoconn);
//         $query_rsProperty = "DELETE FROM properties_types WHERE id_typ = '" . $row_rsLoc4['id_typ'] . "'";
//         $rsProperty = mysqli_query($query_rsProperty, $inmoconn) or die(mysqli_error());
//         echo $row_rsLoc4['id_typ'];
//         echo "<br>";
//         echo $row_rsLoc4['types_en_typ'];
//         echo "<hr>";
//     }

// } while ($row_rsLoc4 = mysqli_fetch_assoc($rsLoc4));

// mysqli_select_db($database_inmoconn, $inmoconn);
// $query_rsLoc1 = "SELECT * FROM properties_loc1";
// $rsLoc1 = mysqli_query($query_rsLoc1, $inmoconn) or die(mysqli_error());
// $row_rsLoc1 = mysqli_fetch_assoc($rsLoc1);
// $totalRows_rsLoc1 = mysqli_num_rows($rsLoc1);

// do {

//     mysqli_select_db($database_inmoconn, $inmoconn);
//     $query_rsProperty = "SELECT * FROM properties_loc2 WHERE loc1_loc2 = '" . $row_rsLoc1['id_loc1'] . "'";
//     $rsProperty = mysqli_query($query_rsProperty, $inmoconn) or die(mysqli_error());
//     $row_rsProperty = mysqli_fetch_assoc($rsProperty);
//     $totalRows_rsProperty = mysqli_num_rows($rsProperty);

//     if ( $totalRows_rsProperty == 0) {

//         mysqli_select_db($database_inmoconn, $inmoconn);
//         $query_rsProperty = "DELETE FROM properties_loc1 WHERE id_loc1 = '" . $row_rsLoc1['id_loc1'] . "'";
//         $rsProperty = mysqli_query($query_rsProperty, $inmoconn) or die(mysqli_error());
//         echo $row_rsLoc1['id_loc1'];
//         echo "<br>";
//         echo $row_rsLoc1['name_en_loc1'];
//         echo "<hr>";
//     }

// } while ($row_rsLoc1 = mysqli_fetch_assoc($rsLoc1));

// mysqli_select_db($database_inmoconn, $inmoconn);
// $query_rsLoc2 = "SELECT * FROM properties_loc2";
// $rsLoc2 = mysqli_query($query_rsLoc2, $inmoconn) or die(mysqli_error());
// $row_rsLoc2 = mysqli_fetch_assoc($rsLoc2);
// $totalRows_rsLoc2 = mysqli_num_rows($rsLoc2);

// do {

//     mysqli_select_db($database_inmoconn, $inmoconn);
//     $query_rsProperty = "SELECT * FROM properties_loc3 WHERE loc2_loc3 = '" . $row_rsLoc2['id_loc2'] . "'";
//     $rsProperty = mysqli_query($query_rsProperty, $inmoconn) or die(mysqli_error());
//     $row_rsProperty = mysqli_fetch_assoc($rsProperty);
//     $totalRows_rsProperty = mysqli_num_rows($rsProperty);

//     if ( $totalRows_rsProperty == 0) {

//         mysqli_select_db($database_inmoconn, $inmoconn);
//         $query_rsProperty = "DELETE FROM properties_loc2 WHERE id_loc2 = '" . $row_rsLoc2['id_loc2'] . "'";
//         $rsProperty = mysqli_query($query_rsProperty, $inmoconn) or die(mysqli_error());
//         echo $row_rsLoc2['id_loc2'];
//         echo "<br>";
//         echo $row_rsLoc2['name_en_loc2'];
//         echo "<hr>";
//     }

// } while ($row_rsLoc2 = mysqli_fetch_assoc($rsLoc2));

// mysqli_select_db($database_inmoconn, $inmoconn);
// $query_rsLoc3 = "SELECT * FROM properties_loc3";
// $rsLoc3 = mysqli_query($query_rsLoc3, $inmoconn) or die(mysqli_error());
// $row_rsLoc3 = mysqli_fetch_assoc($rsLoc3);
// $totalRows_rsLoc3 = mysqli_num_rows($rsLoc3);

// do {

//     mysqli_select_db($database_inmoconn, $inmoconn);
//     $query_rsProperty = "SELECT * FROM properties_loc4 WHERE loc3_loc4 = '" . $row_rsLoc3['id_loc3'] . "'";
//     $rsProperty = mysqli_query($query_rsProperty, $inmoconn) or die(mysqli_error());
//     $row_rsProperty = mysqli_fetch_assoc($rsProperty);
//     $totalRows_rsProperty = mysqli_num_rows($rsProperty);

//     if ( $totalRows_rsProperty == 0) {

//         mysqli_select_db($database_inmoconn, $inmoconn);
//         $query_rsProperty = "DELETE FROM properties_loc3 WHERE id_loc3 = '" . $row_rsLoc3['id_loc3'] . "'";
//         $rsProperty = mysqli_query($query_rsProperty, $inmoconn) or die(mysqli_error());
//         echo $row_rsLoc3['id_loc3'];
//         echo "<br>";
//         echo $row_rsLoc3['name_en_loc3'];
//         echo "<hr>";
//     }

// } while ($row_rsLoc3 = mysqli_fetch_assoc($rsLoc3));

// mysqli_select_db($database_inmoconn, $inmoconn);
// $query_rsLoc4 = "SELECT * FROM properties_loc4";
// $rsLoc4 = mysqli_query($query_rsLoc4, $inmoconn) or die(mysqli_error());
// $row_rsLoc4 = mysqli_fetch_assoc($rsLoc4);
// $totalRows_rsLoc4 = mysqli_num_rows($rsLoc4);

// do {

//     mysqli_select_db($database_inmoconn, $inmoconn);
//     $query_rsProperty = "SELECT * FROM properties_properties WHERE localidad_prop = '" . $row_rsLoc4['id_loc4'] . "'";
//     $rsProperty = mysqli_query($query_rsProperty, $inmoconn) or die(mysqli_error());
//     $row_rsProperty = mysqli_fetch_assoc($rsProperty);
//     $totalRows_rsProperty = mysqli_num_rows($rsProperty);

//     if ( $totalRows_rsProperty == 0) {

//         mysqli_select_db($database_inmoconn, $inmoconn);
//         $query_rsProperty = "DELETE FROM properties_loc4 WHERE id_loc4 = '" . $row_rsLoc4['id_loc4'] . "'";
//         $rsProperty = mysqli_query($query_rsProperty, $inmoconn) or die(mysqli_error());
//         echo $row_rsLoc4['id_loc4'];
//         echo "<br>";
//         echo $row_rsLoc4['name_en_loc4'];
//         echo "<hr>";
//     }

// } while ($row_rsLoc4 = mysqli_fetch_assoc($rsLoc4));











