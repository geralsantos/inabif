Vue.component('reporte-rub', {
    template:'#reporte-rub',
    data:()=>({
       // periodo:moment().format('MMMM YYYY'),
        residentes:[],
        periodo:'mes',
       matriz_general:[],
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
                    this.residentes = response.body.data;
                    
                }else{
                    swal("", "no hay datos para este reporte", "error")
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
