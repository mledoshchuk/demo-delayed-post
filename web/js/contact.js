document.getElementById('contact-submit-button').addEventListener("click", function(event) {
    submitForm();
});

$('.datetimepicker').datetimepicker({
    'allowInputToggle': true,
    'showClose': true,
    'showClear': true,
    'showTodayButton': true,
    'format': 'YYYY-MM-DD HH:mm:ss'
});

function submitForm() {

    window.XMLHttpRequest ? xmlhttp = new XMLHttpRequest() : xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == XMLHttpRequest.DONE) {
            if (xmlhttp.status == 200) {

                var response = xmlhttp.responseText;
                if (response == 'success') {
                    swal({
                        icon: 'success',
                        title: 'Posted Successfully',
                        button: true,
                        timer: 15000
                    })
                    document.getElementById("contact-form").reset();
                } else if (response == 'error') {
                    swal({
                        icon: 'error',
                        title: 'Insert has been failed',
                        button: true,
                        timer: 15000
                    })
                } else {
                    callErorSwalWithHTML(response);
                }


            } else if (xmlhttp.status == 400) {
                console.log('There was an error 400');
            } else {
                console.log('something else other than 200 was returned');
            }
        }
    }
    let base_url = window.location.origin + window.location.pathname;
    xmlhttp.open("POST", base_url + "?r=contact%2Fcreate");
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xmlhttp.setRequestHeader('X-CSRF-Token', yii.getCsrfToken());

    var type = document.querySelector('[name="ContactPost[type]"]').value;
    var companyName = document.querySelector('[name="Post[company_name]"]').value;
    var positionName = document.querySelector('[name="Post[position]"]').value;
    var contactName = document.querySelector('[name="ContactPost[contact_name]"]').value;
    var contactEmail = document.querySelector('[name="ContactPost[contact_email]"]').value;
    var contactPostAt = document.querySelector('[name="ContactPost[post_at]"]').value;

    xmlhttp.send(
        'csrf=' + yii.getCsrfToken() +
        '&type=' + type +
        '&company_name=' + companyName +
        '&position=' + positionName +
        '&contact_name=' + contactName +
        '&contact_email=' + contactEmail +
        '&post_at=' + contactPostAt
    );

}

function callErorSwalWithHTML(html) {
    let wrapper = document.createElement('div');
    wrapper.className = "container";
    wrapper.innerHTML = html;
    swal({
        title: "Validation error!",
        content: wrapper,
        icon: "error"
    });
}