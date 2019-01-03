Vue.component('nna-seguimiento-educacion', {
    template: '#nna-seguimiento-educacion',
    data:()=>({
     
        Plan_Intervencion:null,
        Sistema_Educativo:null,
        NEducativo:null,
        Grado :null,
        Asitencia :null,
        Nro_Asistencia :null,
        Nro_Reforzamientos :null,
        Nro_Aprestamiento:null,
        Nro_Consejera :null,
        Estado_Participacion :null,
        ActividadOficio:null,

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
               
                Plan_Intervencion:this.Plan_Intervencion,
                Sistema_Educativo:this.Sistema_Educativo,
                NEducativo:this.NEducativo,
                Grado :this.Grado,
                Asitencia :this.Asitencia,
                Nro_Asistencia :this.Nro_Asistencia,
                Nro_Reforzamientos :this.Nro_Reforzamientos,
                Nro_Aprestamiento:this.Nro_Aprestamiento,
                Nro_Consejera :this.Nro_Consejera,
                Estado_Participacion :this.Estado_Participacion,
                ActividadOficio:this.ActividadOficio,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                
            this.$http.post('insertar_datos?view',{tabla:'NNAEducacion', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'NNAEducacion', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Plan_Intervencion = response.body.atributos[0]["PLAN_INTERVENCION"];
                    this.Sistema_Educativo = response.body.atributos[0]["SISTEMA_EDUCATIVO"];
                    this.NEducativo = response.body.atributos[0]["NEDUCATIVO"];
                    this.Grado = response.body.atributos[0]["GRADO"];
                    this.Asitencia = response.body.atributos[0]["ASITENCIA"];
                    this.Nro_Asistencia = response.body.atributos[0]["NRO_ASISTENCIA"];
                    this.Nro_Reforzamientos = response.body.atributos[0]["NRO_REFORZAMIENTOS"];
                    this.Nro_Aprestamiento = response.body.atributos[0]["NRO_APRESTAMIENTO"];
                    this.Nro_Consejera = response.body.atributos[0]["NRO_CONSEJERA"];
                    this.Estado_Participacion = response.body.atributos[0]["ESTADO_PARTICIPACION"];
                    this.ActividadOficio = response.body.atributos[0]["ACTIVIDADOFICIO"];
                }
             });

        },
        
    }
  })
