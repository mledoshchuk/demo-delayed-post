$('#main-contr').on('focus', '.datetimepicker', function() {
    if( $(this).hasClass('.datetimepicker') === false )  {
        $('.datetimepicker').datetimepicker({
            'allowInputToggle': true,
            'showClose': true,
            'showClear': true,
            'showTodayButton': true,
            'format': 'YYYY-MM-DD HH:mm:ss'
        });
    }
});

const on = (ele, type, selector, handler) => {
    ele.addEventListener(type, (event) => {
        let el = event.target.closest(selector);
        if (el) handler.call(el, event);
    });
};
on(document, 'change', '#create-select', function(event) {
    getXMLHttpRequest(this.value);
});


function getXMLHttpRequest(selectValue) {
    window.XMLHttpRequest ? xmlhttp = new XMLHttpRequest() : xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
            if (xmlhttp.status == 200) {
                var response = JSON.parse(xmlhttp.responseText);
                if (response.status) {
                        let container = document.getElementById('main-contr');
                        container.innerHTML = response.result;
                }

            }
            else if (xmlhttp.status == 400) {
                console.log('There was an error 400');
            }
            else {
                console.log('something else other than 200 was returned');
            }
        }
    }

    let base_url = window.location.origin + window.location.pathname;

    xmlhttp.open('POST', base_url + '/' + 'forms');
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xmlhttp.setRequestHeader('X-CSRF-Token', yii.getCsrfToken());

    xmlhttp.send('typeId=' + selectValue + '&_csrf=' + yii.getCsrfToken());

}