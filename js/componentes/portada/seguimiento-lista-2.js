Vue.component('seguimiento-lista-2', {
    template:'#seguimiento-lista-2',
    data:()=>({
        periodo:moment().format('MMMM YYYY'),
    
        completado:false,
        showModal:false,
        mensaje_entre_componentes_1:null,
        grupos:[],
        campos:[],

        nombre_residente:null,
        isLoading:false,
        mes:moment().format("M"),
        anio:(new Date()).getFullYear(),
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null,
 


    }),
    created:function(){
    },
    mounted:function(){
        this.listar_grupos();
    },
    updated:function(){
    },
    destroyed:function(){
        alert("seguimiento 2 destruido");
    },
    methods:{
        guardar(){
            if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'warning');
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
            let nombre=(coincidencia.NOMBRE==undefined)?'':coincidencia.NOMBRE;
let apellido_p = (coincidencia.APELLIDO_P==undefined)?'':coincidencia.APELLIDO_P;
let apellido_m = (coincidencia.APELLIDO_M==undefined)?'':coincidencia.APELLIDO_M;
let apellido = apellido_p + ' ' + apellido_m;
 this.nombre_residente=nombre + ' ' + apellido;
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
        completar_grupo(id_modulo){
            this.$http.post('completar_grupo?view',{id_modulo:id_modulo}).then(function(response){
                if( response.body.resultado ){
                    swal("", "Matriz Generada", "success");

                  
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
        },
        listar_grupos(){
            console.log("listar_grupos");
            if(this.mensaje_entre_componentes_1==null){
                let id_centro = document.getElementById("mensaje_entre_componentes_1").value; 
                this.mensaje_entre_componentes_1 = id_centro;
                this.remover_mensaje_entre_componentes();
            }
            
            this.$http.post('buscar_grupos?view',{id_centro:this.mensaje_entre_componentes_1}).then(function(response){
                this.grupos = response.body.data;

                console.log(this.grupos);
               
                
            });
        },
        remover_mensaje_entre_componentes(){
            var input = document.getElementById("mensaje_entre_componentes_1"); 
            input.parentNode.removeChild(input)
          }

    }
  })
