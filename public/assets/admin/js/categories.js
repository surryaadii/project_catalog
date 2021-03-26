jQuery(function($) {
    function categories(res, locationHref = '', statusCode) {
        if(statusCode == 200) eraseInput()
        if(res.data) alertMessage(res.message, res.data.message, 'fa fa-check-circle', true)
    }
    onSubmitAjax(categories)
    addNewInputFieldText('sub_category_name[]', 'Sub Category Name')

})