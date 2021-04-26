var table;
$(document).ready(function() {
    table = $('#data-table');
    var api = table.data('api');
    var apiDownload = table.data('api-download')
    var route = table.data('route')
    let token = getCookie('auth_token')
    table.DataTable({
        pageLength: 10,
        processing: true,
        serverSide: true,
        dom: '<"html5buttons">Blfrtip',
        language: {
                buttons: {
                    colvis : 'show / hide', // label button show / hide
                    colvisRestore: "Reset Kolom" //lael untuk reset kolom ke default
                }
        },
        searchDelay: 1000,
        
        buttons : [
                    {extend: 'colvis', postfixButtons: [ 'colvisRestore' ] },
                    {extend:'csv'},
                    {extend: 'pdf', title:'Contoh File PDF Datatables'},
                    {extend: 'excel', title: 'Contoh File Excel Datatables'},
                    {extend:'print',title: 'Contoh Print Datatables'},
        ],
        ajax: {
            "url"  : api,
            "headers": { 
                'Authorization': `Bearer ${token}` ,
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            // "data" : function (d) {
            //         d.filter_periode = $('#filter_periode').val();
            // }
        },
        columns: [
            {
                "data":"name",
                "class": "col-md-2"
            },
            {"data":"url"},
            {"data":"size"},
            {"data":"created_at"},
            {
                "data": null,
                "render": function render(data, type, full, meta) {
                    var btnEdit = '<a href="javascript:void(0)" class="btn btn-sm btn-info btn-download" ><i class="fa fa-download"></i></a> ';
                    var btnDelete = '<a href="javascript:void(0)" class="btn btn-sm btn-danger btn-delete" data-api="' + api + '/' + full.id + '"><i class="fa fa-trash-o"></i></a>';
                    return btnEdit + btnDelete;
                },
                "class": "col-md-1"
            }
        ],
        columnDefs : [
            { "orderable": false, "targets": [1,4] },
            {
                "targets" : 1 ,
                "data": "img",
                "render" : function ( url, type, full) {
                    return '<a href="'+full.url+'" data-fancybox data-caption="'+full.name+'"><img height="200px" width="250px" src="'+full.url+'"/></a>';
                },
                "class": "col-md-3 text-center"
            },
        ],
        order: [[ 3, "desc" ]]
    });
        
    //filter berdasarkan Nama Product
    // $('.filter-name').keyup(function () {
    //     table.column( $(this).data('column'))
    //     .search( $(this).val() )
    //     .draw();
    // });
    //filter Berdasarkan satuan product
    // $('.filter-satuan').change(function () {
    //     table.column( $(this).data('column'))
    //     .search( $(this).val() )
    //     .draw();
    // });
    //filter Berdasarkan periode
    // $('#filter_periode').change(function () {
    //     table.draw();
    // });
    
    var oTable = $('#data-table').DataTable();
    
    // function download assets datatables
    $(document).on('click', 'a.btn-download', function (e) {
        var data = oTable.row( $(this).parents('tr') ).data();
        $.ajax({
            method: 'POST',
            url: apiDownload,
            data: {'id' : data.id},
            xhrFields: {
                responseType: 'blob'
            },
            headers: {
                'Authorization': token ? `Bearer ${token}` : '',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },success:function(res, textStatus, xhr) {
                console.log(new Blob([res], {type: data.mime_type}))
                const url = window.URL.createObjectURL(new Blob([res], {type: data.mime_type}));
                const a = document.createElement('a');
                a.style.display = 'none';
                a.href = url;
                // the filename you want
                a.download = data.name;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
            },
            error:function(res){}
        })
        // window.open(data.url, '_blank')
    })

    $('div.dataTables_filter input').off('keyup.DT input.DT');
 
    var searchDelay = null;
    
    $('div.dataTables_filter input').on('keyup', function() {
        var search = $('div.dataTables_filter input').val();
    
        clearTimeout(searchDelay);
    
        searchDelay = setTimeout(function() {
            if (search != null) {
                oTable.search(search).draw();
            }
        }, 200);
    });
})