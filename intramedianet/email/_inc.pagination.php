<ul class="pagination justify-content-center">
    <?php if (!empty($emails)): ?>
        <?php if($curpage != $startpage){ ?>
        <li>
            <a href="?box=<?php echo $_GET['box'] ?>&p=<?php echo $startpage ?>" class="btn btn-soft-primary btn-sm mx-1">
            <?php __('Primero'); ?>
            </a>
        </li>
        <?php } ?>
        <?php if($curpage > 2){ ?>
        <li>
            <a href="javascript:;" class="btn btn-link mx-1">...</a>
        </li>
        <?php } ?>
        <?php if($curpage >= 2){ ?>
        <li>
            <a href="?box=<?php echo $_GET['box'] ?>&p=<?php echo $previouspage ?>" class="btn btn-soft-primary btn-sm mx-1">
                <?php echo $previouspage ?>
            </a>
        </li>
        <?php } ?>
        <li class="active">
            <a href="?box=<?php echo $_GET['box'] ?>&p=<?php echo $curpage ?>" class="btn btn-primary btn-sm mx-1">
                <?php echo $curpage ?>
            </a>
        </li>
        <?php if($curpage != $endpage){ ?>
        <li>
            <a href="?box=<?php echo $_GET['box'] ?>&p=<?php echo $nextpage ?>" class="btn btn-soft-primary btn-sm mx-1">
                <?php echo $nextpage ?>
            </a>
        </li>
        <?php } ?>
        <?php if($curpage + 1 != $endpage && $curpage != $endpage){ ?>
        <li>
            <a href="javascript:;" class="btn btn-link mx-1">...</a>
        </li>
        <?php } ?>
        <?php if($curpage != $endpage){ ?>
        <li>
            <a href="?box=<?php echo $_GET['box'] ?>&p=<?php echo $endpage ?>" class="btn btn-soft-primary btn-sm mx-1">
                <?php __('Último'); ?>
            </a>
        </li>
        <?php } ?>
    <?php endif ?>
</ul>
