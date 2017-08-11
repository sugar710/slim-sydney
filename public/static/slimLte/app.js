
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

    $("[data-action='check-all']").click(function(){
        var $box = $(this).parents(".box");
        $box.find("table tr[data-id]").addClass("active");
    });

    $("[data-action='clear-all']").click(function(){
        var $box = $(this).parents(".box");
        $box.find("table tr[data-id]").removeClass("active");
    });

    $("[data-action='batch-del']").click(function(){
        var $this = $(this), href = $this.data("href") || $this.attr("href"), $box = $this.parents(".box");
        var ids = getSelected($box);
        if(ids.length > 0 && confirm("确定删除选中的 "+ids.length+" 项?")) {
            window.location.href = href + "?id=" + ids.join(",");
        }
    });

    $(".box .box-body .table tr[data-id]").click(function(){
        $(this).toggleClass("active");
    });

    function getSelected($box, dataAttr) {
        var result = [], dataAttr = dataAttr || 'id';
        $box.find(".table tr[data-id].active").each(function() {
            result.push($(this).data(dataAttr));
        });
        return result;
    }
});