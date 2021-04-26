jQuery(function($) {
    function pages(res, locationHref = '', statusCode) {
        if(statusCode == 200) eraseInput()
        if(res.data) alertMessage(res.message, res.data.message, 'fa fa-check-circle')
    }
    onSubmitAjax(pages)
})