<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');

// Verifica y valida los parámetros de entrada
if (isset($_GET['id']) && isset($_GET['s']) && is_numeric($_GET['id']) && is_numeric($_GET['s'])) {
    $id = (int) $_GET['id'];
    $send = (int) $_GET['s'];

    // Usa consultas preparadas para prevenir inyección SQL
    $stmt = $inmoconn->prepare("
        UPDATE `users_searchs` SET `send` = ? WHERE `id` = ?
    ");

    if ($stmt) {
        // Liga los parámetros y ejecuta la consulta
        $stmt->bind_param('ii', $send, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Registro actualizado correctamente.";
        } else {
            echo "No se actualizó ningún registro.";
        }

        // Cierra la sentencia
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $inmoconn->error;
    }
} else {
    echo "Parámetros inválidos.";
}

die;
?>
