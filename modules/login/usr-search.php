<?php

$querySearch = "
SELECT
    id,
    user,
    query,
    send,
    created,
    last
FROM users_searchs
WHERE user = '" . mysqli_real_escape_string($inmoconn, $_SESSION['kt_login_id']) . "'
ORDER BY created DESC
";

$searchs = getRecords($querySearch);

foreach ($searchs as $key => $value) {
    if ($value['query']) {
        array_push($searchs[$key], json_decode($value['query']));
    }
}

// echo "<pre>";
// print_r($searchs);
// echo "</pre>";

$smarty->assign("searchs", $searchs);

?>