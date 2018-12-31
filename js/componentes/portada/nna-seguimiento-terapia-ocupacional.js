Vue.component('nna-seguimiento-terapia-ocupacional', {
    template: '#nna-seguimiento-terapia-ocupacional',
    data:()=>({
     
        Nro_Talleres_E:null,
        Nro_Campanas:null,
        Nro_Atencion_Fisi  :null,
        Nro_Atencon_Ocupa:null,
        Nro_Atencion_Lengua:null,
                        
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
               
                Nro_Talleres_E:this.Nro_Talleres_E,
                Nro_Campanas:this.Nro_Campanas,
                Nro_Atencion_Fisi  :this.Nro_Atencion_Fisi,
                Nro_Atencon_Ocupa:this.Nro_Atencon_Ocupa,
                Nro_Atencion_Lengua:this.Nro_Atencion_Lengua,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                
            this.$http.post('insertar_datos?view',{tabla:'NNATerapiasOcupacionalL', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'NNATerapiasOcupacionalL', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Plan_Intervencion = response.body.atributos[0]["PLAN_INTERVENCION"];
                    this.Presento = response.body.atributos[0]["PRESENTO"];
                    this.Perfil = response.body.atributos[0]["PERFIL"];
                    this.Intervencion_Individual = response.body.atributos[0]["INTERVENCION_INDIVIDUAL"];
                    this.Intervencion_Grupal = response.body.atributos[0]["INTERVENCION_GRUPAL"];
                    this.Nro_OrientacionP = response.body.atributos[0]["NRO_ORIENTACIONP"];
                    this.Nro_OrientacionF = response.body.atributos[0]["NRO_ORIENTACIONF"];
                    this.Nro_Charlas = response.body.atributos[0]["NRO_CHARLAS"];
                    this.Nro_TLiderazgo = response.body.atributos[0]["NRO_TLIDERAZGO"];
                    this.Nro_TAutoestima = response.body.atributos[0]["NRO_TAUTOESTIMA"];
                    this.Nro_TSexualidad = response.body.atributos[0]["NRO_TSEXUALIDAD"];
                    this.Nro_TPrevencionEmb = response.body.atributos[0]["NRO_TPREVENCIONEMB"];
                    this.Nro_TIgualdadG = response.body.atributos[0]["NRO_TIGUALDADG"];
                    this.Nro_ViolenciaF = response.body.atributos[0]["NRO_VIOLENCIAF"];
                    this.Nro_SaludM = response.body.atributos[0]["NRO_SALUDM"];

                }
             });

        },
        
    }
  })
