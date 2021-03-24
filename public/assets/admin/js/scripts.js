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

// func(resdata, locationhref, statusCode)
function sentAJax(func) {
    let routeHref = $('.div-form').attr('data-route')
    let urlApi = $('.div-form').attr('data-api')
    let dataMethod = $('.div-form').attr('data-method')
    let getFormData = $('.div-form input')
    let getFormErr = $('.div-form .has-error .help-block')
    let token = getCookie('auth_token')
    let objData = {}
    let urlApiDelete = false;

    if(urlApi.indexOf('/delete') > -1) {
        urlApiDelete = true
    }

    let arr = [];
    let foundArrayName = false;
    for (let i = 0; i < getFormData.length; i++) {
        const el = getFormData[i];
        let inputName = el.name
        const inputVal = el.value
        if(inputName.indexOf('[]') > -1) {
            foundArrayName = true
            inputName = el.name.split('[]')[0]
            if(el.checked) arr.push(inputVal)
        }
        objData = {...objData, [inputName]: foundArrayName ? arr : inputVal }
    }

    if(getFormErr.length) {
        getFormErr.each((i, ele) => {
            let parent = $(ele).parent()
            parent.removeClass('has-error')
            ele.remove()
        });
    }

    return $.ajax({
        method:dataMethod ? dataMethod : 'POST',
        url: urlApi,
        data: objData,
        headers: {
            'Authorization': token ? `Bearer ${token}` : '',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(res, textStatus, xhr) {
            func(res, routeHref, xhr.status)
        },
        error:function(res){
            func(res.responseJSON, '', res.status)
            if(!urlApiDelete && res.responseJSON.hasOwnProperty('errors')) {
                let errors = res.responseJSON.errors
                let nameArray = [];
                for (let j = 0; j < getFormData.length; j++) {
                    const ele = getFormData[j];
                    Object.entries(errors).forEach(([key, val]) => {
                        if(ele.name == key || ele.name.indexOf(`${key}[]`) > -1) {
                            if(nameArray.indexOf(`${ele.name}`) < 0 && ele.name.indexOf(`${key}[]`) > -1) { 
                                nameArray.push(`${ele.name}`) 
                                return 
                            }
                            const parentEle = $(ele).parent()
                            parentEle.addClass('has-error')
                            parentEle.append(`<span class="help-block">${val[0]}</span>`)
                        } 
                    });
                }
            }
        }
    })
}

function eraseInput() {
    let getFormData = $('.div-form input')
    for (let i = 0; i < getFormData.length; i++) {
        const el = getFormData[i];
        if(el.name.indexOf(`[]`) > -1) {
            $(el).prop('checked',false);
            console.log($(el))
            continue;
        }
        $(el).val('')
    }

}

function onSubmitAjax(func) {
    $('.btn-submit').on('click', function(e) {
        sentAJax(func)
    })
    
    $('.div-form input.form-control').on('keypress', function(e) {
        let keyCode = e.which || e.keyCode;
        if(keyCode===13){ // enter key has code 13 or enter
            sentAJax(func)
        }
    })


}

//popup alert success or error
function alertMessage(title, content, icon, reloadPage=false) {
    $.confirm({
        title: title,
        content: content,
        icon: icon,
        closeAnimation: 'zoom',
        opacity: 0.5,
        buttons: {
            confirm: function () {
                if(reloadPage) location.reload() 
            },
        }
    });
}

jQuery(function($) {
    $('.form-checkbox').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue',
        increaseArea: '20%' /* optional */
      });

})
// pop up alert delete
$(document).on('click', 'a.btn-delete', function (e) {
    e.preventDefault(); 
    let $this = e.currentTarget
    let token = getCookie('auth_token')
    let urlApi = $(this).attr('data-api')

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
                    $.ajax({
                        method: 'DELETE',
                        url: urlApi,
                        headers: {
                            'Authorization': token ? `Bearer ${token}` : '',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },success:function(res, textStatus, xhr) {
                            alertMessage(res.message, res.data.message, 'fa fa-check-circle', true)
                        },
                        error:function(res){}
                    })
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
