on(document, 'click', '#descriptive-submit-button', function (event) {
    submitForm();
});
function submitForm() {

    window.XMLHttpRequest ? xmlhttp = new XMLHttpRequest() : xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

    xmlhttp.onreadystatechange = function () {
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
                    document.getElementById("descriptive-form").reset();
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
    xmlhttp.open("POST", base_url + "?r=descriptive%2Fcreate");
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xmlhttp.setRequestHeader('X-CSRF-Token', yii.getCsrfToken());

    let type = document.querySelector('[name="DescriptivePost[type]"]').value,
        companyName = document.querySelector('[name="Post[company_name]"]').value,
        positionName = document.querySelector('[name="Post[position]"]').value,
        positionDescription = document.querySelector('[name="DescriptivePost[position_description]"]').value,
        salary = document.querySelector('[name="DescriptivePost[salary]"]').value,
        startsAt = document.querySelector('[name="DescriptivePost[starts_at]"]').value,
        endstAt = document.querySelector('[name="DescriptivePost[ends_at]"]').value,
        postAt = document.querySelector('[name="DescriptivePost[post_at]"]').value;

    xmlhttp.send(
        'csrf=' + yii.getCsrfToken() +
        '&type=' + type +
        '&company_name=' + companyName +
        '&position=' + positionName +
        '&position_description=' + positionDescription +
        '&salary=' + salary +
        '&starts_at=' + startsAt +
        '&ends_at=' + endstAt +
        '&post_at=' + postAt
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