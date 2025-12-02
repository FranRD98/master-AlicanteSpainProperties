<?php

$html = $email->message->html;

// fix para emails de Inmovilla
if (strpos($email->header->details->from[0]->personal, 'indomio.es') !== false) {
    $email->header->details->from[0]->host = 'indomio.es';
}

$providers = array('todopisosalicante.com', 'envios.ventadepisos.com', 'granmanzana.es', 'moveagain.co.uk', 'vivados.es', 'kyero.com', 'rightmove.co.uk', 'thinkspain.com', 'email.green-acres.com', 'idealista.com', 'costadelhome.com', 'zpg.co.uk'/*ZOOPLA*/, 'yaencontre.com', 'envios.habitaclia.com', 'trovimap.com', 'indomio.es', 'tucasa.com', 'todopisospain.com', 'messaging.fotocasa.es','fotocasa.es','listglobally.com'/*Properstar Concierge*/, 'broker.outbound.trovimap.com', 'pisos.com', 'aplaceinthesun.com');

$nombreCons = '';
$telefonoCons = '';
$emailCons = '';
$referenciaCons = '';
$linkCons = '';
$comentarioCons = '';
$idiomaCons = '';

if ($email->header->details->from[0]->host == 'todopisosalicante.com' || $email->header->details->from[0]->host == 'todopisospain.com') {
    if (strpos($email->header->details->subject, '¡Contacta ahora!') !== false) {
        $html = preg_replace('/\s+/', " ", trim($html));
        $nombreCons = get_string_between($html, '<b>Nombre:</b> ', '</p>');
        if ($nombreCons == '') {
            $nombreCons = get_string_between($html, 'Nombre: </strong><span>', '</span>');
        }
        $telefonoCons = get_string_between($html, '<p><b>Teléfono:</b> ', '</p>');
        if ($telefonoCons == '') {
            $telefonoCons = get_string_between($html, '<strong>Teléfono</strong>: ', '</p>');
        }
        $emailCons = get_string_between($html, '<p><b>Email:</b> ', '</p>');
        if ($emailCons == '') {
            $emailCons = get_string_between($html, 'Email</strong>: ', '</p>');
        }
        $referenciaCons = str_replace('LQB-', '', get_string_between($html, '<b>Referencia:</b> ', '</p>'));
        $linkCons = '';
        $comentarioCons = get_string_between($html, '<p><b>Mensaje:</b> ', '</p>');
        if ($comentarioCons == '') {
            $comentarioCons = get_string_between($html, 'Comentarios</strong>: ', '</p>');
        }
    } else if (strpos($email->header->details->subject, 'Formulario de contacto de TodopisosAlicante') !== false) {
        $nombreCons = get_string_between($html, '<b>Nombre:</b> ', '</p>');
        $telefonoCons = get_string_between($html, '<p><b>Teléfono:</b> ', '</p>');
        $emailCons = get_string_between($html, '<p><b>Email:</b> ', '</p>');
        $referenciaCons = str_replace('LQB-', '', get_string_between($html, '<b>Referencia:</b> ', '</p>'));
        $linkCons = '';
        $comentarioCons = get_string_between($html, '<p><b>Mensaje:</b> ', '</p>');
    } else if (strpos($email->header->details->subject, 'Consulta de teléfono desde Todo Pisos Alicante') !== false) {
        $nombreCons = get_string_between($html, '<p>Nombre: ', '</p>');
        $telefonoCons = get_string_between($html, '<p>Teléfono: ', '</p>');
        $emailCons = get_string_between($html, '<p>Email: ', '</p>');
        $referenciaCons = str_replace('LQB-', '', get_string_between($html, '<p>Referencia: ', '</p>'));
        $linkCons = get_string_between($html, '<p>Propiedad: <a href=\'', '\'');
        $comentarioCons = get_string_between($html, '<p>Comentario: ', '</p>');
    } else if (strpos($email->header->details->subject, 'Consulta de teléfono desde Todo Pisos Spain') !== false) {
        $nombreCons = get_string_between($html, '<p>Nombre: ', '</p>');
        $telefonoCons = get_string_between($html, '<p>Teléfono: ', '</p>');
        $emailCons = get_string_between($html, '<p>Email: ', '</p>');
        $referenciaCons = str_replace('LQB-', '', get_string_between($html, '<p>Referencia: ', '</p>'));
        $linkCons = get_string_between($html, '<p>Propiedad: <a href=\'', '\'');
        $comentarioCons = get_string_between($html, '<p>Comentario: ', '</p>');
    } else if (strpos($email->header->details->subject, 'Formulario de contacto de Todo Pisos Spain') !== false) {
        $nombreCons = get_string_between($html, '<b>Nombre:</b> ', '</p>');
        $telefonoCons = get_string_between($html, '<p><b>Teléfono:</b> ', '</p>');
        $emailCons = get_string_between($html, '<p><b>Email:</b> ', '</p>');
        $referenciaCons = str_replace('LQB-', '', get_string_between($html, '<b>Referencia:</b> ', '</p>'));
        $linkCons = '';
        $comentarioCons = get_string_between($html, '<p><b>Mensaje:</b> ', '</p>');
    } else {
        $nombreCons = get_string_between($html, '<p>Nombre: ', '</p>');
        $telefonoCons = get_string_between($html, '<p>Teléfono: ', '</p>');
        $emailCons = get_string_between($html, '<p>Email: ', '</p>');
        $referenciaCons = str_replace('LQB-', '', get_string_between($html, '<p>Ref: ', '</p>'));
        $linkCons = get_string_between($html, '<p>Link: <a href="', '">Ver Ficha</a></p>');
        $comentarioCons = get_string_between($html, '<p>Comentario: ', '</p>');
    }
}

