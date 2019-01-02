Vue.component('reporte-matriz-general', {
    template:'#reporte-matriz-general',
    data:()=>({
       // periodo:moment().format('MMMM YYYY'),
        matrices:[],
        periodo:'mes',
       


    }),
    created:function(){
    },
    mounted:function(){
        this.buscar_centros();

    },
    updated:function(){
    },
    beforeDestroy() {
        console.log('Main Vue destroyed')
      },
    methods:{
       
     
        mostrar_matrices(){

            let periodo = this.periodo;
            this.$http.post('recuperar_matriz_general?view',{perido:periodo}).then(function(response){

                if( response.body.data != undefined){
                    this.matrices = response.body.data;
                    
                }
            });

        },

     

    }
  })
