<?php
if ($lang_adm == 'es') {
    return array(
        "new" => __("Nuevo", 1),
        "good" => __("Buena", 1),
        "toRestore" => __("Para restaurar", 1),
        // "rentToOwn" => __("Alquiler con opción a compra", 1),
    );
} else {

    if ($lang_adm == 'fr') {
        return array(
          "new" => __("Nouveau", 1),
          "good" => __("Bien", 1),
          "toRestore" => __("Restaurer", 1),
            // "rentToOwn" => __("Alquiler con opción a compra", 1),
        );
    }
    else
    {
        return array(
            "new" => __("New", 1),
            "good" => __("Good", 1),
            "toRestore" => __("to restore", 1),
            // "rentToOwn" => __("Rent to own", 1),
        );
    }

}
