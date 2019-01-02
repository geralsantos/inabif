Vue.component('reporte-matriz-general', {
    template:'#reporte-matriz-general',
    data:()=>({
       // periodo:moment().format('MMMM YYYY'),
        matrices:[],
        periodo:'mes',
       matriz_general:[],


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

            let periodo = this.periodo;
            this.$http.post('mostrar_matrices?view',{periodo:periodo}).then(function(response){

                if( response.body.data != undefined){
                    this.matrices = response.body.data;
                    
                }
            });

        },
        descargar_reporte_matriz_general(matriz_id){

            let datos = {periodo:this.periodo,matriz_id:matriz_id};
            this.$http.post('descargar_reporte_matriz_general?view',datos).then(function(response){

                if( response.body.data != undefined){
                    tableToExcel('tbl_temp','ExcelExport',response.body.data);
                    this.matriz_general = response.body.data;
                    
                }
            });

        },
     

    }
  })
