{
  'use strict';

  Vue.http.options.emulateJSON=true; // http client
  var appVue = new Vue({
    el:'#vue_app', /* container vue */
    name:'Reveal',
    data: () => ({
      menuVisible: false,
      expandSingle: false,
      selectedDate:new Date('2018/03/26'),
      currentView:(window.location.hash.substr(1) || 'portada-index'),
      htmlrender:'',
      title:'',
    }),
    created:function(){
    },mounted:function(){
      //this.modulos_sidenav();
    },
    watch:{
      currentView:function(val){
      }
    },
    methods: {
      modulos_sidenav:function(){
        document.getElementById('geral').innerHTML = '<li class="menu-item-has-children dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-laptop"></i>Elaboración del Plan de Acción del Centro</a><ul class="sub-menu children dropdown-menu"><li><i class="fa fa-bar-chart"></i><a href="indicador-1.php">Nivel de ejecución del plan de acción del centro MAC</a></li></ul></li>'
        /*this.$http.post('list_modulos?view',{}).then(function(response){
          this.htmlrender = response.body;
          console.log(response.body);
        });*/
      },
      form_submit:function(){
        var data = new FormData(document.querySelector('#login-form'));
        this.$http.post('captcha?view',data).then(function(response){
            if (response.body.success) {
              document.querySelector('#login-form').submit();
            }else{
              let _error = {_code:response.body['error-codes'][0]},error_default=[["missing-input-response","Tiene que completar el CAPTCHA"],["timeout-or-duplicate","Ha duplicado o expirado el CAPTCHA, actualice su navegador."]],response_=[];
              for (var i = 0; i < error_default.length; i++) {
                if (error_default[i][0]==_error._code) {
                  response_ = error_default[i][1];
                }
              }
              swal({
                title: "Ha ocurrido un problema!",
                text: response_+"\ncode_error: "+_error._code,
                icon: "warning",
                button: "Aceptar",
              });
            }
        });
      },
      downloadXML : function(serie_cor,monto,fecha_emision,id_empresa){
        this.$http.post('xml?view',{serie_cor:serie_cor,monto:monto,fecha_emision:fecha_emision,id_empresa:id_empresa}).then(function(response){
            let data = response.body;
            if (isempty(data.xml)) {
              swal("Lo sentimos.", "No existe un XML relacionado a este comprobante!", "warning");
            }else{
              download((data.ruc+"-"+"01"+data.serie+"-"+data.numdoc+".xml"),b64_to_utf8(data.xml));
            }
        });
      },
      toggleMenu () {
        this.menuVisible = !this.menuVisible;
      },
      changeview(val){
        console.log('changeview: ',val);
        this.currentView=val;
          //document.querySelector('.comprobantesestado').style.display= (val!="portadaindex"?'none':'');
      }
    }
  })

}
