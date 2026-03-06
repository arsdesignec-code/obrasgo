$(document).ready(function () {
    "use strict";
    $(".code-dropdown").on("change",function () {
        "use strict";
        $('#language').val($(this).find(':selected').attr('data-language-name'));
    });
});