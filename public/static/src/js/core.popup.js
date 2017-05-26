$.status = function(msg, closable) {
    if ($("#popup-status").length > 0) {
        return false;
    }

    var box = document.createElement('div');

    box.id = 'popup-status';
    box.style.display = 'inline-block';
    box.style.position = 'fixed';
    box.style.top = '0px';
    box.style.right = '0px';
    box.style.padding = '10px 40px 10px 20px';
    box.style.border = '0px 0px 1px 1px';
    box.style.borderColor = '#e0be90';
    box.style.borderRadius = '0px 0px 0px 10px';
    box.style.backgroundColor = '#fff';
    box.innerHTML = msg;

    document.body.appendChild(box);

    setTimeout(function () {
        $(box).remove();
    }, 2000);
};

$.warning = function (msg, delay) {
    if ($("#js-waring").length > 0) {
        return false;
    }

    var box = document.createElement('div');

    box.id = 'js-waring';
    box.style.display = 'inline-block';
    box.style.position = 'fixed';
    box.style.top = '0px';
    box.style.right = '0px';
    box.style.padding = '10px 40px 10px 20px';
    box.style.border = '0px 0px 1px 1px';
    box.style.borderColor = '#e0be90';
    box.style.borderRadius = '0px 0px 0px 10px';
    box.style.backgroundColor = '#ffecef';
    box.innerHTML = msg;

    document.body.appendChild(box);

    setTimeout(function () {
        $(box).remove();
    }, 2000);
};