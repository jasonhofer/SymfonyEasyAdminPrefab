
var $ = require('jquery');

require('bootstrap-sass');

$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();
});

