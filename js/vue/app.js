{
  'use strict';

  Vue.use(VueRouter);
  Vue.http.options.emulateJSON=true; // http client
 
  const router = new VueRouter({
    mode: 'hash',
    routes: [
      { path: '/seguimiento-lista-1', component: seguimiento_lista_1 },
      { path: '/seguimiento-lista-2', component: seguimiento_lista_2 },
      { path: '/nna-actividades-sociorecreativas', component: nna_actividades_sociorecreativas },
      { path: '/nna-datos-admision-residente', component: nna_datos_admision_residente },
      { path: '/nna-datos-centro-servicios', component: nna_datos_centro_servicios },
      { path: '/nna-datos-condiciones-ingreso-residente', component: nna_datos_condiciones_ingreso_residente },
      { path: '/nna-datos-familiares-sociales-residente', component: nna_datos_familiares_sociales_residente },
      { path: '/nna-datos-identificacion-inicial-inscripcion-residente', component: nna_datos_identificacion_inicial_inscripcion_residente },
      { path: '/nna-datos-salud-residente', component: nna_datos_salud_residente },
      { path: '/nna-seguimiento-educacion', component: nna_seguimiento_educacion },
      { path: '/nna-seguimiento-fortalecimiento-habilidades', component: nna_seguimiento_fortalecimiento_habilidades },
      { path: '/nna-seguimiento-nutricion', component: nna_seguimiento_nutricion },
      { path: '/nna-seguimiento-psicologico', component: nna_seguimiento_psicologico },
      { path: '/nna-seguimiento-salud', component: nna_seguimiento_salud },
      { path: '/nna-seguimiento-terapia-ocupacional', component: nna_seguimiento_terapia_ocupacional },
      { path: '/nna-seguimientos-educacion', component: nna_seguimientos_educacion },
      { path: '/nna-seguimientos-nutricion', component: nna_seguimientos_nutricion },
      { path: '/nna-seguimientos-psicologico', component: nna_seguimientos_psicologico },
      { path: '/nna-seguimientos-salud', component: nna_seguimientos_salud },
      { path: '/nna-seguimientos-trabajo-social', component: nna_seguimientos_trabajo_social },
      { path: '/nna-trabajo-social', component: nna_trabajo_social },
      { path: '/pam-actividades-prevencion', component: pam_actividades_prevencion },
      { path: '/pam-actividades-sociales', component: pam_actividades_sociales },
      { path: '/pam-actividades-sociorecreativas', component: pam_actividades_sociorecreativas },
      { path: '/pam-atenciones-salud', component: pam_atenciones_salud },
      { path: '/pam-centro-servicios', component: pam_centro_servicios },
      { path: '/pam-datos-admision', component: pam_datos_admision },
      { path: '/pam-datos-condiciones-ingreso', component: pam_datos_condiciones_ingreso },
      { path: '/pam-datos-generales-egreso', component: pam_datos_generales_egreso },
      { path: '/pam-datos-identificacion-residente', component: pam_datos_identificacion_residente },
      { path: '/pam-datos-nutricion-salud', component: pam_datos_nutricion_salud },
      { path: '/pam-datos-nutricion', component: pam_datos_nutricion },
      { path: '/pam-datos-psicologico', component: pam_datos_psicologico },
      { path: '/pam-datos-salud-mental', component: pam_datos_salud_mental },
      { path: '/pam-datos-salud', component: pam_datos_salud },
      { path: '/pam-datos-trabajo-social', component: pam_datos_trabajo_social },
      { path: '/ppd-datos-actividades-tecnico-productivas', component: ppd_datos_actividades_tecnico_productivas },
      { path: '/ppd-datos-admision-usuario', component: ppd_datos_admision_usuario },
      { path: '/ppd-datos-atencion-psicologica', component: ppd_datos_atencion_psicologica },
      { path: '/ppd-datos-atencion-salud', component: ppd_datos_atencion_salud },
      { path: '/ppd-datos-atencion-trabajoSocial', component: ppd_datos_atencion_trabajoSocial },
      { path: '/ppd-datos-centro-servicios', component: ppd_datos_centro_servicios },
      { path: '/ppd-datos-condicion-ingreso', component: ppd_datos_condicion_ingreso },
      { path: '/ppd-datos-educacion-participacionLaboral', component: ppd_datos_educacion_participacionLaboral },
      { path: '/ppd-datos-egreso-educacion', component: ppd_datos_egreso_educacion },
      { path: '/ppd-datos-egreso-generales', component: ppd_datos_egreso_generales },
      { path: '/ppd-datos-egreso-nutricion', component: ppd_datos_egreso_nutricion },
      { path: '/ppd-datos-egreso-psicologica', component: ppd_datos_egreso_psicologica },
      { path: '/ppd-datos-egreso-salud', component: ppd_datos_egreso_salud },
      { path: '/ppd-datos-egreso-terapiaFisica', component: ppd_datos_egreso_terapiaFisica },
      { path: '/ppd-datos-egreso-trabajoSocial', component: ppd_datos_egreso_trabajoSocial },
      { path: '/ppd-datos-identificacion-residente', component: ppd_datos_identificacion_residente },
      { path: '/ppd-datos-salud-mental', component: ppd_datos_salud_mental },
      { path: '/ppd-datos-salud-nutricion', component: ppd_datos_salud_nutricion },
      { path: '/ppd-datos-terapia', component: ppd_datos_terapia },
      { path: '/registro-locales', component: registro_locales },
      { path: '/registro-perfiles', component: registro_perfiles },
      { path: '/pide-consulta', component: pide_consulta },
      { path: '/reporte-matriz-general', component: reporte_matriz_general },
      { path: '/reporte-nominal', component: reporte_nominal },
      { path: '/reporte-rub', component: reporte_rub },
      { path: '/seguimiento-lista-3', component: seguimiento_lista_3 },
      { path: '/cargar-archivos', component: cargar_archivos },
      
    ]
});
  var appVue = new Vue({
    el:'#vue_app', /* container vue */
    router,
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
    beforeDestroy() {
    },
    methods: {
      form_submit:function(){
        var data = new FormData(document.querySelector('#login-form'));
        this.$http.post('captcha?view',data).then(function(response){
          (response.body);
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
      modulos_sidenav:function(){
        document.getElementById('geral').innerHTML = '<li class="menu-item-has-children dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-laptop"></i>Elaboración del Plan de Acción del Centro</a><ul class="sub-menu children dropdown-menu"><li><i class="fa fa-bar-chart"></i><a href="indicador-1.php">Nivel de ejecución del plan de acción del centro MAC</a></li></ul></li>'
        /*this.$http.post('list_modulos?view',{}).then(function(response){
          this.htmlrender = response.body;
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
     
        this.currentView=val;
        
      }
    }
  })

}
