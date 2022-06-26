<script src="{{ asset('argon') }}/vendor/dataTables/jquery.dataTables.min.js"></script>
<script src="{{ asset('argon') }}/vendor/dataTables/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('argon') }}/vendor/dataTables/dataTables.buttons.min.js"></script>
<script src="{{ asset('argon') }}/vendor/dataTables/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('argon') }}/vendor/dataTables/buttons.html5.min.js"></script>
<script src="{{ asset('argon') }}/vendor/dataTables/buttons.flash.min.js"></script>
<script src="{{ asset('argon') }}/vendor/dataTables/buttons.print.min.js"></script>
<script src="{{ asset('argon') }}/vendor/dataTables/dataTables.select.min.js"></script>


<script type="text/javascript">
    $(document).ready(function() {
      $('#datatable-buttons').DataTable();
    });

    $('#datatable-buttons').dataTable( {
      "language": {
        "paginate": {
          "previous": "<",
          "next": ">"
        }
      }
    });
</script>
