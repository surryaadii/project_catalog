$(document).ready(function() {
    var table = $('#table-product');
    var api = table.data('api');
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
        
        buttons : [
                    {extend: 'colvis', postfixButtons: [ 'colvisRestore' ] },
                    {extend:'csv'},
                    {extend: 'pdf', title:'Contoh File PDF Datatables'},
                    {extend: 'excel', title: 'Contoh File Excel Datatables'},
                    {extend:'print',title: 'Contoh Print Datatables'},
        ],
        ajax: {
            "url"  : api, 
            // "data" : function (d) {
            //         d.filter_periode = $('#filter_periode').val();
            // }
        },
        columns: [
            {"data":"name"},
            {
                "data": null,
                "render": function render(data, type, full, meta) {
                    var btnEdit = '<a href="' + '/roles/' + full.id + '/edit' + '" class="btn btn-sm btn-info"><i class="fa fa-file"></i></a> ';
                    var btnDelete = '<a href="' + '/roles/' + full.id + '" class="btn btn-sm btn-danger btn-delete"><i class="fa fa-trash-o"></i></a>';
                    return btnEdit + btnDelete;
                },
                "class": "col-md-1"
            }
        ],
        columnDefs : [
            {"orderable": false, "targets" : 1}
        ],
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

    var oTable = $('#table-product').DataTable();


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