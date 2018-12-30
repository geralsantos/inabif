Vue.component('nna-seguimiento-fortalecimiento-habilidades', {
    template: '#nna-seguimiento-fortalecimiento-habilidades',
    data:()=>({
     
        Participacion:null,
        FInicio_Actividades:null,
        FFin_Actividades:null,
        Termino_Actividades :null,
        Fortalecer_Actividades :null,
          
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
               
                Participacion:this.Participacion,
                FInicio_Actividades:moment(this.FInicio_Actividades).format("YY-MMM-DD"),
                FFin_Actividades:moment(this.FFin_Actividades).format("YY-MMM-DD"),
                Termino_Actividades :this.Termino_Actividades,
                Fortalecer_Actividades :this.Fortalecer_Actividades,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                
            this.$http.post('insertar_datos?view',{tabla:'NNAFHabilidades', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'NNAFHabilidades', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Participacion = response.body.atributos[0]["PARTICIPACION"];
                    this.FInicio_Actividades = moment(response.body.atributos[0]["FINICIO_ACTIVIDADES"]).format("YYYY-MM-DD");
                    this.FFin_Actividades = moment(response.body.atributos[0]["FFIN_ACTIVIDADES"]).format("YYYY-MM-DD");
                    this.Termino_Actividades = response.body.atributos[0]["TERMINO_ACTIVIDADES"];
                    this.Fortalecer_Actividades = response.body.atributos[0]["FORTALECER_ACTIVIDADES"];
                }
             });

        },
        
    }
  })
