Vue.component('ppd-datos-educacion-participacionLaboral', {
    template: '#ppd-datos-educacion-participacionLaboral',
    data:()=>({
        CarTipoIIEE:null,
        CarInsertadoLaboralmente:null,
        CarDesParticipacionLa:null,
        CarFortalecimientoHabilidades:null,
        CarFIActividades:null,
        CarFFActividades:null,
        CarNNAConcluyoHP:null,
        CarNNAFortaliceHP:null,

        instituciones:[],

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
                Tipo_Institucion:this.CarTipoIIEE,
                Insertado_labora:this.CarInsertadoLaboralmente,
                Des_labora:this.CarDesParticipacionLa,
                Participa_Actividades:this.CarFortalecimientoHabilidades,
                Fecha_InicionA: moment(this.CarFIActividades, "YYYY-MM-DD").format("YY-MMM-DD"),
                Fecha_FinA:moment(this.CarFFActividades, "YYYY-MM-DD").format("YY-MMM-DD"),
                Culmino_Actividades:this.CarNNAConcluyoHP,
                Logro_Actividades:this.CarNNAFortaliceHP,
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")
                        }
            this.$http.post('insertar_datos?view',{tabla:'CarEducacionCapacidades', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarEducacionCapacidades', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarTipoIIEE = response.body.atributos[0]["TIPO_INSTITUCION"];
                    this.CarInsertadoLaboralmente = response.body.atributos[0]["INSERTADO_LABORA"];
                    this.CarDesParticipacionLa = response.body.atributos[0]["DES_LABORA"];
                    this.CarFortalecimientoHabilidades = response.body.atributos[0]["PARTICIPA_ACTIVIDADES"];
                    this.CarFIActividades = response.body.atributos[0]["FECHA_INICIONA"];
                    this.CarFFActividades = response.body.atributos[0]["FECHA_FINA"];
                    this.CarNNAConcluyoHP = response.body.atributos[0]["CULMINO_ACTIVIDADES"];
                    this.CarNNAFortaliceHP = response.body.atributos[0]["LOGRO_ACTIVIDADES"];

                }
             });

        }
    }
  })
