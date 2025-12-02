<a href="/intramedianet/email/email.php?box=" <?php if ($_GET['box'] == ''): ?>class="active"<?php endif ?>>
    <i class="fa-regular fa-inbox me-3 align-middle fw-medium"></i>
    <span class="mail-list-link"><?php __('Entrada'); ?></span>
    <?php echo getTotalUnreadEmails($imap, 'INBOX') ?>
</a>
<a href="/intramedianet/email/email.php?box=Drafts" <?php if ($_GET['box'] == 'Drafts'): ?>class="active"<?php endif ?>>
    <i class="fa-regular fa-file me-3 align-middle fw-medium"></i>
    <span class="mail-list-link"><?php __('Borradores'); ?></span>
    <?php echo getTotalUnreadEmails($imap, 'Drafts') ?>
</a>
<a href="/intramedianet/email/email.php?box=Sent" <?php if ($_GET['box'] == 'Sent'): ?>class="active"<?php endif ?>>
    <i class="fa-regular fa-paper-plane me-3 align-middle fw-medium"></i>
    <span class="mail-list-link"><?php __('Sent'); ?></span>
    <?php echo getTotalUnreadEmails($imap, 'Enviados') ?>
</a>
<a href="/intramedianet/email/email.php?box=Trash" <?php if ($_GET['box'] == 'Trash'): ?>class="active"<?php endif ?>>
    <i class="fa-regular fa-trash-can me-3 align-middle fw-medium"></i>
    <span class="mail-list-link"><?php __('Papelera'); ?></span>
    <?php echo getTotalUnreadEmails($imap, 'Trash') ?>
</a>
<?php $folders = $imap->getFolders(); ?>
<?php foreach($folders as $key => $folder) { ?>
    <?php if (!in_array($key, $fixedFolders)): ?>
        <a href="/intramedianet/email/email.php?box=<?php echo imap_utf7_decode($key) ?>" class="<?php if ($_GET['box'] == $key): ?>active<?php endif ?>">
            <i class="fa-regular fa-folder me-3 align-middle fw-medium" aria-hidden="true"></i>
            <span class="mail-list-link"><?php echo $key ?></span>
            <?php echo getTotalUnreadEmails($imap, imap_utf7_decode($key)) ?>
        </a>
        <?php foreach($folder as $skey => $sfolder) { ?>
            <a href="/intramedianet/email/email.php?box=<?php echo imap_utf7_decode($key) ?>.<?php echo imap_utf7_decode($skey) ?>" class="<?php if ($_GET['box'] == $key.'.'.$skey): ?>active<?php endif ?>">
                 &nbsp;&nbsp; <i class="fa-regular fa-angle-double-right me-3 align-middle fw-medium" aria-hidden="true"></i> <i class="fa fw fa-folder" aria-hidden="true"></i>
                 <span class="mail-list-link"><?php echo $skey ?></span>
                <?php echo getTotalUnreadEmails($imap, imap_utf7_decode($key) . '.' . imap_utf7_decode($skey)) ?>
        </a>
            <?php foreach($sfolder as $sskey => $ssfolder) { ?>
                <a href="/intramedianet/email/email.php?box=<?php echo imap_utf7_decode($key) ?>.<?php echo imap_utf7_decode($skey) ?>.<?php echo imap_utf7_decode($sskey) ?>" class="<?php if ($_GET['box'] == $key.'.'.$skey.'.'.$sskey): ?>active<?php endif ?>">
                    <?php echo getTotalUnreadEmails($imap, imap_utf7_decode($key) . '.' . imap_utf7_decode($skey) . '.' . imap_utf7_decode($sskey)) ?>
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                     <i class="fa-regular fa-angle-double-right me-3 align-middle fw-medium" aria-hidden="true"></i>
                     <i class="fa-regular fa-folder me-3 align-middle fw-medium" aria-hidden="true"></i>
                     <span class="mail-list-link"><?php echo $sskey ?></span>
            </a>
            <?php } ?>
        <?php } ?>
    <?php endif ?>
<?php } ?>
