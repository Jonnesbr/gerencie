var APP = APP || {};

APP.Base = (function ($) {
    function init() {
        bindEvents();
    }

    function bindEvents() {
        console.log('ok, esta carregando o .js');
    }

    return {init:init};
})(jQuery);