if ($email->header->details->from[0]->host == 'envios.ventadepisos.com') {
    if (strpos($email->header->details->subject, 'Petición de información sobre tu vivienda') !== false) {
        $html = preg_replace('/\s+/', " ", trim($html));
        $nombreCons = get_string_between($html, '<b>Nombre:</b> ', '<br>');
        $telefonoCons = get_string_between($html, '<b>Teléfono:</b> ', '<br>');
        $emailCons = get_string_between($html, '<b>Email de contacto:</b> ', '<br>');
        $referenciaCons = get_string_between($html, '<b>Referencia de la vivienda:</b> ', '<br>');
        $linkCons = get_string_between($html, '<b>Enlace a la ficha:</b> <a href="', '">');
        $comentarioCons = get_string_between($html, '<b>Mensaje:</b> ', '</div>');
    } else {
        $nombreCons = get_string_between($html, '<b>Nombre:</b> ', '<br>');
        $telefonoCons = '';
        $email_content = getURL(get_string_between($html, '<b>Email:</b> <a href="', '" style="text-decoration: none; color: #006AA9;;"'));
        $emailCons = get_string_between($email_content, '<i class="fa fa-envelope-o"></i> <strong>', '</strong>');
        $referenciaCons = get_string_between($html, '<b>Referencia de la vivienda:</b> ', '<br>');
        $linkCons = get_string_between($html, '" style="color:#006AA9;">', '</a>');
        $comentarioCons = get_string_between($html, '<b>Mensaje:</b> ', '</div>');
    }
}

if ($email->header->details->from[0]->host == 'granmanzana.es') {
    $nombreCons = get_string_between($html, '<span style=\'font-weight: bold; color: #444444; white-space: nowrap;\'>', ' </span>');
    $telefonoCons = '';
    $email_content = getURL(get_string_between($html, '<b>Email:</b> <a href="', '" style="text-decoration: none; color: #006AA9;;"'));
    $emailCons = $email->header->details->reply_to[0]->mailbox . '@' . $email->header->details->reply_to[0]->host;
    $referenciaCons = get_string_between($html, '<strong>Ref: </strong>', '</p>');
    $linkCons = get_string_between($html, ' interesado en su anuncio <a href=\'', '\'>');
    $comentarioCons = get_string_between($html, '<span style=\'display:none\'>--mensajesGM--</span>"', '"<span style=\'display:none\'>--mensajesGM--</span>');
}

if ($email->header->details->from[0]->host == 'moveagain.co.uk') {
    $nombreCons = get_string_between($html, '<br /> From: ', '</p>');
    $telefonoCons = get_string_between($html, 'Phone: ', '<br />');
    $emailCons = get_string_between($html, 'Email: ', '</p>');
    $referenciaCons = get_string_between($html, 'iry: <span> <strong> ', ' -  </strong>');
    $linkCons = get_string_between($html, '');
    $comentarioCons = get_string_between($html, 'Message: <br /> ', '</p>');
}

if ($email->header->details->from[0]->host == 'rightmove.co.uk') {
    $html = preg_replace('/\s+/', " ", trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, "Name:</strong> </font></td> <td> <font face='arial' size='2'>", '</font>');
    $telefonoCons = get_string_between($html, "Phone:</strong> </font></td> <td> <font face='arial' size='2'>", '</font>');
    $emailCons = get_string_between($html, "Email:</strong> </font></td> <td> <font face='arial' size='2'>", '</font>');
    $referenciaCons = str_replace(array($rightmoveBranchId, '__'), '', get_string_between($html, "Reference:</font></td> <td><font face='arial' size='2'><strong>", '</strong>'));
    $linkCons = get_string_between($html, '</tr> <tr> <td colspan="2"><font face=\'arial\' size=\'2\'><a href="', '" target="_blank">See this property');
    $comentarioCons = get_string_between($html, "Comments</strong> </font></td> </tr> <tr> <td style='background-color: #EEEEEE;'> <font face='arial' size='2'>", '</font>');
}

