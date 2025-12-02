<?php
// Cargamos la conexión a MySql
include( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

// Cargamos los idiomas de la administración
include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/resources/translate.php' );

?>
<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="<?php echo ((isset($_COOKIE['sidebarComp']))&&($_COOKIE['sidebarComp'] != ''))?$_COOKIE['sidebarComp']:'lg'; ?>" data-sidebar-image="none" data-preloader="enable" data-layout-position="scrollable">
<head>

	<?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.head.php' ); ?>

</head>

<body>

	<?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.header.php' ); ?>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque, doloribus sunt placeat rerum aperiam facere nam veniam ea at obcaecati dolor vitae repellat cumque quod sequi dolores autem quas consequatur!</p>
        <p>Amet, alias, odio, labore ab nesciunt voluptatum itaque rem veniam explicabo quidem recusandae maiores quia debitis autem inventore hic ratione. Aperiam, repellat, veniam expedita aliquam quae iste fugiat rerum dolorem.</p>
        <p>Laudantium, sapiente, distinctio, vero quae voluptas dolores iste reiciendis ex at quam nisi neque iure ipsum sit minima culpa consequatur facere velit cum amet saepe accusantium labore molestiae ad architecto.</p>
        <p>Beatae, laborum, quo, eius aut repellendus voluptatibus voluptatem cumque totam ducimus deleniti distinctio sit placeat architecto cupiditate iste. Esse, dolorum quia cupiditate aperiam deleniti voluptates ab facere atque assumenda deserunt.</p>
        <p>Fugiat aut necessitatibus neque reiciendis molestiae totam nulla suscipit rem? Deleniti, enim, sequi amet optio asperiores aliquid commodi natus rerum accusantium architecto eos repudiandae fugit quisquam omnis harum aut beatae!</p>
        <p>Quo, atque, tempore, nam, omnis quos dolore enim similique aliquid perspiciatis iure maxime expedita in tenetur quam culpa vel est dicta dolor iste illum nostrum animi quod dolorum. Atque, dolore?</p>
        <p>Repellat, autem, consectetur provident dolor nisi reiciendis officia aut quis iste natus at ut a laudantium quas cumque aspernatur deserunt impedit illum facilis nam vero delectus sint rerum minus officiis.</p>
        <p>Soluta, possimus, odit doloribus corporis animi natus quos id consectetur vitae cupiditate. Consequuntur, asperiores, placeat, consequatur, ipsa mollitia esse rem incidunt similique laboriosam excepturi necessitatibus autem repudiandae harum qui maiores.</p>
        <p>Dolorem, quas blanditiis maxime voluptas voluptatem doloremque hic soluta vel adipisci itaque aliquid ipsa unde molestias iure reprehenderit iste laboriosam excepturi vitae et alias quos iusto libero aspernatur mollitia nemo.</p>
        <p>Rerum, omnis nobis dignissimos corporis vero quaerat mollitia laudantium repudiandae nostrum quidem deleniti distinctio pariatur cupiditate inventore eveniet minima ipsum quibusdam natus incidunt labore totam doloremque aut perspiciatis aliquid suscipit?</p>

    <?php include( $_SERVER["DOCUMENT_ROOT"] . '/intramedianet/includes/inc.footer.php' ); ?>

</body>
</html>
