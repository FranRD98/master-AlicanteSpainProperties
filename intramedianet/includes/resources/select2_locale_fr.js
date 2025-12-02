/**
 * Select2 Spanish translation
 */
(function ($) {
    "use strict";

    $.fn.select2.locales['fr'] = {
    	formatMatches: function (matches) { if (matches === 1) { return "Un résultat disponible, appuyez sur Entrée pour le sélectionner."; } return matches + " résultats disponibles, utilisez les touches fléchées pour naviguer."; },
        formatNoMatches: function () { return "No se encontraron resultados"; },
        formatInputTooShort: function (input, min) { var n = min - input.length; return "Entrez s'il vous plait " + n + " car" + (n == 1? "actère" : "actères"); },
        formatInputTooLong: function (input, max) { var n = input.length - max; return "Supprime s'il te plaît " + n + " car" + (n == 1? "actère" : "actères"); },
        formatSelectionTooBig: function (limit) { return "Vous ne pouvez sélectionner " + limit + " élément" + (limit == 1 ? "" : "s"); },
        formatLoadMore: function (pageNumber) { return "Chargement de plus de résultats…"; },
        formatSearching: function () { return "Recherche…"; },
        formatAjaxError: function() { return "Le téléchargement a échoué"; }
    };
    $.extend($.fn.select2.defaults, $.fn.select2.locales['fr']);
})(jQuery);