if ($email->header->details->from[0]->host == 'thinkspain.com') {
    $html = preg_replace('/\s+/', " ", trim($html));
    // echo htmlentities($html);
    if ( strpos($email->header->details->subject, 'Property enquiry Site Reference') !== false) {
        $nombreCons = get_string_between($html, "Name: ", '<br>');
        $telefonoCons = get_string_between($html, "Telephone: ", '<br>');
        $emailCons = get_string_between($html, "Email: ", '<br>');
        if ($emailCons == '') {
            $emailCons = get_string_between($html, "E-mail: ", '<br>');
        }
        $referenciaCons = get_string_between($html, "Your Reference ", ')');
        $linkCons = get_string_between($html, 'Link: <a href="', '"');
        $comentarioCons = get_string_between($html, "Message:<br>", '<br><br>');
        $idiomaCons = get_string_between($html, 'Website Language: ', '<br>');
    } else if ( strpos($email->header->details->subject, 'Similar Property Search Enquiry') !== false) {
        $nombreCons = get_string_between($html, "Name: ", '<br>');
        $telefonoCons = get_string_between($html, "Telephone: ", '<br>');
        $emailCons = get_string_between($html, "E-mail: ", '<br>');
        $referenciaCons = get_string_between($html, "Your Reference: ", '<br>');
        $linkCons = get_string_between($html, 'Property Reference: <a href="', '"');
        $comentarioCons = get_string_between($html, "Message:<br>", '<br><br>');
        $idiomaCons = get_string_between($html, 'LANGUAGE: <strong>', ' : ');
    } else if ( strpos($email->header->details->subject, 'Busqueda de Propiedad Similar') !== false) {
        $nombreCons = get_string_between($html, "Nombre: ", '<br>');
        $telefonoCons = get_string_between($html, "Teléfono: ", '<br>');
        $emailCons = get_string_between($html, "E-mail: ", '<br>');
        $referenciaCons = get_string_between($html, "Su Referencia: ", '<br>');
        $linkCons = get_string_between($html, 'Propiedad: <a href="', '"');
        $comentarioCons = get_string_between($html, "Message:<br>", '<br><br>');
        $idiomaCons = get_string_between($html, 'IDIOMA: <strong>', ' : ');
    } else if ( strpos($email->header->details->subject, 'Bitte um Information bezüglich des Objekts') !== false) {
        $nombreCons = get_string_between($html, "Name: ", '<br>');
        $telefonoCons = get_string_between($html, "Telefon: ", '<br>');
        $emailCons = get_string_between($html, "E-mail: ", '<br>');
        $referenciaCons = get_string_between($html, "Ihre Referenz ", ')');
        $linkCons = get_string_between($html, 'Link: <a href="', '"');
        $comentarioCons = get_string_between($html, "Nachricht:<br>", '<br><br>');
        $idiomaCons = get_string_between($html, 'SPRACHE: <strong>', ' : ');
    } else if ( strpos($email->header->details->subject, 'Suche nach gleichwertigen Objekten') !== false) {
        $nombreCons = get_string_between($html, "Name: ", '<br>');
        $telefonoCons = get_string_between($html, "Telefon: ", '<br>');
        $emailCons = get_string_between($html, "E-mail: ", '<br>');
        $referenciaCons = get_string_between($html, 'Ihre Referenz: ', '<br>');
        $linkCons = get_string_between($html, 'Objekt referenz: <a href="', '"');
        $comentarioCons = get_string_between($html, "Nachricht:<br>", '<br><br>');
        $idiomaCons = get_string_between($html, 'SPRACHE: <strong>', ' : ');
    } else if ( strpos($email->header->details->subject, 'Solicitud de informacion sobre propiedad') !== false) {
        $nombreCons = get_string_between($html, "Nombre: ", '<br>');
        $telefonoCons = get_string_between($html, "Teléfono: ", '<br>');
        $emailCons = get_string_between($html, "E-mail: ", '<br>');
        $referenciaCons = get_string_between($html, "Su referencia ", ')');
        $linkCons = get_string_between($html, 'Enlace: <a href="', '"');
        $comentarioCons = get_string_between($html, "Mensaje:<br>", '<br><br>');
        $idiomaCons = get_string_between($html, 'IDIOMA: <strong>', ' : ');
    } else {
        $nombreCons = get_string_between($html, "Name: ", '<br>');
        $telefonoCons = get_string_between($html, "Telephone: ", '<br>');
        $emailCons = get_string_between($html, "Email: ", '<br>');
        $referenciaCons = get_string_between($html, "Property Ref. ", ' -');
        $linkCons = get_string_between($html, ' - ', '<br><br>');
        $comentarioCons = get_string_between($html, "A ", ':');
    }
}

if ($email->header->details->from[0]->host == 'vivados.es') {
    $html = str_replace('<td colspan="1">', '', $html);
    $html = str_replace('<td colspan="2">', '', $html);
    if (strpos($email->header->details->subject, 'Nuevo contacto en vivados') !== false) {
        $nombreCons = get_string_between($html, ' Nombre:</td>', '</td>');
        $telefonoCons = get_string_between($html, 'Telefono:</td>', '</td>');
        $emailCons = get_string_between($html, '<a href="mailto:', '">');
        $referenciaCons = get_string_between($html, 'Referencia:', '<a');
        $linkCons = get_string_between($html, '<a href="', '">');
        $comentarioCons = get_string_between($html, 'Mensaje:</td>', '</td>');
    }
}

