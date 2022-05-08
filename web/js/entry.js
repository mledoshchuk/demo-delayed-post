var sel = document.getElementById('create-select');
sel.addEventListener('change', () => {
    var select = document.getElementById('create-select').value;
    getXMLHttpRequest(select);
});

function getXMLHttpRequest(selectValue) {

    window.XMLHttpRequest ? xmlhttp = new XMLHttpRequest() : xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
            if (xmlhttp.status == 200) {

                var response = JSON.parse(xmlhttp.responseText);
                if (response.status) {
                    window.location.href = response.url;
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

    xmlhttp.open('POST', base_url + '?r=post%2Fredirect');
    xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xmlhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xmlhttp.setRequestHeader('X-CSRF-Token', yii.getCsrfToken());

    xmlhttp.send('typeId=' + selectValue + '&_csrf=' + yii.getCsrfToken());

}