define(["jquery", "datatables/datatables.min"], function ($) {
    $(document).ready(function () {
      
      var op = {
        responsive: true,
        "order": [[ 6, "desc" ]],
        paging: false
      };

      $('#tb_Email').dataTable(op);
      $('#tb_Domain').dataTable(op);
      $('#tb_IP').dataTable(op);
    });
});