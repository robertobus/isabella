function alertMessages(type, title, message){
    return pnoti = new PNotify({
        auto_display: false,
        styling: "bootstrap3", width: "400px",
        hide: true, delay: 6000,
        buttons: { closer: true, sticker: false, labels: {close: "Cerrar", stick: "Pausar"} },
        title: title,
        text: message,
        type: type
    });
}

function confirmMessages(title, message){
    var stackInfo = { 'dir1': 'down', 'dir2': 'right', 'modal': true };
    pnoti = new PNotify({
        styling: "fontawesome",
        title: title,
        text: message,
        confirm: {
            confirm: true,
            align: "center",
            buttons: [
                { text: "Ok", addClass: "", promptTrigger: false,
                    click: function(notice, value){
                        notice.remove();
                        notice.get().trigger("pnotify.confirm", [notice, value]);
                    }
                },
                { text: "Cancel", addClass: "",
                    click: function(notice){
                        notice.remove();
                        notice.get().trigger("pnotify.cancel", notice); }
                }
            ]
        },
        buttons: { closer: false, sticker: false },
        history: { history: false },
        /*addclass: 'stack-modal'*/
        stack: stackInfo
    });
}