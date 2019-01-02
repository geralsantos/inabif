Vue.component('reporte-nominal', {
    template:'#reporte-nominal',
    data:()=>({

       residentes:[],

       nombre_residente:null,
        isLoading:false,
       
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null,
        modal_lista:false,


    }),
    created:function(){
    },
    mounted:function(){

    },
    updated:function(){
    },
    beforeDestroy() {
        console.log('Main Vue destroyed')
      },
    methods:{
       
        buscar_residente(){
            this.id_residente = null;

            var word = this.nombre_residente;
            if( word.length >= 4){
                this.coincidencias = [];
                this.bloque_busqueda = true;
                this.isLoading = true;

                this.$http.post('ejecutar_consulta?view',{like:word }).then(function(response){

                    if( response.body.data != undefined){
                        this.isLoading = false;
                        this.coincidencias = response.body.data;
                    }else{
                        this.bloque_busqueda = false;
                        this.isLoading = false;
                        this.coincidencias = [];
                    }
                 });
            }else{
                this.bloque_busqueda = false;
                this.isLoading = false;
                this.coincidencias = [];
            }
        },
        actualizar(coincidencia){
            this.id_residente = coincidencia.ID;
            this.nombre_residente=coincidencia.NOMBRE;
            this.coincidencias = [];
            this.bloque_busqueda = false;

        },
        mostrar_reporte_nominal(){

            this.$http.post('mostrar_reporte_nominal?view',{id_residente:this.id_residente}).then(function(response){

                if( response.body.data != undefined){
                    this.residentes = response.body.data;
                    
                }else{
                    swal("", "No hay registros para este reporte", "error");
                }
            });

        },
        descargar_reporte_matriz_nominal(residente){

            let datos = {id_residente:this.id_residente,tipo_centro_id:residente.TIPO_CENTRO_ID};
            console.log(datos);
            this.$http.post('descargar_reporte_matriz_nominal?view',datos).then(function(response){

                if( response.body.data != undefined){
                    tableToExcel('tbl_temp','ExcelExport',response.body.data);
                    this.matriz_general = response.body.data;
                    
                }
            });

        },
        mostrar_lista_residentes(){
            this.id_residente = null;
            this.isLoading = true;
                this.$http.post('ejecutar_consulta_lista?view',{}).then(function(response){

                    if( response.body.data != undefined){
                        this.modal_lista = true;
                        this.isLoading = false;
                        this.pacientes = response.body.data;
                    }else{
                        swal("", "No existe ningún residente", "error")
                    }
                 });
            
        },
        elegir_residente(residente){

            this.id_residente = residente.ID;
            this.nombre_residente=residente.NOMBRE;

        }
     

    }
  })
