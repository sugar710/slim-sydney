
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

    $("input:file[data-action='upload']").on('change',function(){
        var _this = $(this), uploadUrl = _this.data("upload-url") || '/public/upload';
        $(this.files).each(function(){
            var formData = new FormData();
            formData.append("file", this);
            upload(uploadUrl, formData).then(function(data) {
                _this.triggerHandler("uploadComplete", [data.status, data.data]);
            }).catch(function(err) {
                console.log(err);
            });
        });
    });
});


/**
 * 文件上传
 *
 * @param url 处理文件上传地址
 * @param formData
 */
function upload(url, formData) {
    url = url || '/public/upload';
    return new Promise(function (resolve, reject) {
        if(!formData) {
            reject("无上传数据");
        } else {
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {
                    resolve(response);
                },
                error: function (response) {
                    reject(response);
                }
            });
        }
    });
}