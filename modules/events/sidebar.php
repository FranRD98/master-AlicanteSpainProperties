<?php


$categories = getRecords("
SELECT news_categories.id_ct,
    news_categories.category_".$lang."_ct as cat
FROM news_categories
WHERE type_ct = 1  AND (parent_ct = 0 OR parent_ct is NULL)
ORDER BY news_categories.orden_ct ASC
");

function getChilds($par, $slug, $level) {

    global $urlStart, $lang, $tokens, $urlStr;

    $ret = '';

    $categories = getRecords("
    SELECT news_categories.id_ct,
        news_categories.category_".$lang."_ct as cat
    FROM news_categories
    WHERE type_ct = 1  AND parent_ct = '" . $par . "'
    ORDER BY news_categories.orden_ct ASC
    ");

    if ($categories[0]['id_ct'] != '') {
        $levelprev = $level-1;
        $levelmax = $level++;
        foreach ($categories as $value) {
            $theSlug = $slug.slug($value['cat']).'/';
            $active = ($tokens[2] == $value['id_ct'])?' active"':'';
            $ret .= '<a class="list-group-item sub' . $active . '" ' . $active . ' href="'.$urlStart.''.$urlStr['news']['url'].'/'.$urlStr['category']['url'].'/'.$value['id_ct'].'/'.$theSlug.'">' . str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;", $levelmax) . '' . $value['cat'] . '</a>';
            $ret .= getChilds($value['id_ct'], $theSlug, $level++);
        }
    }

    return $ret;

}

$menuCats = '<ul class="list-group">';
$active = ($tokens[2] == '')?' active':'';
$menuCats .= '<a href="'.$urlStart.''.$urlStr['news']['url'].'/" class="list-group-item' . $active . '">'.$langStr['Todos'].'</a>';

foreach ($categories as $value) {

    $active = ($tokens[2] == $value['id_ct'])?' active':'';

    $menuCats .= '<a class="list-group-item' . $active . '" ' . $active . ' href="'.$urlStart.''.$urlStr['news']['url'].'/'.$urlStr['category']['url'].'/'.$value['id_ct'].'/'.slug($value['cat']).'/">' . $value['cat'] . '</a>';
    $menuCats .= getChilds($value['id_ct'], slug($value['cat']).'/', 1);

}

'';
$menuCats .= '</ul>';

$smarty->assign("menuCats", $menuCats);


$alltags = getRecords("
    SELECT news.tags_".$lang."_nws as tags
    FROM news
    WHERE tags_".$lang."_nws != '' AND type_nws = 1
");

$smarty->assign("alltags", $alltags);


foreach ($alltags as $arrtag) {
    foreach ($arrtag as $tag) {
        $menuTags .= $tag.',';
    }
}
$menuTags = implode(',', array_unique(explode(',', $menuTags)));

$smarty->assign("menuTags", $menuTags);

?>