if ($email->header->details->from[0]->host == 'kyero.com') {
    $html = preg_replace('/\s+/', " ", trim($html));
    if ( strpos($email->header->details->subject, 'Enquiry about property ref') !== false) {
        $nombreCons = get_string_between($html, "Name: </strong>", '<br>');
        $telefonoCons = get_string_between($html, 'Telephone: </strong>', '<br>');
        $emailCons = get_string_between($html, 'Email: </strong>', '<br>');
        $referenciaCons = get_string_between($html, 'reference: <strong>', '</strong>');
        $referenciaCons = strip_tags($referenciaCons);
        $linkCons = get_string_between($html, 'reference: <strong><a href="', '">');
        $comentarioCons = get_string_between($html, 'Message: </strong>', '</p>');
        $idiomaCons = get_string_between($html, 'Language: </strong>', '<br>');
    } elseif ( strpos($email->header->details->subject, 'Kyero.com: Priority enquiry about property') !== false) {
        $nombreCons = get_string_between($html, "Name:</strong>", '<br>');
        $telefonoCons = get_string_between($html, 'Telephone:</strong>', '<br>');
        $emailCons = get_string_between($html, 'Email: </strong>', '<br>');
        $referenciaCons = get_string_between($html, 'reference: <strong>', '</strong>');
        $referenciaCons = strip_tags($referenciaCons);
        $linkCons = get_string_between($html, 'reference: <strong><a href="', '">');
        $comentarioCons = get_string_between($html, 'Message: </strong>', '</p>');
        $idiomaCons = get_string_between($html, 'Language: </strong>', '<br>');
    } elseif ( strpos($email->header->details->subject, 'Kyero.com: Remote viewing request for property ref') !== false) {
        $nombreCons = get_string_between($html, "Name: </strong>", '<br>');
        $telefonoCons = get_string_between($html, 'Telephone: </strong>', '<br>');
        $emailCons = get_string_between($html, 'Email: </strong>', '<br>');
        $referenciaCons = get_string_between($html, 'reference: <strong>', '</strong>');
        $referenciaCons = strip_tags($referenciaCons);
        $linkCons = get_string_between($html, 'reference: <strong><a href="', '">');
        $comentarioCons = get_string_between($html, 'Message: </strong>', '</p>');
        $idiomaCons = get_string_between($html, 'Language: </strong>', '<br>');
    } else {
        $nombreCons = get_string_between($html, "Nombre: </strong>", '</li>');
        $telefonoCons = get_string_between($html, 'Teléfono: </strong>', '</li>');
        $emailCons = get_string_between($html, 'Email: </strong>', '</li>');
        $referenciaCons = get_string_between($html, 'referencia: <strong>', '</strong>');
        $referenciaCons = strip_tags($referenciaCons);
        $linkCons = get_string_between($html, 'referencia: <strong><a href="', '">');
        $comentarioCons = get_string_between($html, 'Mensaje: </strong>', '</li>');
        $idiomaCons = get_string_between($html, 'Idioma: </strong>', '</li>');
    }
}

