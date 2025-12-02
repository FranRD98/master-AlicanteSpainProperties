<?php

require_once  $_SERVER["DOCUMENT_ROOT"] . "/intramedianet/email/_inc.parse_providers.php";

$query_rsClients = "SELECT * FROM properties_client WHERE email_cli = '$emailCons'";
$rsClients = mysqli_query($inmoconn,$query_rsClients) or die(mysqli_error());
$row_rsClients = mysqli_fetch_assoc($rsClients);
$totalRows_rsClients = mysqli_num_rows($rsClients);

?>

<div class="email-content">
    <div class="p-4 pb-0">
        <div class="row align-items-end mt-n1 mb-2 me-n4">
            <div class="col">
                <div class="card me-n2">
                    <div class="card-body bg-light">
                        <div class="float-end">
                            <button type="button" class="btn btn-soft-info btn-sm" data-bs-toggle="modal" data-bs-target="#moveModal" data-mail-id="<?php echo $_GET['id2']; ?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="<?php __('Mover'); ?>">
                                <i class="fa-regular fa-folder"></i>
                            </button>
                            <button type="button" class="btn btn-soft-danger btn-sm btn-delete-mail" data-mail-id="<?php echo $_GET['id2']; ?>" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="<?php __('Eliminar'); ?>">
                                <i class="fa-regular fa-trash-can"></i>
                            </button>
                            <a href="<?php echo urldecode($_GET['from']) ?>" class="btn btn-soft-primary btn-sm" aria-hidden="true" data-toggle="tooltip" data-placement="bottom" title="<?php __('Volver'); ?>">
                                <i class="fa-regular fa-arrow-left" aria-hidden="true"></i>
                            </a>
                        </div>
                        <b><?php __('De'); ?>:</b> <span class="text-capitalize"><?php echo $email->header->details->from[0]->personal ?></span> - <span class="text-lowercase"><?php echo $email->header->details->from[0]->mailbox ?>@<?php echo $email->header->details->from[0]->host ?></span>
                        <br>
                        <b><?php __('Destinatario'); ?>:</b> <span class="text-lowercase"><?php echo $email->header->to ?></span>
                        <br>
                        <b><?php __('Fecha'); ?>:</b> <span class="text-capitalize"><?php echo iconv("ISO-8859-1", "UTF-8", ucwords(strftime("%A, %d %B %Y %H:%M", strtotime($email->header->date)))) ?></span>
                        <br><b><?php echo $email->header->details->subject ?></b>
                    </div>
                </div>
            </div>
            <div class="col-auto pb-2">
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="pills-primary" role="tabpanel" aria-labelledby="pills-primary-tab">
                <div class="message-list-content mx-n4 px-4 message-list-scroll" data-simplebar="init">
                    <div class="simplebar-wrapper" style="margin: 0px -24px;">
                        <div class="simplebar-height-auto-observer-wrapper">
                            <div class="simplebar-height-auto-observer"></div>
                        </div>
                        <div class="simplebar-mask" style="overflow-y: auto !important;">
                            <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                <div class="simplebar-content-wrapper" tabindex="0" role="region" aria-label="scrollable content" style="height: 100%;">

                                    <div class="px-4 pb-0">

                                        <?php if ($emailCons != ''): ?>
                                            <?php if (in_array($email->header->details->from[0]->host, $providers)): ?>
                                                <?php if ($totalRows_rsClients == 0): ?>
                                                    <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                                        <i class="fa-regular fa-check label-icon"></i> <?php __('Este cliente no existe en nuestra base de datos'); ?>
                                                        <form action="add-client.php" id="add-client" method="post" class="pull-right" target="_blank">
                                                            <input type="text" name="date" value="<?php echo $email->header->date ?>" style="display: none !important;">
                                                            <input type="text" name="provider" value="<?php echo $email->header->details->from[0]->host ?>" style="display: none !important;">
                                                            <input type="text" name="nombre" value="<?php echo $nombreCons ?>" style="display: none !important;">
                                                            <input type="text" name="telefono" value="<?php echo $telefonoCons ?>" style="display: none !important;">
                                                            <input type="text" name="email" value="<?php echo $emailCons ?>" style="display: none !important;">
                                                            <input type="text" name="referencia" value="<?php echo $referenciaCons ?>" style="display: none !important;">
                                                            <input type="text" name="idioma" value="<?php echo $idiomaCons ?>" style="display: none !important;">
                                                            <input type="text" name="link" value="<?php echo $linkCons ?>" style="display: none !important;">
                                                            <textarea name="comentario" style="display: none !important;"><?php echo $comentarioCons ?></textarea>
                                                            <button type="submit" class="btn btn-primary btn-sm mt-3" style="margin-top: -7px;"><?php __('Convertir en cliente'); ?></button>
                                                        </form>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>

                                                <?php else: ?>
                                                    <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show" role="alert">
                                                        <i class="fa-regular fa-check label-icon"></i> <?php __('Este cliente ya existe en nuestra base de datos'); ?>
                                                        <form action="update-client.php" id="add-client" method="post" class="pull-right" target="_blank">
                                                            <input type="text" name="id" value="<?php echo $row_rsClients['id_cli'] ?>" style="display: none !important;">
                                                            <input type="text" name="date" value="<?php echo $email->header->date ?>" style="display: none !important;">
                                                            <input type="text" name="provider" value="<?php echo $email->header->details->from[0]->host ?>" style="display: none !important;">
                                                            <input type="text" name="nombre" value="<?php echo $nombreCons ?>" style="display: none !important;">
                                                            <input type="text" name="telefono" value="<?php echo $telefonoCons ?>" style="display: none !important;">
                                                            <input type="text" name="email" value="<?php echo $emailCons ?>" style="display: none !important;">
                                                            <input type="text" name="referencia" value="<?php echo $referenciaCons ?>" style="display: none !important;">
                                                            <input type="text" name="idioma" value="<?php echo $idiomaCons ?>" style="display: none !important;">
                                                            <input type="text" name="link" value="<?php echo $linkCons ?>" style="display: none !important;">
                                                            <textarea name="comentario" style="display: none !important;"><?php echo $comentarioCons ?></textarea>
                                                            <button type="submit" class="btn btn-primary btn-sm  mt-3" style="margin-top: -7px;"><?php __('Añadir consulta al cliente'); ?></button>
                                                            <a href="/intramedianet/properties/clients-form.php?id_cli=<?php echo $row_rsClients['id_cli'] ?>" class="btn btn-success btn-sm mt-1" target="_blank" style="margin-top: -7px;"><?php __('Ver cliente'); ?></a>
                                                        </form>
                                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                    </div>
                                                <?php endif ?>
                                            <?php endif ?>
                                        <?php endif ?>

                                        <?php echo str_replace(array('style="width: 100%; height: auto; margin: 0; padding: 0; border: none; background-color: #fbfbfb;font: 300 13pt/18pt Roboto,Helvetica,Helvetica Neue,Arial;"', 'lang=ES link=blue vlink=purple'), '', preg_replace('/<\s*style.+?<\s*\/\s*style.*?>/si', ' ', str_replace(get_images($email->message->info), get_images_from_email($email->attachments), $email->message->html))); ?>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="simplebar-placeholder" style="width: auto; height: 900px;"></div>
                    </div>
                    <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                        <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                    </div>
                    <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                        <div class="simplebar-scrollbar" style="height: 0px; display: none;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
