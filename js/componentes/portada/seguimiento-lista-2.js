Vue.component('seguimiento-lista-2', {
    template:'#seguimiento-lista-2',
    data:()=>({
        periodo:moment().format('MMMM YYYY'),
    
        completado:false,
        showModal:false,
        grupos:[],
        campos:[],

        nombre_residente:null,
        isLoading:false,
        mes:moment().format("MM"),
        anio:(new Date()).getFullYear(),
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null


    }),
    created:function(){
    },
    mounted:function(){
        this.listar_grupos();
    },
    updated:function(){
    },
    methods:{
        guardar(){
            if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'success');
                return false;
            }
            let valores = {
                

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }

            this.$http.post('insertar_datos?view',{tabla:'CarTerapia', valores:valores}).then(function(response){

                if( response.body.resultado ){
                    swal('', 'Registro Guardado', 'success');

                }else{
                  swal("", "Un error ha ocurrido", "error");
                }
            });
        },
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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarTerapia', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                   


                }
             });

        },
        traer_datos_usuario(){
            this.$http.post('traer_datos_usuario?view',{}).then(function(response){

                if( response.body.data != undefined){
                    
                }
            });
        },

        mostrar_modulo(id_grupo){
          
            this.$http.post('buscar_modulo?view',{id_grupo:id_grupo}).then(function(response){
                this.campos = response.body.data[0];
                this.showModal = true;
                
            });
        },
        listar_grupos(){
            let id_centro = document.getElementById("mensaje_entre_componentes"); 
            this.$http.post('buscar_grupos?view',{id_centro:id_centro}).then(function(response){
                this.grupos = response.body.data[0];
                this.showModal = true;
                
            });
        },
        remover_mensaje_entre_componentes(){
            var input = document.getElementById("mensaje_entre_componentes"); 
            input.parentNode.removeChild(input)
          }

    }
  })
