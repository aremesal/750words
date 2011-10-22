<script type="text/javascript">
$(function(){
  dateSelector=$("#calendarFilterBox").calendarPicker({
    monthNames:["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    dayNames: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
    useWheel:true,
    callbackDelay:500,
    years:1,
    months:3,
    days:4,
    showDayArrows:false,
    callback: function(cal){
       var d = new Date(cal.currentDate);
       getTextByDay(d.getFullYear() + '/' + eval(d.getMonth()+1) + '/' +d.getDate());
       $("#dayDate").html(d.getDate() + '/' + eval(d.getMonth()+1) + '/' +d.getFullYear());
  }});
});
</script>

<?php $this->load->view('layout/partials/opencontent_for_logged'); ?>

    <div id="calendarFilterBox"></div>
    <div id="dvCalendarText">
        <b>Calendario de tus escritos</b>
        <br />
        Selecciona en el calendario el d&iacute;a del que quieras leer lo que escribiste.
        <br /><br />
        <div id="dayCount">El d&iacute;a <span id="dayDate"><?=strftime('%d/%m/%Y')?></span> escribiste <span id="dayCount">0</span> palabras</div>
    </div>
    <br style="clear: both" /><br />
    <div id="dayText" class="typewritter"></div>

<?php $this->load->view('layout/partials/closecontent_for_logged'); ?>

<?php $this->load->view('layout/partials/footer_for_logged'); ?>