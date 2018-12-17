function initModalAjax(){
    $("[data-toggle=modal]").on('click', function (event) {
        event.preventDefault();
        var btn = $(this);
        var url = $(this).attr("href");

        if (url.indexOf("#") == 0) {
            $(url).modal('open');
        } else {
            var title = btn.attr("data-title");
            var header = '<div class="modal-header"><a class="close" data-dismiss="modal">&times;</a></div>';
            if(title != '' && typeof title !== "undefined"){
                header = '<div class="modal-header"><a class="close" data-dismiss="modal">&times;</a><h4>'+title+'</h4></div>';
            }
            btn.attr("data-loading-text", "cargando...");
            btn.button('loading');
            $.get(url, function (data) {
                btn.button('reset');
                $('.modal').remove();
                $('<div class="modal fade" ><div class="modal-dialog" role="document"><div class="modal-content" id="modal-gestor">' + header + data + '</div></div></div>').modal().on('hidden', function () {
                    $('.modal-backdrop.in').each(function (i) {
                        $(this).remove();
                    });
                });
            }).success(function () {
                $('input:text:visible:first').focus();
            });
        }
        return false;
    });
}
