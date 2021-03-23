jQuery(function($) {
    function users(res, locationHref = '', statusCode) {
        if(statusCode == 200) {
            alertMessage(res.message, res.data.message, 'fa fa-check-circle')
            eraseInput()
        }
    }
    onSubmitAjax(users)

})