function setCookie(name,value,days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setDate(date.getDate() + days);
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
function eraseCookie(name) {   
    document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
}

jQuery(function($) {

    function sentAJax() {
        let url = $('.div-form').attr('data-api')
        let getFormData = $('.div-form input.form-control')
        let objData = {}

        for (let i = 0; i < getFormData.length; i++) {
            const el = getFormData[i];
            const inputName = el.name
            const inputVal = el.value
            objData = {...objData, [inputName]: inputVal }
        }

        $.ajax({
            method:'POST',
            url: url,
            data: objData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success:function(response) {
               setCookie('auth_token', response.data.token, 14)
               window.location = '/__/admin'
             },
            error:function(){
              alert("error");
            }
        })
    }

    $('.btn-submit').on('click', function(e) {
        sentAJax();
    })

    $('.div-form input.form-control').on('keypress', function(e) {
        let keyCode = e.which || e.keyCode;
        if(keyCode===13){ // enter key has code 13 
            sentAJax()
         }
    })
})

// pop up alert delete
$(document).on('click', 'a.btn-danger', function (e) {
    e.preventDefault(); 
    let $this = e.currentTarget
    console.log($this)
    $.confirm({
        title: 'Are you sure?',
        content: 'You can\'t undo by deleting this data',
        icon: 'fa fa-trash-o',
        closeAnimation: 'zoom',
        opacity: 0.5,
        buttons: {
            'confirm': {
                text: 'Yes, I\'m Sure',
                btnClass: 'btn btn-red',
                action: function () {
                    window.location = $this.href;
                }
            },
            specialKey: {
                isHidden: true,
                keys: ['esc'],
                action: function(){
                }
            },
            cancel: function () {
                
            },
        }
    });

    return false;
});
