jQuery(function($) {
    function auth(res, locationHref = '', statusCode) {
        if(statusCode == 200) {
            res.data && res.data.isAllowed ? setCookie('auth_token', res.data.token, 14) : eraseCookie('auth_token')
            if(locationHref !== "") window.location = locationHref  
        }
        if(statusCode == 401) {
            location.reload()
        }
    }
    onSubmitAjax(auth)

})