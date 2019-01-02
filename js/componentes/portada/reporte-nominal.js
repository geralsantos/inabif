Vue.component('reporte-nominal', {
    template:'#reporte-nominal',
    data:()=>({

       residentes:[],

       nombre_residente:null,
        isLoading:false,
       
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

            let periodo = this.periodo;
            this.$http.post('mostrar_reporte_nominal?view',{id_residente:this.id_residente}).then(function(response){

                if( response.body.data != undefined){
                    this.matrices = response.body.data;
                    
                }else{
                    swal("", "No hay registros para este reporte", "error");
                }
            });

        },
        descargar_reporte_matriz_general(matriz_id){

            let datos = {periodo:this.periodo,matriz_id:matriz_id};
            console.log(datos);
            this.$http.post('descargar_reporte_matriz_general?view',datos).then(function(response){

                if( response.body.data != undefined){
                    tableToExcel('tbl_temp','ExcelExport',response.body.data);
                    this.matriz_general = response.body.data;
                    
                }
            });

        },
     

    }
  })