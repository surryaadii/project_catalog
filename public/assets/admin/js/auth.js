jQuery(function($) {
    function auth(res, locationHref = '', statusCode) {
        if(statusCode == 200) {
            console.log(locationHref)
            if(res.data.isAllowed) setCookie('auth_token', res.data.token, 14)
            if(locationHref !== "") window.location = locationHref  
        }
    }
    onSubmitAjax(auth)

})