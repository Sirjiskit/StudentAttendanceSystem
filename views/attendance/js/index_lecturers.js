/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    var table = $("#tblLists").DataTable({
        "ajax": window.siteurl + "lectures/lecturertableLists",
        "order": [[0, "desc"]],
        "columnDefs": [
            {
//                "targets": [5],
//                "sortable": false,
//                "searchable": false
            },
            {
                "targets": [0],
                "sortable": false,
                "searchable": false,
                "visible": false
            }
        ]
    });
});