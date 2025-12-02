<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/mediaelx/functions.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/common/KT_common.php');

require_once($_SERVER["DOCUMENT_ROOT"] . '/includes/tng/tNG.inc.php');

// Verifica y valida los parámetros de entrada
if (isset($_GET['u']) && isset($_GET['q'])) {
    $user = $_GET['u'];
    $query = $_GET['q'];

    // Validar y sanitizar la entrada
    $user = trim($user);
    $query = trim($query);

    // Usa consultas preparadas para prevenir inyección SQL
    $stmt = $inmoconn->prepare("
        INSERT INTO `users_searchs` (`user`, `query`, `send`, `created`) 
        VALUES (?, ?, '1', NOW())
    ");

    if ($stmt) {
        // Liga los parámetros y ejecuta la consulta
        $stmt->bind_param('ss', $user, $query);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Registro insertado correctamente.";
        } else {
            echo "No se insertó ningún registro.";
        }

        // Cierra la sentencia
        $stmt->close();
    } else {
        echo "Error en la preparación de la consulta: " . $inmoconn->error;
    }
} else {
    echo "Faltan parámetros de entrada.";
}

?>