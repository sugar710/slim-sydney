$(function () {

    toastr.options = {
        closeButton: true,
        progressBar: true,
        showMethod: 'slideDown',
        timeOut: 4000
    };

    (function () {
        var $body = $("body"),
            success = $body.data("toastr-success") || "",
            error = $body.data("toastr-error") || "",
            info = $body.data("toastr-info") || "";
        if (typeof toastr !== 'undefined') {
            success && toastr.success(success);
            error && toastr.error(error);
            info && toastr.info(error);
        }
    })();
});