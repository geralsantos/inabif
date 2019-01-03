Vue.component('nna-seguimiento-nutricion', {
    template: '#nna-seguimiento-nutricion',
    data:()=>({
     
        Intervencion:null,
        Peso:null,
        Talla:null,
        Anemia :null,
                 
        nombre_residente:null,
        isLoading:false,
        mes:moment().format("M"),
        anio:(new Date()).getFullYear(),
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null,
        modal_lista:false,
        pacientes:[]

    }),
    created:function(){
    },
    mounted:function(){
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
               
                Intervencion:this.Intervencion,
                Peso:this.Peso,
                Talla:this.Talla,
                Anemia :this.Anemia,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                
            this.$http.post('insertar_datos?view',{tabla:'NNANutricion', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'NNANutricion', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Intervencion = response.body.atributos[0]["INTERVENCION"];
                    this.Peso = response.body.atributos[0]["PESO"];
                    this.Talla = response.body.atributos[0]["TALLA"];
                    this.Anemia = response.body.atributos[0]["ANEMIA"];
                }
             });

        },
        mostrar_lista_residentes(){
         
            this.id_residente = null;
            this.isLoading = true;
                this.$http.post('ejecutar_consulta_lista?view',{}).then(function(response){

                    if( response.body.data != undefined){
                        this.modal_lista = true;
                        this.isLoading = false;
                        this.pacientes = response.body.data;
                    }else{
                        swal("", "No existe ningún residente", "error")
                    }
                 });
            
        },
        elegir_residente(residente){

            this.Intervencion = null;
            this.Peso = null;
            this.Talla = null;
            this.Anemia = null;

            this.id_residente = residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido = (residente.APELLIDO==undefined)?'':residente.APELLIDO;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'NNANutricion', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Intervencion = response.body.atributos[0]["INTERVENCION"];
                    this.Peso = response.body.atributos[0]["PESO"];
                    this.Talla = response.body.atributos[0]["TALLA"];
                    this.Anemia = response.body.atributos[0]["ANEMIA"];
                }
             });

        }
        
    }
  })
