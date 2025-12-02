<?php
$perpage = 15;

if(isset($_GET['p']) & !empty($_GET['p'])){
    $curpage = $_GET['p'];
}else{
    $curpage = 1;
}
$start = ($curpage * $perpage) - $perpage;

$curFolder = ($_GET['box'] != '')?$_GET['box']:'INBOX';
$imap->selectFolder($curFolder);
$box_info = $imap->getMailboxStatistics();

$endpage = ceil($box_info->Nmsgs/$perpage);
$startpage = 1;
$nextpage = $curpage + 1;
$previouspage = $curpage - 1;

$emails = $imap->getMessages($perpage, $curpage -1, 'DESC');
$imap->incomingMessage;
?>

<div id="moveModal" class="modal fade" tabindex="-1" aria-labelledby="moveModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h5 class="modal-title text-white pb-3" id="moveModalLabel"><i class="fa-regular fa-folder-arrow-up me-2 fs-4"></i> <?php __('Mover mensaje'); ?></h5>
                <button type="button" class="btn-close bg-white mb-2" data-bs-dismiss="modal" aria-label="Close"> </button>
            </div>
            <div class="modal-body bg-light">
                <?php if (!empty($emails)): ?>
                    <input type="hidden" name="mail-id" id="mail-id">
                    <div class="form-group">
                        <label for="folder" class="form-label"><?php __('Mover a la carpeta'); ?>:</label>
                        <select name="folder" id="folder" class="form-select">
                            <option value=""><?php __('Seleccione una carpeta'); ?></option>
                            <option value="INBOX"><?php __('Entrada'); ?></option>
                            <option value="Drafts"><?php __('Borradores'); ?></option>
                            <option value="Sent"><?php __('Enviados'); ?></option>
                            <option value="Trash"><?php __('Papelera'); ?></option>
                            <?php foreach($folders as $key => $folder) { ?>
                                <?php if (!in_array($key, $fixedFolders)): ?>
                                    <option value="<?php echo imap_utf7_decode($key) ?>"><?php echo $key ?></option>
                                    <?php foreach($folder as $skey => $sfolder) { ?>
                                        <option value="<?php echo imap_utf7_decode($key) ?>.<?php echo imap_utf7_decode($skey) ?>"> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $skey ?></option>
                                        <?php foreach($sfolder as $sskey => $ssfolder) { ?>
                                            <option value="<?php echo imap_utf7_decode($key) ?>.<?php echo imap_utf7_decode($skey) ?>.<?php echo imap_utf7_decode($sskey) ?>"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $sskey ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                <?php endif ?>
                            <?php } ?>
                        </select>
                    </div>
                <?php endif ?>
            </div>
            <div class="modal-footer bg-soft-primary">
                <button type="button" class="btn btn-primary btn-sm mt-4" id="movebtn" data-loading-text="<?php __('Procesando'); ?>..."><?php __('Mover'); ?></button>
                <a href="#" class="btn btn-danger btn-sm mt-4" data-bs-dismiss="modal"><?php __('Cerrar'); ?></a>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
