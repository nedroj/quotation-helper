Loader = {};

Loader.$element = $('.ajax-loader');

Loader.toggle = function () {
    Loader.$element.toggle();
    return Loader.$element;
};

Loader.show = function () {
    Loader.$element.show();
    return Loader.$element;
};

Loader.hide = function () {
    Loader.$element.hide();
    return Loader.$element;
};
