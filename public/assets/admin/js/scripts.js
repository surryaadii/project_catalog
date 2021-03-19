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
