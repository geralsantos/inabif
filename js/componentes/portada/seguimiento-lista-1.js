Vue.component('seguimiento-lista-1', {
    template:'#seguimiento-lista-1',
    data:()=>({
        periodo:moment().format('MMMM YYYY'),
        matriz:false,
        mostrar_completado:false,
        completo:false,
       centros:[],
       usuario:[],
       tipo_centro:false,
       tipo_centro_completado : [],
       fecha:null,
       acceso_generar :true,
       acceso_completar:true


    }),
    created:function(){
    },
    mounted:function(){
        this.buscar_centros();
        this.traer_datos_usuario();
        this.buscar_tipo_centro();
        this.traer_tipo_centro_completado();
    },
    updated:function(){
    },
    beforeDestroy() {
        console.log('Main Vue destroyed')
      },
    methods:{


        traer_datos_usuario(){
            this.$http.post('traer_datos_usuario?view',{}).then(function(response){

                if( response.body.data != undefined){
                    this.usuario = response.body.data[0];

                    if(this.usuario.NIVEL == 5 ){
                        this.mostrar_completado = true;
                    }

                }
            });
        },
        traer_tipo_centro_completado(){
            this.$http.post('traer_tipo_centro_completado?view',{}).then(function(response){

                if( response.body.data != undefined){
                    this.tipo_centro_completado = response.body.data;

                }
            });
        },
        buscar_tipo_centro(){
            this.$http.post('traer_tipo_centro_completado?view',{}).then(function(response){

                if( response.body.data != undefined){

                    if(response.body.data[0]["ESTADO"]==1){
                        this.tipo_centro = true;
                    }else{
                        this.tipo_centro = false;
                    }


                }
            });
        },
        completar_tipo_centro(){

            if(this.tipo_centro ){
                this.tipo_centro = false
            }else{
                this.tipo_centro = true
            }
            if(this.acceso_generar==false){
                this.tipo_centro = false;
                swal("", "No puedes completar hasta que todas las matrices deben estar generadas", "error");
                return false;
            }


            let estado = 1;
            if(this.tipo_centro){
                estado = 0;
                this.tipo_centro=false;
            }else{
                this.tipo_centro=true;
            }
            this.$http.post('completar_tipo_centro?view',{estado:estado}).then(function(response){
                if( response.body.resultado){
                    swal("", "Cambio realizado", "success");
                }else{
                    swal("", "Ha ocurrido un error", "error");
                }
            });
        },
        buscar_centros(){
            this.centros=[];
            this.$http.post('buscar_centros?view',{}).then(function(response){

                if( response.body.data != undefined){

                    for (let index = 0; index < response.body.data.length; index++) {
                        if(isempty(response.body.data[index]["FECHA_MATRIZ"])){
                            this.acceso_generar = false;
                        }
                        console.log(response.body.data[index]["FECHA_MATRIZ"]);
                       response.body.data[index]["FECHA_MATRIZ"]= (isempty(response.body.data[index]["FECHA_MATRIZ"]))?'': moment(response.body.data[index]["FECHA_MATRIZ"], "YY-MMM-DD").format("DD-MM-YYYY");
                    }
                    console.log(response.body.data);
                    this.centros = response.body.data;
                }


            });

        },

        completar_matriz(id_centro){
            console.log("completar_matriz");
            this.$http.post('completar_matriz?view',{id_centro:id_centro}).then(function(response){

                if( response.body.resultado ){
                    swal("", "Centro completado", "success");
                    this.matriz = true;
                    this.buscar_centros();
                }else{
                    swal("", "Ha ocurrido un error", "error");
                    this.buscar_centros();
                }
            });
        },
        verificar_centro(id_centro){
            this.$http.post('buscar_grupos?view',{id_centro:id_centro}).then(function(response){
                if(response.body.data){

                    for (let index = 0; index < response.body.data.length; index++) {
                        if(isempty(response.body.data[index]["ESTADO_COMPLETO"])){
                            this.acceso_completar= false;
                        }

                    }
                    if(this.acceso_completar){
                        this.completar_matriz(id_centro);

                    }else{
                        swal("", "No puede cambiar el estado hasta que los grupos estén completados", "error");
                        this.buscar_centros();
                    }
                }else{
                    swal("", "Ha ocurrido un error", "error");
                    this.buscar_centros();
                }

            });
        },
        generar_matriz(id_centro){
            console.log("generar_matriz");
            this.$http.post('generar_matriz?view',{id_centro:id_centro}).then(function(response){

                if( response.body.resultado ){
                    swal("", "Matriz Generada", "success");

                    //this.mostrar_completado = false;
                    this.buscar_centros();
                }else{
                    swal("", "Ha ocurrido un error", "error");
                    this.buscar_centros();
                }
            });
        },
        generar_matriz_general(){

            this.$http.post('generar_matriz_consolidado?view',{}).then(function(response){

                if( response.body.resultado ){

                    swal("", "Matriz General Generada", "success");
                    this.buscar_centros();
                }else{
                    if(response.body.fecha){
                        this.fecha = "La matriz fue generada el: " + moment(response.body.fecha, "YY-MMM-DD").format("DD-MM-YYYY");
                    }
                    swal("", response.body.mensaje, "error");
                    this.buscar_centros();
                }
            });
        },
        ver_grupos(centro_id){
          //  alert(centro_id);
            this.mensaje_entre_componentes(centro_id);
            window.location.hash='#seguimiento-lista-2';

        },
        mensaje_entre_componentes(centro_id){
            var input = document.createElement("input");
            input.type = "hidden";
            input.id = "mensaje_entre_componentes_1";
            input.value = centro_id;
            document.body.appendChild(input);
          }


    }
  })
