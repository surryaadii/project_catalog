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
            "data" : function (d) {
                    d.filter_periode = $('#filter_periode').val();
            }
        },
        columns: [
            {"data":"name"},
            {"data":"email"},
            {"data":"created_at"},
        ],
        columnDefs : [{
            render : function (data,type,row){
                return data + ' - ( ' + row['satuan'] + ')'; 
            },
            "targets" : 0
            },
            {"visible": false, "targets" : 1}
        ],
        });
        
    //filter berdasarkan Nama Product
    $('.filter-name').keyup(function () {
        table.column( $(this).data('column'))
        .search( $(this).val() )
        .draw();
    });
    //filter Berdasarkan satuan product
    $('.filter-satuan').change(function () {
        table.column( $(this).data('column'))
        .search( $(this).val() )
        .draw();
    });
    //filter Berdasarkan periode
    $('#filter_periode').change(function () {
        table.draw();
    });
})