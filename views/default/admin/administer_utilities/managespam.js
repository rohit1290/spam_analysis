define(["jquery", "datatables/datatables.min"], function ($) {
    $(document).ready(function () {
      
      var index = $('#tb_Email').find('th:last').index();
      
      var op = {
        responsive: true,
        "order": [[ index, "desc" ]],
        paging: false
      };

      $('#tb_Email').dataTable(op);
      $('#tb_Domain').dataTable(op);
      $('#tb_IP').dataTable(op);
    });
});