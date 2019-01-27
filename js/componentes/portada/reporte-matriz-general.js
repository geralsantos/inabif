Vue.component('reporte-matriz-general', {
    template:'#reporte-matriz-general',
    data:()=>({
       // periodo:moment().format('MMMM YYYY'),
        matrices:[],
        periodo_mes:moment().format("M"),
        periodo_anio:moment().format("YYYY"),
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
      },
    methods:{
        mostrar_matrices(){
            let self = this;
            let obj = {periodo_mes:moment(self.periodo_mes,"M").format("MMM") ,periodo_anio:this.periodo_anio};
            this.$http.post('mostrar_matrices?view',obj).then(function(response){

                if( response.body.data != undefined){
                    this.matrices = response.body.data;
                    
                }
            });

        },
        descargar_reporte_matriz_general(matriz_id){

            let datos = {periodo_mes:moment(this.periodo_mes,"M").format("MMM"),periodo_anio:this.periodo_anio,matriz_id:matriz_id};
            this.$http.post('descargar_reporte_matriz_general_2?view',datos).then(function(response){

                if( response.body.data != undefined){
                    tableToExcel('tbl_temp','ExcelExport',response.body.data);
                    this.matriz_general = response.body.data;
                    
                }
            });

        },
     

    }
  })
