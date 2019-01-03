Vue.component('ppd-datos-atencion-psicologica', {
    template: '#ppd-datos-atencion-psicologica',
    data:()=>({
        CarNumHabilidadesBasicas:null,
        CarNumHabilidadesConceptuales:null,
        CarNumHabilidadesSociales:null,
        CarNumHablidadesPracticas:null,
        CarNumModificacionConducta:null,

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

                Num_HBasicas: this.CarNumHabilidadesBasicas,
                Num_HConceptuales: this.CarNumHabilidadesConceptuales,
                Num_HSociales: this.CarNumHabilidadesSociales,
                Num_HPracticas: this.CarNumHablidadesPracticas,
                Num_HModificacion: this.CarNumModificacionConducta,
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")
                        }
            this.$http.post('insertar_datos?view',{tabla:'CarAtencionPsicologica', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarAtencionPsicologica', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarNumHabilidadesBasicas = response.body.atributos[0]["NUM_HBASICAS"];
                    this.CarNumHabilidadesConceptuales = response.body.atributos[0]["NUM_HCONCEPTUALES"];
                    this.CarNumHabilidadesSociales = response.body.atributos[0]["NUM_HSOCIALES"];
                    this.CarNumHablidadesPracticas = response.body.atributos[0]["NUM_HPRACTICAS"];
                    this.CarNumModificacionConducta = response.body.atributos[0]["NUM_HMODIFICACION"];

                }
             });

        },mostrar_lista_residentes(){
         
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

            this.CarNumHabilidadesBasicas = null;
            this.CarNumHabilidadesConceptuales = null;
            this.CarNumHabilidadesSociales = null;
            this.CarNumHablidadesPracticas = null;
            this.CarNumModificacionConducta = null;

            this.id_residente = residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido = (residente.APELLIDO==undefined)?'':residente.APELLIDO;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarAtencionPsicologica', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarNumHabilidadesBasicas = response.body.atributos[0]["NUM_HBASICAS"];
                    this.CarNumHabilidadesConceptuales = response.body.atributos[0]["NUM_HCONCEPTUALES"];
                    this.CarNumHabilidadesSociales = response.body.atributos[0]["NUM_HSOCIALES"];
                    this.CarNumHablidadesPracticas = response.body.atributos[0]["NUM_HPRACTICAS"];
                    this.CarNumModificacionConducta = response.body.atributos[0]["NUM_HMODIFICACION"];

                }
             });

        }
    }
  })
