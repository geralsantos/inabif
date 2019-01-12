Vue.component('reporte-rub', {
    template:'#reporte-rub',
    data:()=>({
       // periodo:moment().format('MMMM YYYY'),
        residentes:[],
        periodo:'mes',
       data_reporte_rub:[],
       fecha_final:null,
       fecha_inicial:null,


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
       
     
        mostrar_reporte_rub(){

            let fecha_inicial = moment(this.fecha_inicial, "YYYY-MM-DD").format("YY-MMM-DD");
            let fecha_final = moment(this.fecha_final, "YYYY-MM-DD").format("YY-MMM-DD");
            this.$http.post('mostrar_reporte_rub?view',{fecha_inicial:fecha_inicial, fecha_final:fecha_final}).then(function(response){

                if( response.body.data != undefined){
                    swal("Existen registros", "Si hay datos para este reporte, favor de hacer click en Descargar Reporte", "success")
                }else{
                    swal("", "no hay datos para este reporte", "error")
                }
            });

        },
        descargar_reporte_matriz_rub(){
            let fecha_inicial = moment(this.fecha_inicial, "YYYY-MM-DD").format("YY-MMM-DD");
            let fecha_final = moment(this.fecha_final, "YYYY-MM-DD").format("YY-MMM-DD");
            this.$http.post('descargar_reporte_matriz_rub?view',{fecha_inicial:fecha_inicial, fecha_final:fecha_final}).then(function(response){

                if( response.body.data != undefined){
                    tableToExcel('tbl_temp','ExcelExport',response.body.data);
                    this.data_reporte_rub = response.body.data;
                    
                }
            });

        },
     

    }
  })
