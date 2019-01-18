Vue.component('reniec-consulta', {
    template:'#reniec-consulta',
    data:()=>({
        Apellido_p:null,
        Apellido_m:null,
        Nombres:null,
        NumDoc:null,
        nombre_residente:null,
        isLoading:false,
        mes:moment().format("M"),
        anio:(new Date()).getFullYear(),
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null,
        modal_lista:false,
        pacientes:[],
        showModal: false,
        residente_seleccionado :[],
    }),
    created:function(){
    },
    mounted:function(){
     
    },
    methods:{ 

    }
  })