if ($email->header->details->from[0]->host == 'email.green-acres.com') {
    $html = preg_replace('/\s+/', " ", trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, "Contact name</td> <td class=\"data-value\" style=\"text-align: left;padding: 10px;background-color: #ffffff;\">", '</td>');
    $telefonoCons = get_string_between($html, 'Phone</td> <td style="text-align: left;padding: 10px;background-color: #ffffff;">', '</td>');
    $emailCons = get_string_between($html, 'E-mail</td> <td class="data-value" style="text-align: left;padding: 10px;background-color: #ffffff;">', '</td>');
    $referenciaCons = str_replace('43453a-', '', get_string_between($html, 'R&#233;f. ', '</td>'));
    $referenciaCons = strip_tags($referenciaCons);
    $linkCons = get_string_between($html, 'has seen your property <a href=\'', '\'>');
    $comentarioCons = get_string_between($html, 'Message</td> <td class="data-value" style="text-align: left;padding: 10px;background-color: #ffffff;">', '</td>');
    $idiomaCons = get_string_between($html, 'Idioma: </strong>', '</li>');

}if ($email->header->details->from[0]->host == 'idealista.com') {
    $html = preg_replace('/\s+/', " ", trim($html));
    $subject = preg_replace('/\s+/', " ", trim($email->header->details->subject));
    // echo htmlentities($html);
    if (strpos($html, 'Tienes una oferta sobre uno de tus inmuebles') !== false) {
        $nombreCons = get_string_between($html, '-break:break-word;"><div style="font-family:Arial;font-size:16px;font-weight:700;line-height:24px;text-align:center;color:#141414;">', '</div>');
        $telefonoCons = get_string_between($html, 'href="tel:', '"');
        $emailCons = get_string_between($html, 'href="mailto:', '"');
        $referenciaCons = get_string_between($html, '(Ref.', ')');
        $linkCons = get_string_between($html, '/mj-raw><div style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><a style="font-size: 16px; color: #0066cc; text-decoration:none !important" href=', '">');
        $comentarioCons = get_string_between($html, 'reak-word;"><div style="font-family:Arial;font-size:15px;font-weight:700;line-height:24px;text-align:left;color:#000000;">', '</div>');
    } elseif (strpos($subject, 'Nueva oferta de') !== false) {
        $nombreCons = get_string_between($html, 'Nuevo mensaje de ', '</p>');
        $telefonoCons = get_string_between($html, '<a href="tel:', '"');
        $emailCons = get_string_between($html, 'href="mailto:', '"');
        $referenciaCons = get_string_between($html, '(Ref. ', ')</span>');
        $linkCons = get_string_between($html, 'eft: 10px; color: #474744;" valign="top"> <a style="color: #0066CC;text-decoration: none !important;" href="', '">');
        $comentarioCons = get_string_between($html, '<h4 style="margin-top: 0px;margin-bottom:10px;">"', '"</h4>');
    } elseif (strpos($html, 'Tienes un nuevo mensaje que espera tu respuesta') !== false) {
        $nombreCons = get_string_between($html, 'g:0;word-break:break-word;"><div style="font-family:Arial;font-size:16px;font-weight:700;line-height:24px;text-align:center;color:#141414;">', '</div>');
        $telefonoCons = get_string_between($html, 'coration:none !important" href="tel:', '"');
        $emailCons = get_string_between($html, 'href="mailto:', '"');
        $referenciaCons = get_string_between($html, '(Ref.', ')');
        $linkCons = get_string_between($html, '/mj-raw><div style="overflow: hidden; white-space: nowrap; text-overflow: ellipsis;"><a style="font-size: 16px; color: #0066cc; text-decoration:none !important" href=', '">');
        $comentarioCons = get_string_between($html, 'reak-word;"><div style="font-family:Arial;font-size:15px;font-weight:700;line-height:24px;text-align:left;color:#000000;">', '</div>');
    } elseif (strpos($html, 'Hay un nuevo mensaje de') !== false) {
        $nombreCons = get_string_between($html, 'border-collapse: collapse; text-align: left; font: normal 18px Arial, sans-serif; width: 100%; line-height: 26px; color: #141414; padding-bottom: 18px; padding-top:12px;"> <span style="font-weight:700;font-size:14px;line-height:22px;">', '</span>');
        $telefonoCons = get_string_between($html, '<a style="font-weight:400;font-size:14px;line-height:22px;" href="tel:', '"');
        $emailCons = get_string_between($html, 'ze:14px;line-height:22px;" href="mailto:', '?');
        $referenciaCons = get_string_between($html, '(Ref.', ')');
        $linkCons = get_string_between($html, ' <a style="color: #145BC7; text-decoration: none; line-height: normal;font-weight:400;font-size:16px;line-height:28px;" href="', '">');
        $comentarioCons = get_string_between($html, 'ground-color:#F4F5F2;padding:20px;border: 1px solid #CBCCC7"> ', '</div>');
    } elseif (strpos($subject, 'Nuevo mensaje de') !== false) {
        $nombreCons = get_string_between($html, 'Nuevo mensaje de ', '</p>');
        $telefonoCons = get_string_between($html, '<a href="tel:', '"');
        $emailCons = get_string_between($html, 'href="mailto:', '"');
        $referenciaCons = get_string_between($html, '(Ref. ', ')</span>');
        $linkCons = get_string_between($html, 'eft: 10px; color: #474744;" valign="top"> <a style="color: #0066CC;text-decoration: none !important;" href="', '">');
        $comentarioCons = get_string_between($html, '<h4 style="margin-top: 0px;margin-bottom:10px;">"', '"</h4>');
} elseif (!strpos($html, '<img height="40" width="40" style="border-radius:50%;vertical-align: top;" src="https://st1.idealista.com') !== false) {
        $nombreCons = get_string_between($html, 'padding-bottom: 18px; padding-top:12px;">', '<br>');
        $telefonoCons = get_string_between($html, '<a href="tel:', '"');
        $emailCons = get_string_between($html, '<a href="###" style="color: #145BC7; text-decoration: none; line-height: normal;">', '</');
        $referenciaCons = get_string_between($html, '(Ref. ', ')</span>');
        $linkCons = get_string_between($html, '<a style="color: #145BC7; text-decoration: none; line-height: normal;" href="', '">');
        $comentarioCons = get_string_between($html, 'ground-color:#F4F5F2;padding:20px;border: 1px solid #CBCCC7"> ', '</div>');
    }  else {
        $nombreCons = get_string_between($html, "<p style=\"margin:0;color:#474744;\"> <strong>", '</strong>');
        $telefonoCons = get_string_between($html, '<a href="tel:', '"');
        $emailCons = get_string_between($html, ' href="mailto:', '"');
        $referenciaCons = get_string_between($html, '(Ref. ', '</span>');
        $linkCons = get_string_between($html, 'decoration: none !important;" href="', '">');
        $comentarioCons = get_string_between($html, '<div style="font-size:18px;background-color:white;display:inline-block;margin-top:0;padding: 10px;"> ', '</div>');
    }
}

