Vue.component('seguimiento-lista-2', {
    template:'#seguimiento-lista-2',
    data:()=>({
        periodo:moment().format('MMMM YYYY'),

        completado:false,
        showModal:false,
        mensaje_entre_componentes_1:null,
        grupos:[],
        campos:[],
        nivel_usuario:null,
        mostrar_check:false,
        nombre_centro:null



    }),
    created:function(){
        console.log('created')

    },
    mounted:function(){
        this.listar_grupos();
    },
    updated:function(){
        console.log('updated')

    },
    destroyed:function(){
        console.log('destroyed')
    },
    methods:{

        traer_datos_usuario(){
            this.$http.post('traer_datos_usuario?view',{}).then(function(response){

                if( response.body.data != undefined){

                }
            });
        },
        completar_grupo(id_modulo){
            let estado_completo = 0;

            if ($("#"+id_modulo).is(':checked')) {
                estado_completo =1;
            }

            this.$http.post('completar_grupo?view',{id_modulo:id_modulo, estado_completo:estado_completo}).then(function(response){
                if( response.body.resultado ){
                    swal("", "Registro Exitoso", "success");


                    this.listar_grupos();
                }else{
                    swal("", "Ha ocurrido un error", "error");
                    this.listar_grupos();
                }

            });

        },

        ver_modulo(nombre_tabla){

            this.mensaje_entre_componentes(nombre_tabla);
            window.location.hash='#seguimiento-lista-3';
        },
        mensaje_entre_componentes(id_grupo){
            var input = document.createElement("input");
            input.type = "hidden";
            input.id = "mensaje_entre_componentes_2";
            input.value = id_grupo;
            document.body.appendChild(input);

            var input2 = document.createElement("input");
            input2.type = "hidden";
            input2.id = "id_centro";
            input2.value = this.mensaje_entre_componentes_1;
            document.body.appendChild(input2);
        },
        listar_grupos(){
            if(this.mensaje_entre_componentes_1==null){
                let id_centro = document.getElementById("mensaje_entre_componentes_1").value;
                this.mensaje_entre_componentes_1 = id_centro;
                this.remover_mensaje_entre_componentes();
            }

            this.$http.post('buscar_grupos?view',{id_centro:this.mensaje_entre_componentes_1}).then(function(response){

                if(response.body.data){
                    this.grupos = response.body.data;
                    this.nivel_usuario = response.body.nivel_usuario;
                    this.nombre_centro = response.body.datos_centro[0]["NOM_CA"];

                }else{
                    swal("", "Ha ocurrido un error", "error")
                }





            });
        },
        remover_mensaje_entre_componentes(){
            var input = document.getElementById("mensaje_entre_componentes_1");
            input.parentNode.removeChild(input)
          }

    }
  })
