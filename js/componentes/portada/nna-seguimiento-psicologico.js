Vue.component('nna-seguimiento-psicologico', {
    template: '#nna-seguimiento-psicologico',
    data:()=>({
     
        Plan_Intervencion:null,
        Presento:null,
        Perfil  :null,
        Intervencion_Individual:null,
        Intervencion_Grupal:null,
        Nro_OrientacionP:null,
        Nro_OrientacionF:null,
        Nro_Charlas :null,
        Nro_TLiderazgo :null,
        Nro_TAutoestima :null,
        Nro_TSexualidad :null,
        Nro_TPrevencionEmb :null,
        Nro_TIgualdadG :null,
        Nro_ViolenciaF :null,
        Nro_SaludM :null,
                 
        perfilesingreso:[],

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
        this.buscar_nna_perfiles_ingreso();
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
                Presentacion_periodo :this.Presento,
                Perfil_Id   :this.Perfil,
                Intervencion_Individual:this.Intervencion_Individual,
                Intervencion_Grupal:this.Intervencion_Grupal,
                Nro_OrientacionP:this.Nro_OrientacionP,
                Nro_OrientacionF:this.Nro_OrientacionF,
                Nro_Charlas :this.Nro_Charlas,
                Nro_TLiderazgo :this.Nro_TLiderazgo,
                Nro_TAutoestima :this.Nro_TAutoestima,
                Nro_TSexualidad :this.Nro_TSexualidad,
                Nro_TPrevencionEmb :this.Nro_TPrevencionEmb,
                Nro_TIgualdadG :this.Nro_TIgualdadG,
                Nro_ViolenciaF :this.Nro_ViolenciaF,
                Nro_SaludM :this.Nro_SaludM,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                
            this.$http.post('insertar_datos?view',{tabla:'NNAPsicologico', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'NNAPsicologico', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Plan_Intervencion = response.body.atributos[0]["PLAN_INTERVENCION"];
                    this.Presento = response.body.atributos[0]["PRESENTACION_PERIODO"];
                    this.Perfil = response.body.atributos[0]["PERFIL_ID"];
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
        buscar_nna_perfiles_ingreso(){
            this.$http.post('buscar?view',{tabla:'nna_perfiles_ingreso'}).then(function(response){
                if( response.body.data ){
                    this.perfilesingreso= response.body.data;
                }

            });
        }
    }
  })