if ($email->header->details->from[0]->host == 'costadelhome.com') {
    $html = preg_replace('/\s+/', " ", trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, "Name: </td> <td class=\"value\" style='font-family: \"Helvetica Neue\", Helvetica, Arial, sans-serif; font-size: 13px; color: #151515; padding: 0 20px 15px 0;' valign=\"top\"> ", ' </td>');
    $telefonoCons = get_string_between($html, 'Phone: </td> <td class="value" style=\'font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 13px; color: #151515; padding: 0 20px 15px 0;\' valign="top"> ', ' </td>');
    $emailCons = get_string_between($html, 'Email: </td> <td class="value" style=\'font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 13px; color: #151515; padding: 0 20px 15px 0;\' valign="top"> ', ' </td>');
    $referenciaCons = get_string_between($html, 'style="color: #0088CC; text-decoration: underline;">', '</a>');
    $linkCons = get_string_between($html, 'reference: <a target="_blank" href="', '"');
    $comentarioCons = get_string_between($html, 'Message: </td> <td class="value message" style=\'font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 13px; color: #151515; padding: 0 20px 7px 0;\' valign="top"> <p style="line-height: 1.5; color: #151515; margin: 0 0 8px;">', '</p> </td>');
    $idiomaCons = get_string_between($html, 'Language: </td> <td class="value" style=\'font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; font-size: 13px; color: #151515; padding: 0 20px 15px 0;\' valign="top"> ', ' </td>');
}

if ($email->header->details->from[0]->host == 'zpg.co.uk') {
    $html = preg_replace('/\s+/', " ", trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, 'Name:</td> <td width="10" align="center" valign="middle" class="emailnomob"><img style="DISPLAY: block" alt="" src="https://m.zoocdn.com/www/_b/static/images/spacer-3254726015.gif" width="10" height="8" /></td> <td align="left" valign="middle" style="FONT-FAMILY: Arial, Helvetica, sans-serif; COLOR: #6a148e; FONT-SIZE: 20px; line-height: 22px; font-weight:bold;" class="emailcolsplit "> ', '</td>');
    $telefonoCons = get_string_between($html, 'Telephone:</td> <td width="10" align="center" valign="middle" class="emailnomob"><img style="DISPLAY: block" alt="" src="https://m.zoocdn.com/www/_b/static/images/spacer-3254726015.gif" width="10" height="8" /></td> <td align="left" valign="middle" style="FONT-FAMILY: Arial, Helvetica, sans-serif; COLOR: #6a148e; FONT-SIZE: 20px; line-height: 22px; font-weight:bold;" class="emailcolsplit ">', ' </td>');
    $emailCons = get_string_between($html, 'Email:</td> <td width="10" align="center" valign="middle" class="emailnomob"><img style="DISPLAY: block" alt="" src="https://m.zoocdn.com/www/_b/static/images/spacer-3254726015.gif" width="10" height="8" /></td> <td align="left" valign="middle" style="FONT-FAMILY: Arial, Helvetica, sans-serif; COLOR: #6a148e; FONT-SIZE: 20px; line-height: 22px; font-weight:bold;" class="emailcolsplit "> ', '</td>');
    $referenciaCons = get_string_between($html, 'Your property ref:</td> <td width="10" align="center" valign="middle" class="emailnomob"><img style="DISPLAY: block" alt="" src="https://m.zoocdn.com/www/_b/static/images/spacer-3254726015.gif" width="10" height="8" /></td> <td align="left" valign="middle" style="FONT-FAMILY: Arial, Helvetica, sans-serif; COLOR: #6a148e; FONT-SIZE: 20px; line-height: 22px; font-weight:bold;" class="emailcolsplit ">', '</td>');
    $linkCons = get_string_between($html, 'class="resize32"><a target="_blank" href="', '"><img');
    $comentarioCons = get_string_between($html, 'Message:</td> </tr> <tr> <td height="1" style="LINE-HEIGHT: 1px; FONT-SIZE: 1px"><img height="8" alt="" src="https://m.zoocdn.com/www/_b/static/images/spacer-3254726015.gif" style="DISPLAY: block" width="1"> </td> </tr> <tr> <td align="left" class="emailleft" style="white-space: pre-line; FONT-FAMILY: Arial, Helvetica, sans-serif; COLOR: #58585a; FONT-SIZE: 15px; line-height: 22px;" valign="top">', '</td>');
}

if ($email->header->details->from[0]->host == 'yaencontre.com') {
    $html = preg_replace('/\s+/', " ", trim($html));
    $subject = preg_replace('/\s+/', " ", trim($email->header->details->subject));
    // echo htmlentities($html);
    if (strpos($subject, 'Aviso de contacto recomendado ') !== false) {
        $nombreCons = get_string_between($html, "<b>Nombre:</b>", '</p>');
        $telefonoCons = get_string_between($html, '<a href="tel://', '"');
        $emailCons = get_string_between($html, '<b>E-mail:</b> ', ' </p> <p>');
        $referenciaCons = get_string_between($html, '/inmueble-', '"');
        $linkCons = get_string_between($html, '<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;"> <a href="', '"');
        $comentarioCons = get_string_between($html, '<b>Comentarios:</b> ', '</p> </table> ');
    } else {
        $nombreCons = get_string_between($html, "<b>Nombre:</b> ", ' </p> <p>');
        $telefonoCons = get_string_between($html, 'target="_blank" style="color:#4a83fb; font-size: 14px; font-family: Arial,Helvetica,sans-serif; text-decoration: none;"> ', ' </a> </p>');
        $emailCons = get_string_between($html, '<b>E-mail:</b> ', ' </p> <p>');
        $referenciaCons = get_string_between($html, '/inmueble-', '"');
        $linkCons = get_string_between($html, 'referencia <a style= "color:#4a83fb" href="', '"> ');
        $comentarioCons = get_string_between($html, '<b>Comentarios:</b> ', '</p> </table> ');
    }
}

