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
      { path: '/nna_seguimiento_salud', component: nna_seguimiento_salud },
      { path: '/nna_seguimiento_terapia_ocupacional', component: nna_seguimiento_terapia_ocupacional },
      { path: '/nna_seguimientos_educacion', component: nna_seguimientos_educacion },
      { path: '/nna_seguimientos_nutricion', component: nna_seguimientos_nutricion },
      { path: '/nna_seguimientos_psicologico', component: nna_seguimientos_psicologico },
      { path: '/nna_seguimientos_salud', component: nna_seguimientos_salud },
      { path: '/nna_seguimientos_trabajo_social', component: nna_seguimientos_trabajo_social },
      { path: '/nna_trabajo_social', component: nna_trabajo_social },
      { path: '/pam_actividades_prevencion', component: pam_actividades_prevencion },
      { path: '/pam_actividades_sociales', component: pam_actividades_sociales },
      { path: '/pam_actividades_sociorecreativas', component: pam_actividades_sociorecreativas },
      { path: '/pam_atenciones_salud', component: pam_atenciones_salud },
      { path: '/pam_centro_servicios', component: pam_centro_servicios },
      { path: '/pam_datos_admision', component: pam_datos_admision },
      { path: '/pam_datos_condiciones_ingreso', component: pam_datos_condiciones_ingreso },
      { path: '/pam_datos_generales_egreso', component: pam_datos_generales_egreso },
      { path: '/pam_datos_identificacion_residente', component: pam_datos_identificacion_residente },
      { path: '/pam_datos_nutricion_salud', component: pam_datos_nutricion_salud },
      { path: '/pam_datos_nutricion', component: pam_datos_nutricion },
      { path: '/pam_datos_psicologico', component: pam_datos_psicologico },
      { path: '/pam_datos_salud_mental', component: pam_datos_salud_mental },
      { path: '/pam_datos_salud', component: pam_datos_salud },
      { path: '/pam_datos_trabajo_social', component: pam_datos_trabajo_social },
      { path: '/ppd_datos_actividades_tecnico_productivas', component: ppd_datos_actividades_tecnico_productivas },
      { path: '/ppd_datos_admision_usuario', component: ppd_datos_admision_usuario },
      { path: '/ppd_datos_atencion_psicologica', component: ppd_datos_atencion_psicologica },
      { path: '/ppd_datos_atencion_salud', component: ppd_datos_atencion_salud },
      { path: '/ppd_datos_atencion_trabajoSocial', component: ppd_datos_atencion_trabajoSocial },
      { path: '/ppd_datos_centro_servicios', component: ppd_datos_centro_servicios },
      { path: '/ppd_datos_condicion_ingreso', component: ppd_datos_condicion_ingreso },
      { path: '/ppd_datos_educacion_participacionLaboral', component: ppd_datos_educacion_participacionLaboral },
      { path: '/ppd_datos_egreso_educacion', component: ppd_datos_egreso_educacion },
      { path: '/ppd_datos_egreso_generales', component: ppd_datos_egreso_generales },
      { path: '/ppd_datos_egreso_nutricion', component: ppd_datos_egreso_nutricion },
      { path: '/ppd_datos_egreso_psicologica', component: ppd_datos_egreso_psicologica },
      { path: '/ppd_datos_egreso_salud', component: ppd_datos_egreso_salud },
      { path: '/ppd_datos_egreso_terapiaFisica', component: ppd_datos_egreso_terapiaFisica },
      { path: '/ppd_datos_egreso_trabajoSocial', component: ppd_datos_egreso_trabajoSocial },
      { path: '/ppd_datos_identificacion_residente', component: ppd_datos_identificacion_residente },
      { path: '/ppd_datos_salud_mental', component: ppd_datos_salud_mental },
      { path: '/ppd_datos_salud_nutricion', component: ppd_datos_salud_nutricion },
      { path: '/ppd_datos_terapia', component: ppd_datos_terapia },
      { path: '/registro_locales', component: registro_locales },
      { path: '/registro_perfiles', component: registro_perfiles },
      { path: '/pide_consulta', component: pide_consulta },
      { path: '/reporte_matriz_general', component: reporte_matriz_general },
      { path: '/reporte_nominal', component: reporte_nominal },
      { path: '/reporte_rub', component: reporte_rub },
      { path: '/seguimiento_lista_3', component: seguimiento_lista_3 },
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
