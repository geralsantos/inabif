


<script type="text/javascript">
  /*$(document).ready(function () {
      initModalAjax();
      <?php $this->getReady(); ?>
  });*/
</script>

  <script type="text/javascript" src="<?php echo JS ?>/sweetAlert.min.js"></script>

  <!--script type="text/javascript" src="<?php echo JS ?>/materialize.min.js"></script!-->

  <script type="text/javascript" src="<?php echo JS ?>/jquery.min.js"></script>
  <script src="<?php echo JS ?>/datepicker.min.js"></script>
  <script src="<?php echo JS ?>/datepicker.es-ES.js"></script>
  <script type="text/javascript" src="<?php echo JS ?>/moment.min.js"></script>
  <script type="text/javascript" src="<?php echo JS ?>/moment-range.min.js"></script>
  <script type="text/javascript">
    window['moment-range'].extendMoment(moment);
  </script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>  
    <script src="<?php echo ASSETS ?>/js/blob.min.js"></script>
    <script src="<?php echo ASSETS ?>/js/xlsx.core.min.js"></script>
    <script src="<?php echo ASSETS ?>/js/filesaver.min.js"></script>
    
  <script src="https://cdnjs.cloudflare.com/ajax/libs/TableExport/3.3.13/js/tableexport.min.js"></script>
  <script type="text/javascript" src="<?php echo JS ?>/utils.js"></script>

  <script type="text/javascript" src="<?php echo JS ?>/vue/vue.min.js"></script>
  <script type="text/javascript" src="<?php echo JS ?>/vue/vue-resources.min.js"></script>

  <?php foreach (glob(JS_ROOT . DS . 'componentes' . DS ."portada/*.js") as $filename): ?>
  <script type="text/javascript" src="<?php echo JS . '/componentes/portada/'. basename($filename); ?>"></script>
<?php endforeach;?>

  <script src="<?php echo JS ?>/highcharts/highcharts.js"></script>
  <script src="<?php echo JS ?>/highcharts/data.min.js"></script>
  <script src="<?php echo JS ?>/highcharts/exporting.js"></script>
  <script src="<?php echo JS ?>/highcharts/export-data.js"></script>
  <script src="<?php echo JS ?>/highcharts/drilldown.js"></script>
  <script src="<?php echo JS ?>/highcharts/histogram-bellcurve.js"></script>
  <!-- ASSETS JS -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
  <script src="<?php echo ASSETS ?>/js/plugins.js"></script>
  <script src="<?php echo ASSETS ?>/js/main.js"></script>

  <script src="<?php echo ASSETS ?>/js/lib/chart-js/Chart.bundle.js"></script>

  <script src="<?php echo ASSETS ?>/js/dashboard.js"></script>
  <script src="<?php echo ASSETS ?>/js/widgets.js"></script>
  <script src="<?php echo ASSETS ?>/js/lib/vector-map/jquery.vmap.js"></script>
  <script src="<?php echo ASSETS ?>/js/lib/vector-map/jquery.vmap.min.js"></script>
  <script src="<?php echo ASSETS ?>/js/lib/vector-map/jquery.vmap.sampledata.js"></script>
  <script src="<?php echo ASSETS ?>/js/lib/vector-map/country/jquery.vmap.world.js"></script>

  <script src="<?php echo ASSETS ?>/js/popper.min.js"></script>
  <script type="text/javascript" src="<?php echo JS ?>/vue/app.js"></script>

  </div> <!-- final -->
  <footer>
  <div class="footer-text"> <p>Copyright INABIF & Developed by Colonias.com</p>
  </div>
    </footer>
  </body>
</html>
<script>
    jQuery('p').tooltip({ boundary: 'window' })
    $(function() {
          $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            zIndex: 2048,
            language: 'es-ES',
            format: 'yyyy-mm-dd'
          });
        });

    setTimeout(() => {
      var blob = new Blob(["<table><tr><td>hola</td></tr></table>"], {type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"});
    saveAs(blob, "hello world.xlsx");
    }, 5000);
</script>
