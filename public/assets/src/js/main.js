/**
 * Inicializador
 * @param {object} $        - instancia do jQuery
 * @param {object} document - window.document
 * @param {object} NS       - Namespace da aplicação
 * @return void
 */

(function ( $, document, NS) {

    "use-strict";

    $(document).ready(function () {
        NS.Base.init();
    });
})(jQuery, window.document, APP);
