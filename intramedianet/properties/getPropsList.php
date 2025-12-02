<?php
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

$ids = explode(',', $_GET['ids']);

$properties = '';

if ($_GET['ids'] != '') {

    foreach ($ids as $id) {
        $query_rsProperty = "SELECT id_prop, referencia_prop FROM properties_properties WHERE id_prop = ".$id."";
        $rsProperty = mysqli_query($inmoconn, $query_rsProperty) or die(mysqli_error());
        $row_rsProperty = mysqli_fetch_assoc($rsProperty);
        $totalRows_rsProperty = mysqli_num_rows($rsProperty);

        $properties .= '<li class="dd-item"><div class="dd-handle"><i class="fa fa-bars fa-fw"></i></div><div class="dd-content">' . $row_rsProperty['referencia_prop'] .  '<input type="hidden" name="propslist1[]" class="propslist1Vals" value="' . $row_rsProperty['id_prop'] . '"></div></li>';
    }
    $properties .= '<input type="hidden" name="idsselcrit" class="idsselcrit" value="' . $_GET['ids'] . '">';

} else {

    $properties .= '<input type="hidden" name="idsselcrit" class="idsselcrit" value="">';

}

echo $properties;