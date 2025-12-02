<?php

require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');

// Validación y sanitización del parámetro 'id'
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Uso de una consulta preparada para evitar inyección SQL
    $query_rsInsert2 = "DELETE FROM `users_searchs` WHERE id = ?";
    $stmt = $inmoconn->prepare($query_rsInsert2);
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        
        // Verificación de la ejecución de la consulta
        if ($stmt->affected_rows > 0) {
            echo "Registro eliminado correctamente.";
        } else {
            echo "No se encontró ningún registro con ese ID.";
        }
        
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $inmoconn->error;
    }
} else {
    echo "ID inválido.";
}

// Cierre de la conexión
$inmoconn->close();
?>