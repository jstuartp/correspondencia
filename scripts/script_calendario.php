 <script>
      $(document).ready(function() {
    
    $('#calendar').fullCalendar({
        defaultView: 'agendaWeek',
    axisFormat: 'HH:mm',
    ignoreTimezone: "true",
    businessHours:{
        start: '08:00', 
        end: '17:00',
        dow: [ 1, 2, 3, 4, 5 ]
        },
    lang: 'es',
    allDaySlot:false,
    format: 'DD/MM/YYYY',
    defaultDate: '<?php echo date('Y-m-d');?>',
    selectable: true,
    selectHelper: true,
    select: function(start, end) {
       inicio=moment(start).format('DD/MM/YYYY HH:mm');
       fin=moment(end).format('DD/MM/YYYY HH:mm');
       $('#calendarModal #apptStartTime').val(inicio);
       $('#calendarModal #apptEndTime').val(fin);
       $('#calendarModal #when').text(inicio+' hasta '+fin);
       $('#calendarModal').modal('show');

        
      },
      editable: false,
      
      
      events: [
      
      <?php CalcularHorasPistaReservadas(GetSQLValueString($_GET["id"], "int"));?>
      ]


    });
    
/*    $('#submitButton').on('click', function (e) {
        // We don't want this to act as a link so cancel the link action
        e.preventDefault();
        doSubmit();
      });*/

    
  });
    </script>