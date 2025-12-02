<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

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

<div class="email-content">
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
                                    <div class="simplebar-content" style="padding: 0px 24px;">

                                        <div id="elmLoader"></div>
                                        <ul class="message-list" id="mail-list">
                                            <?php if (!empty($emails)): ?>
                                                <?php foreach ($emails as $email) { ?>
                                                    <li class="">
                                                        <div class="col-mail col-mail-1">
                                                            <i class="fa-regular fs-7 ms-3 <?php echo ($email->header->seen == 0)?'fa-envelope':'fa-envelope-open'; ?>" aria-hidden="true"></i>
                                                            <a href="/intramedianet/email/email.php?id=<?php echo $email->header->msgno; ?>&id2=<?php echo $email->header->uid; ?>&box=<?php echo ($_GET['box'] == '')?'INBOX':$_GET['box']; ?>&from=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class="title">
                                                                <span class="title-name"><b><?php echo str_replace("\"", "", $email->header->from) ?></b></span>
                                                            </a>
                                                        </div>
                                                        <div class="col-mail col-mail-2">
                                                            <a href="/intramedianet/email/email.php?id=<?php echo $email->header->msgno; ?>&id2=<?php echo $email->header->uid; ?>&box=<?php echo ($_GET['box'] == '')?'INBOX':$_GET['box']; ?>&from=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class="subject">
                                                                <span class="subject-title"><?php echo $email->header->subject ?></span>
                                                                <!-- <span class="teaser">Trip home from Colombo has been arranged, then Jenna will come get me from Stockholm. :)</span> -->
                                                            </a>
                                                            <div class="date">
                                                                <?php echo iconv("ISO-8859-1", "UTF-8", ucwords(date("d-m-y", strtotime($email->header->date)))); ?>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                            <?php else: ?>
                                                <li class="list-group-item lead text-center">
                                                    <br><br><br>
                                                    <img src="/intramedianet/includes/assets/imgs/no-email.png" style="opacity: .2;">
                                                    <br><br>
                                                    <?php __('No hay mensajes que mostrar en este momento'); ?>
                                                    <br><br><br><br><br>
                                                </li>
                                            <?php endif ?>

                                        </ul>

                                        <br>

                                        <div class="text-center">
                                            <?php require_once  $_SERVER["DOCUMENT_ROOT"] . "/intramedianet/email/_inc.pagination.php"; ?>
                                        </div>
                                        <hr>


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








<?php /* ?>

<div class="panel-heading">
    <h3 class="panel-title"></h3>
</div>
<ul class="list-group">

</ul>
<div class="panel-footer">
</div>

<?php */ ?>