if ($email->header->details->from[0]->host == 'envios.habitaclia.com') {
    $html = preg_replace('/\s+/', " ", trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, '<span style="font-weight:bold; font-size: 16px; color: #555555;">', '</span></td>');
    $telefonoCons = get_string_between($html, '<a href="tel:', '" target="_blank" ');
    $emailCons = get_string_between($html, '<a href="mailto:', '?subject=');
    $referenciaCons = get_string_between($html, 'anuncio con Ref ', '<img borde');
    $linkCons = get_string_between($html, '<tbody> <tr> <td style="margin-bottom:5px"> <a href="', '"');
    $comentarioCons = get_string_between($html, 'Mensaje:</strong><br /> ', '</span> </td> </tr>');
}

if ($email->header->details->from[0]->host == 'trovimap.com') {
    $html = preg_replace('/\s+/', " ", trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, '<strong>Nombre:</strong>', '<br>');
    $telefonoCons = get_string_between($html, '<strong>Teléfono contacto:&nbsp;</strong>', '<br>');
    $emailCons = get_string_between($html, '<strong>Email:</strong>', '<br>');
    $referenciaCons = get_string_between($html, '<strong>Referencia:</strong>', '<br>');
    $linkCons = get_string_between($html, '<tbody> <tr> <td> <a href="', '"');
    $comentarioCons = get_string_between($html, '<strong>Comentarios</strong>: <span style="color: #666666;line-height: normal;">', '</span>');
}

if ($email->header->details->from[0]->host == 'indomio.es') {
    $html = preg_replace('/\s+/', " ", trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, 'Nombre: </span> <!--[if gte mso 9]> </td> <td width="320" style="border-collapse: collapse;line-height: 100%;"> <![endif]--> <b class="style-autolink" style="color: #333333; min-width: 180px; float: left; display: inline-block; line-height: 20px; max-width: 320px; text-decoration: none;">', '</b>');
    $telefonoCons = get_string_between($html, 'Teléfono: </span> <!--[if gte mso 9]> </td> <td width="320" style="border-collapse: collapse;line-height: 100%;"> <![endif]--> <b class="style-autolink" style="color: #333333; min-width: 180px; float: left; display: inline-block; line-height: 20px; max-width: 320px; text-decoration: none;">', '</b>');
    $emailCons = get_string_between($html, 'Correo electrónico: </span> <!--[if gte mso 9]> </td> <td width="320" style="border-collapse: collapse;line-height: 100%;"> <![endif]--> <b class="style-autolink" style="color: #333333; min-width: 180px; float: left; display: inline-block; line-height: 20px; max-width: 320px; text-decoration: none;"> <a style=\'color:#216A95; text-decoration: none;\' href=\'mailto:', '\'');
    $referenciaCons = get_string_between($html, '<strong>Referencia:</strong>', '<br>');
    $linkCons = get_string_between($html, 'Vedi dettagli annuncio" href="', '"');
    $comentarioCons = get_string_between($html, 'Mensaje: </span> <!--[if gte mso 9]> </td> <td width="320" style="border-collapse: collapse;line-height: 100%;"> <![endif]--> <b class="style-autolink" style="color: #333333; min-width: 180px; float: left; display: inline-block; line-height: 20px; max-width: 320px; text-decoration: none;">', '</b>');
}

if ($email->header->details->from[0]->host == 'tucasa.com') {
    $html = preg_replace('/\s+/', " ", trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, '- Nombre</span>: ', '<br/>');
    $telefonoCons = get_string_between($html, '- Telefono</span>: ', '<br/>');
    $emailCons = get_string_between($html, '- Email</span>: ', '<br/>');
    $referenciaCons = get_string_between($html, 'Referencia del inmueble</span>: ', '<br/>');
    $linkCons = get_string_between($html, '<a style="text-decoration: none; color: #0073D0; cursor:pointer;" href="', '"');
    $comentarioCons = get_string_between($html, '- Comentario</span>: ', '</p>');
}

if ($email->header->details->from[0]->host == 'messaging.fotocasa.es' || $email->header->details->from[0]->host == 'fotocasa.es') {
    $html = preg_replace('/\s+/', " ", trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, 'Nombre:</span>&nbsp;<mj-raw>', '</mj-raw');
    $telefonoCons = get_string_between($html, 'Telf:</span>&nbsp;<mj-raw>', '</mj-raw');
    $emailCons = get_string_between($html, 'Email:</span> ', '</div');
    $referenciaCons = get_string_between($html, '&nbsp;(', ')');
    $linkCons = get_string_between($html, 'le interesa tu anuncio <a href="', '"');
    $comentarioCons = get_string_between($html, 'Mensaje:</span> <span style="font-style:italic"><mj-raw>"', '"</mj-raw>');
}

