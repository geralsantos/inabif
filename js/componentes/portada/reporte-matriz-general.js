Vue.component('reporte-matriz-general', {
    template:'#reporte-matriz-general',
    data:()=>({
       // periodo:moment().format('MMMM YYYY'),
        matrices:[],
        periodo_mes:'mes',
        periodo_anio:'mes',
       matriz_general:[],
       meses : [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"
    ]

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
        mostrar_matrices(){

            let obj = {periodo_mes:this.periodo_mes,periodo_anio:this.periodo_anio};
            this.$http.post('mostrar_matrices?view',obj).then(function(response){

                if( response.body.data != undefined){
                    this.matrices = response.body.data;
                    
                }
            });

        },
        descargar_reporte_matriz_general(matriz_id){

            let datos = {periodo_mes:this.periodo_mes,periodo_anio:this.periodo_anio,matriz_id:matriz_id};
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
