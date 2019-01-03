Vue.component('seguimiento-lista-3', {
    template:'#seguimiento-lista-3',
    data:()=>({
        periodo:moment().format('MMMM YYYY'),
    
        completado:false,
        showModal:false,
   
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

        
       
        listar_campos(){
            console.log("listar_campos");
            if(this.mensaje_entre_componentes_1==null){
                let nombre_tabla = document.getElementById("mensaje_entre_componentes_2").value; 
                this.mensaje_entre_componentes_2 = nombre_tabla;
                this.remover_mensaje_entre_componentes();
            }
           
            this.$http.post('mostrar_modulo?view',{nombre_tabla:this.mensaje_entre_componentes_2}).then(function(response){
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
                console.log(this.campos);
                console.log(cabeceras);
                this.remover_mensaje_entre_componentes();
                }else{
                    swal("", "No hay registros hasta la fecha", "error")
                }
                
            });
        },
        remover_mensaje_entre_componentes(){
            var input = document.getElementById("mensaje_entre_componentes_2"); 
            input.parentNode.removeChild(input)
          }

    }
  })
