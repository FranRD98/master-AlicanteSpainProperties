<?php

if($lang_adm == "es") {
  $feed = "https://mediaelx.net/rss-paneles-es.php?idm=1";
  $banner = "https://mediaelx.net/rss-banners-new-es.php";
} else {
  $feed = "https://mediaelx.net/rss-paneles-en.php?idm=2";
  $banner = "https://mediaelx.net/rss-banners-new-en.php";
}

if (!function_exists("getXML")) {
    function getXML($url) {
        set_time_limit(0);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, trim($url));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36");
        $data = curl_exec($ch);
        curl_close($ch);
        $xml = simplexml_load_string($data);
        return $xml;
    }
}
$xml = getXML($feed);
$banner = getXML($banner);
?>
<div id="carouselExampleInterval" class="carousel slide mt-5 px-3" data-bs-ride="true">
    <div class="carousel-inner">

        <?php $x = 0; ?>
        <?php foreach($xml->channel->item as $entry){ ?>
        <div class="carousel-item <?php if ($x == 0): ?>active<?php endif ?>" data-bs-interval="5000" style="min-height_: 350px;">
            <a href="<?php echo $entry->link; ?>" target="_blank">

                <h3 class="mb-3"><?php echo $entry->title ?></h3>

                <?php if ($entry->img != ''): ?>
                    <?php echo showThumbnail($entry->img, '/media/images/news/', 1200, 800, '', 'd-block img-fluid'); ?>
                <?php endif ?>
            </a>
        </div>
        <?php
            if ($entry->title != '') {
                if ($x++ == 3) {
                    break;
                }
            }
        }
        ?>
    </div>

</div>

<div class="text-center mt-4">
    <button class="bg-transparent border-0 mt-3 fw-100 p-0 m-0" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
        <img src="https://mediaelx.net/media/images/banner-rss/prev.png" alt="">
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="bg-transparent border-0 mt-3 fw-100 p-0 m-0" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
        <img src="https://mediaelx.net/media/images/banner-rss/next.png" alt="">
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="text-center my-5 mx-3">
    <a href="<?php echo $banner->url ?>" target="_blank"><img src="<?php echo $banner->image ?>" alt="" class="img-fluid rounded"></a>
</div>