if ($email->header->details->from[0]->host == 'listglobally.com') {
    $html = preg_replace('/\s+/', " ", trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, 'font-size:16px;font-weight:400;line-height:18px;text-align:left;color:#353535;"> ', ' </div> </td> </tr>');
    $telefonoCons = get_string_between($html, 'size:13px;font-weight:400;line-height:18px;text-align:left;color:#8D8D8D;"> +', ' </div> </td> </tr>');
    $telefonoCons = '+' . $telefonoCons;
    $emailCons = get_string_between($html, 'nt-size:13px;font-weight:400;line-height:18px;text-align:left;color:#8D8D8D;"> ', ' </div> </td> </tr>');
    $referenciaCons = get_string_between($html, 'Reference: ', '</p>');
    $linkCons = get_string_between($html, 'le interesa tu anuncio <a href="', '"');
    $comentarioCons = get_string_between($html, '-serif;font-size:16px;font-weight:400;line-height:24px;text-align:left;color:#353535;"> ', '</div> </td>');
}

if ($email->header->details->from[0]->host == 'broker.outbound.trovimap.com') {
    $html = preg_replace('/\s+/', " ", trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, '<strong>Nombre:</strong> ', '<br>');
    $telefonoCons = get_string_between($html, 'size:13px;font-weight:400;line-height:18px;text-align:left;color:#8D8D8D;"> +', ' </div> </td> </tr>');
    $emailCons = get_string_between($html, 'nt-size:13px;font-weight:400;line-height:18px;text-align:left;color:#8D8D8D;"> ', ' </div> </td> </tr>');
    $referenciaCons = get_string_between($html, '<strong>Referencia:</strong> ', '<br>');
    $linkCons = get_string_between($html, 'Tu anuncio en Trovimap.com: </span> </div> </td> </tr> <tr> <td> <table height="10" cellspacing="0" cellpadding="0" border="0"> <tbody> <tr> <td height="10"></td> </tr> </tbody> </table> </td> </tr> <tr> <td width="560"> <table border="0" cellpadding="0" cellspacing="0"> <tbody> <tr> <td> <a href="', '"');
    $comentarioCons = get_string_between($html, '<strong>Comentarios</strong>: <span style="color: #666666;line-height: normal;">', '.</span>');
}

if ($email->header->details->from[0]->host == 'pisos.com') {
    $html = preg_replace('/\s+/', " ", trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, 'Nombre</b></td> <td style="text-align:left;">', '</td>');
    $telefonoCons = get_string_between($html, 'Teléfono</b></td> <td style="text-align:left;">', '</td>');
    $emailCons = get_string_between($html, '</td> <td style="text-align:left;"> <a href="mailto:', '"');
    $referenciaCons = get_string_between($html, 'Referencia: ', ' </td>');
    $linkCons = get_string_between($html, 'Una persona está interesada en tu <a href="', '"');
    $comentarioCons = get_string_between($html, 'Comentarios</b></td> <td style="text-align:left;">', '</td>');
}

if ($email->header->details->from[0]->host == 'aplaceinthesun.com') {
    $html = preg_replace('/\s+/', " ", trim($html));
    // echo htmlentities($html);
    $nombreCons = get_string_between($html, 'Name:</td> <td width="529" bgcolor="#FFFFFF" style="font-family: Arial, Georgia, \'Times New Roman\', Times, serif; font-size: 12px; color: #000;">', '</td>');
    $telefonoCons = get_string_between($html, 'Telephone:</td> <td bgcolor="#FFFFFF" style="font-family: Arial, Georgia, \'Times New Roman\', Times, serif; font-size: 12px; color: #000;">', '</td>');
    $emailCons = get_string_between($html, '<a style=\'color:#00008B;\' href="mailto:', '"');
    $referenciaCons = get_string_between($html, 'Your Reference:</strong></td> <td bgcolor="#FFFFFF" style="font-family: Arial, Georgia, \'Times New Roman\', Times, serif; font-size: 12px; color: #000;">', '</td>');
    $linkCons = get_string_between($html, 'View Property:</strong></td> <td bgcolor="#FFFFFF" style="font-family: Arial, Georgia, \'Times New Roman\', Times, serif; font-size: 12px; color: #000;"><a href="', '"');
    $comentarioCons = get_string_between($html, 'Comments:</td> <td bgcolor="#FFFFFF" style="font-family: Arial, Georgia, \'Times New Roman\', Times, serif; font-size: 12px; color: #000;">', '</td>');
}

$nombreCons = trim($nombreCons);
$telefonoCons = trim($telefonoCons);
$emailCons = trim($emailCons);
$referenciaCons = trim($referenciaCons);
$linkCons = trim($linkCons);
$comentarioCons = trim($comentarioCons);
$idiomaCons = trim($idiomaCons);

// if ($_SERVER['REMOTE_ADDR']  == '31.44.151.188') {
//     $html = preg_replace('/\s+/', " ", trim($html));
//     echo htmlentities($html);
//     echo "<hr><div class=\"text-left\">";
//     echo 'Nombre: ' . $nombreCons . '<br>';
//     echo 'Telefono: ' . $telefonoCons . '<br>';
//     echo 'Email: ' . $emailCons . '<br>';
//     echo 'Referencia: ' . $referenciaCons . '<br>';
//     echo 'Link: ' . $linkCons . '<br>';
//     echo 'Comentario: ' . $comentarioCons . '<br>';
//     echo 'Idioma: ' . $idiomaCons . '<br>';
//     echo "</div><hr>";
// }
?>
