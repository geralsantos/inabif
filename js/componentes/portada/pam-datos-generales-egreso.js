Vue.component('pam-datos-generales-egreso', {
    template:'#pam-datos-generales-egreso',
    data:()=>({
        Fecha_Egreso:null,
        MotivoEgreso:null,
        Retiro_Voluntario:null,
        Reinsercion_Familiar:null,
        Traslado_Entidad_Salud:null,
        Traslado_Otra_Entidad:null,
        Fallecimiento:null,
        RestitucionAseguramientoSaludo:null,
        Restitucion_Derechos_DNI:null,
        RestitucionReinsercionFamiliar:null,
              
        nombre_residente:null,
        isLoading:false,
        mes:moment().format("MM"),
        anio:(new Date()).getFullYear(),
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null


    }),
    created:function(){
    },
    mounted:function(){

    },
    updated:function(){
    },
    methods:{
        
        
    }
  })
