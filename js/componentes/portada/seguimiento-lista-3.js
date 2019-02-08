var seguimiento_lista_3= {
    template:'#seguimiento-lista-3',
    data:()=>({
        periodo:moment().format('MMMM YYYY'),

        completado:false,
        showModal:false,
        id_centro:null,
        nombre_centro:null,

        campos:[],
        cabeceras:[],

        nombre_residente:null,
        isLoading:false,
        mes:moment().format("M"),
        anio:(new Date()).getFullYear(),
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null


    }),
    created:function(){
    },
    mounted:function(){

        this.listar_campos();
    },
    updated:function(){
    },
    methods:{

        traer_datos_usuario(){
            this.$http.post('traer_datos_usuario?view',{}).then(function(response){

                if( response.body.data != undefined){

                }
            });
        },



        listar_campos(){
            if(this.mensaje_entre_componentes_1==null){
                let nombre_tabla = document.getElementById("mensaje_entre_componentes_2").value;
                this.id_centro = document.getElementById("id_centro").value;
                this.mensaje_entre_componentes_2 = nombre_tabla;
                this.remover_mensaje_entre_componentes();
            }

            this.$http.post('mostrar_modulo?view',{nombre_tabla:this.mensaje_entre_componentes_2, id_centro:this.id_centro}).then(function(response){
                if(response.body.data){
                    let arr = [];
                    let valores = response.body.data;
                    let cabeceras;

                    for (let index = 0; index < valores.length; index++) {
                        arr.push(Object.values(valores[index]));
                        if (index==0) {
                            cabeceras= Object.keys(valores[index]);
                        }
                    }
                    this.campos = arr;
                    this.cabeceras = cabeceras;
                    this.nombre_centro = response.body.datos_centro[0]["NOM_CA"];
                this.remover_mensaje_entre_componentes();
                }else{
                    swal("", "No hay registros hasta la fecha", "error")
                }

            });
        },
        remover_mensaje_entre_componentes(){
            var input = document.getElementById("mensaje_entre_componentes_2");
            var input2 = document.getElementById("id_centro");

            input.parentNode.removeChild(input)
          }

    }
  }
