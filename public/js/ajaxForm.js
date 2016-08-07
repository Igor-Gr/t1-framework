var ajax = {

    getXmlHttpRequest: function () {

        if (window.XMLHttpRequest) {
            try {
                return new XMLHttpRequest();
            } catch (e) {}
        } else if (window.ActiveXObject) {
            try {
                return new ActiveXObject("Msxml2.XMLHTTP");
            } catch (e) {}
            try {
                return new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}
        }
        return null;
    }
};

var view = {

};


var model = {
    
    getFormFields: function (event) {
        var e = event || window.Event;
        var target = e.target || src.Element;
        var form;
        var fields = '';
        while (target) {
            if (target.tagName == 'FORM') {
                form = target;
                var inputs = form.getElementsByTagName('input');
                for (var i = 0; i < inputs.length; i++) {
                    fields += inputs[i].name + '=' + inputs[i].value + '&';
                    inputs[i].value = '';
                }
                fields = fields.slice(0, fields.length - 1);
                return fields;
            }
            target = target.parentNode;
        }
    },
    
    senRequest: function (postRequest, handler, callback) {
        
        var request = ajax.getXmlHttpRequest();
        request.onreadystatechange = function () {
            if (request.readyState != 4) return;
            if (callback && typeof callback === 'function') {
                callback(request.responseText);
            }
        };
        request.open('POST', handler, true);
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send(postRequest);
    }
};

var controller = {
    
    handleClick: function (event) {
        var fieldsAndValues = model.getFormFields(event);
        model.senRequest(fieldsAndValues, 'http://t1/test.php');
        return false;
    }
    
};

(function () {
    
    var app = {
        
        init: function () {
            this.event();
        },
        
        event: function () {
            var btn = document.getElementById('btn');
            btn.onclick = controller.handleClick;
        }
        
    };
    app.init();

}());
