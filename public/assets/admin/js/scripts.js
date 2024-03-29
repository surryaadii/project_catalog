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
    let getFormData = $('.div-form input, .div-form textarea, .div-form select')
    let getFormErr = $('.div-form .has-error .help-block')
    let token = getCookie('auth_token')
    let objData = {}
    let urlApiDelete = false;

    if(urlApi.indexOf('/delete') > -1) {
        urlApiDelete = true
    }

    let obj = {};
    for (let i = 0; i < getFormData.length; i++) {
        let foundArrayName = false;
        const el = getFormData[i];
        if( $(el).attr('disabled') ) continue
        let inputName = el.name
        const inputVal = $(el).val()
        if(inputName.indexOf('[]') > -1) {
            foundArrayName = true
            inputName = el.name.split('[]')[0]
            if(el.checked || ( (el.type == 'text' || el.type == 'textarea') && inputVal !== '' )) {
                let arr = []
                let arrInput = Object.keys(obj).indexOf(inputName) > -1 ? obj[inputName] : []
                arr.push(inputVal)
                arrInput.push(inputVal)
                obj = {...obj, [inputName]: arrInput.length ? arrInput : arr}
            }
        }
        objData = {...objData, [inputName]: foundArrayName ? obj[inputName] : inputVal }
    }

    if(getFormErr.length) {
        getFormErr.each((i, ele) => {
            let parent = $(ele).parent()
            parent.removeClass('has-error')
            ele.remove()
        });
    }

    return $.ajax({
        method: dataMethod ? dataMethod : 'POST',
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
                let nameObj = {};
                let tempNameObj = {}
                let searchNameArray = $('.div-form').find("input[name*='[]']")
                for (let p = 0; p < searchNameArray.length; p++) {
                    const elem = searchNameArray[p];
                    if(Object.keys(tempNameObj).indexOf(elem.name) > -1) {
                        let count = tempNameObj[elem.name]
                        tempNameObj = {...tempNameObj, [elem.name]: count+1}
                    } else {
                        tempNameObj = {...tempNameObj, [elem.name]: 0}
                    }
                }
                for (let j = 0; j < getFormData.length; j++) {
                    const ele = getFormData[j];
                    Object.entries(errors).forEach(([key, val]) => {
                        if(ele.name == key || ele.name.indexOf(`${key}[]`) > -1) {
                            if(Object.keys(nameObj).indexOf(`${ele.name}`) > -1 && ele.name.indexOf(`${key}[]`) > -1) { 
                                cnt = nameObj[ele.name]
                                nameObj = {...nameObj, [ele.name]: cnt+1}
                            } else if(Object.keys(nameObj).indexOf(`${ele.name}`) < 0) {
                                nameObj = {...nameObj, [ele.name]: 0}
                            }
                            if(ele.name.indexOf(`${key}[]`) > -1 && nameObj[ele.name] != tempNameObj[ele.name]) return
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
    let segment = getSegmentUrl()
    let checkSegmentCreate = segment == 'create' ? true : false
    if(checkSegmentCreate) {
        let getFormData = $('.div-form input', '.div-form textarea')
        for (let i = 0; i < getFormData.length; i++) {
            const el = getFormData[i];
            if(el.name.indexOf(`[]`) > -1) {
                $(el).prop('checked',false);
                continue;
            }
            $(el).val('')
        }
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

// getSegmentUrl
function getSegmentUrl() {
    let str = window.location.href;
    str = str.split("/");

    let segment = str[str.length - 1]
    return segment
}

//popup alert success or error
function alertMessage(title, content, icon, reloadPage=false) {
    let segment = getSegmentUrl()
    let checkSegmentCreate = segment == 'create' ? true : false
    $.confirm({
        title: title,
        content: content,
        icon: icon,
        closeAnimation: 'zoom',
        opacity: 0.5,
        buttons: {
            confirm: function () {
                if(reloadPage || checkSegmentCreate) location.reload() 
            },
            specialKey: {
                isHidden: true,
                keys: ['enter'],
                action: function(){
                    if(reloadPage || checkSegmentCreate) location.reload()
                }
            },
        }
    });
}

function addNewInputFieldText(nameInput, placeholder) {
    let max_fields      = 10; //maximum input boxes allowed
    let wrapper         = $(".add-input-wrapper"); //Fields wrapper
    let add_button      = $(".add-btn-input"); //Add button ID
    let childFields     = $(`.add-input-wrapper #tab_createsub_${config.locales[0]}`)

    let lengthChild = 0; //initial form-group count
    let x = 0 // increment box
    $(add_button).on('click', function(e){ //on add input button click
        lengthChild = childFields.find('.form-group').length
        let labelInput = ``
        e.preventDefault();
        if(lengthChild < max_fields){ //max input box allowed
            config.locales.forEach(locale => {
                if(lengthChild == 0) labelInput = `<label for="${locale}_${nameInput}">Sub Category Name ( ${locale} )</label>`
                $appendInput = `${labelInput}<div class="form-group input-group" data-increment-index="${x}"><input class="form-control" placeholder="${placeholder}" name="${locale}_${nameInput}" type="text"></input><span class="input-group-addon"><a href="#" id="${locale}_remove_filed-${x}" class="remove_field">Remove</a></span></div>` //add input box
                $(wrapper).find(`#tab_createsub_${locale}`).append($appendInput)
            });
            wrapper.removeClass('hidden')
            
            x++; //text box increment
        }
    });

    $(wrapper).on("click",".remove_field", function(e){ 
        let index = this.id.split('-')[1]
        e.preventDefault(); 
        config.locales.forEach(locale => {
            $(wrapper).find(`[data-increment-index="${index}"]`).remove()
            lengthChild = childFields.find('.form-group').length
            if(lengthChild < 1) {
                $(`[for="${locale}_${nameInput}"]`).remove()
            }
        });
        if(lengthChild < 1) {
            wrapper.addClass('hidden')
        }
    })
}

jQuery(function($) {
    // $('.form-checkbox').iCheck({
    //     checkboxClass: 'icheckbox_flat-blue',
    //     radioClass: 'iradio_flat-blue',
    //     increaseArea: '20%', /* optional */
    //     insert: '<div class="form-group"></div>'
    //   });

    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    // CKEDITOR.replaceAll('ck-editor')
    $('.ck-editor').ckeditor()

    $('.btn-logout').on('click', function(e) {
        e.preventDefault()
        let token = getCookie('auth_token')
        let urlApi = $(this).attr('data-api')
        let locationHref = $(this).attr('data-route')
        $.ajax({
            method: 'post',
            url: urlApi,
            headers: {
                'Authorization': token ? `Bearer ${token}` : '',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },success:function(res, textStatus, xhr) {
                if(xhr.status == 200) {
                    eraseCookie('auth_token')
                    window.location = locationHref
                }
            },
            error:function(res){}
        })
    })
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
                            alertMessage(res.message, res.data.message, 'fa fa-check-circle')
                            var oTable = $(table).DataTable()
                            oTable.ajax.reload()
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
