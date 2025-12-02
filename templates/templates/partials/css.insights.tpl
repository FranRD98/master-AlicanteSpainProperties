<!-- CSS
================================================== -->
{if $isInsights == false}
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
{/if}
<link rel="stylesheet" href="/css/website.{getFileTime('css/website.css')}.css">
<style type="text/css">{section name=ls loop=$labelsStyles}.label-{$labelsStyles[ls].id_tag} { background: {$labelsStyles[ls].color_tag };color: {$labelsStyles[ls].text_color_tag}; }{/section}</style>
{if $seccion == ''}
<style type="text/css">.main-slider { background-image: url({$banners[0].img}); }</style>
{/if}