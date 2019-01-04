Vue.component('ppd-datos-egreso-generales', {
    template:'#ppd-datos-egreso-generales',
    data:()=>({

        CarFEgreso:null,
        CarMotivoEgreso:null,
        CarTrasladoCar:null,
        CarDefuncion:null,
        CarReinsercionFamiliar:null,
        CarRetiroVoluntario:null,
        CarAseguramiento:null,
        CarConstanciaNacimiento:null,
        CarCarnetConadis:null,
        CarTieneDni:null,
        CarRestitucionF:null,
        CarCumResDerEgreso:null,
        CarAus:null,
        CarFallecimiento:null,
        GradoParentesco:null,
        id:null,

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
                Fecha_Egreso: moment(this.CarFEgreso).format("YY-MMM-DD"),
                Motivo_Egreso:this.CarMotivoEgreso,
                Traslado:this.CarTrasladoCar,
                Reinsercion:this.CarReinsercionFamiliar,
                Retiro_Voluntario:this.CarRetiroVoluntario,
                Constancia_Naci:this.CarConstanciaNacimiento,
                Carnet_CONADIS:this.CarCarnetConadis,
                DNI:this.CarTieneDni,
                Restitucion:this.CarRestitucionF,
                Restitucion_Derechos:this.CarCumResDerEgreso,
                Aus:this.CarAus,
                Fallecimiento:this.CarFallecimiento,
                Grado_Parentesco :this.GradoParentesco,
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

                        }
                        console.log(valores);
            this.$http.post('insertar_datos?view',{tabla:'CarEgresoGeneral', valores:valores}).then(function(response){

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
            this.id_residente = coincidencia.ID;               this.id=coincidencia.ID;
            let nombre=(coincidencia.NOMBRE==undefined)?'':coincidencia.NOMBRE;
            let apellido_p = (coincidencia.APELLIDO_P==undefined)?'':coincidencia.APELLIDO_P;
            let apellido_m = (coincidencia.APELLIDO_M==undefined)?'':coincidencia.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.coincidencias = [];
            this.bloque_busqueda = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarEgresoGeneral', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarFEgreso = moment(response.body.atributos[0]["FECHA_EGRESO"]).format("YYYY-MM-DD");
                    this.CarMotivoEgreso = response.body.atributos[0]["MOTIVO_EGRESO"];
                    this.CarTrasladoCar = response.body.atributos[0]["TRASLADO"];
                    this.CarReinsercionFamiliar = response.body.atributos[0]["REINSERCION"];
                    this.CarRetiroVoluntario = response.body.atributos[0]["RETIRO_VOLUNTARIO"];
                    this.CarConstanciaNacimiento = response.body.atributos[0]["CONSTANCIA_NACI"];
                    this.CarCarnetConadis = response.body.atributos[0]["CARNET_CONADIS"];
                    this.CarTieneDni = response.body.atributos[0]["DNI"];
                    this.CarRestitucionF = response.body.atributos[0]["RESTITUCION"];
                    this.CarCumResDerEgreso = response.body.atributos[0]["RESTITUCION_DERECHOS"];
                    this.CarAus = response.body.atributos[0]["AUS"];
                    this.CarFallecimiento = response.body.atributos[0]["FALLECIMIENTO"];
                    this.GradoParentesco = response.body.atributos[0]["GRADO_PARENTESCO"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];
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

            this.CarFEgreso = null;
            this.CarMotivoEgreso = null;
            this.CarTrasladoCar = null;
            this.CarReinsercionFamiliar = null;
            this.CarRetiroVoluntario = null;
            this.CarConstanciaNacimiento = null;
            this.CarCarnetConadis = null;
            this.CarTieneDni = null;
            this.CarRestitucionF = null;
            this.CarCumResDerEgreso = null;
            this.CarAus = null;
            this.CarFallecimiento = null;
            this.GradoParentesco = null;
            this.id = null;

            this.id_residente = residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'CarEgresoGeneral', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarFEgreso = moment(response.body.atributos[0]["FECHA_EGRESO"]).format("YYYY-MM-DD");
                    this.CarMotivoEgreso = response.body.atributos[0]["MOTIVO_EGRESO"];
                    this.CarTrasladoCar = response.body.atributos[0]["TRASLADO"];
                    this.CarReinsercionFamiliar = response.body.atributos[0]["REINSERCION"];
                    this.CarRetiroVoluntario = response.body.atributos[0]["RETIRO_VOLUNTARIO"];
                    this.CarConstanciaNacimiento = response.body.atributos[0]["CONSTANCIA_NACI"];
                    this.CarCarnetConadis = response.body.atributos[0]["CARNET_CONADIS"];
                    this.CarTieneDni = response.body.atributos[0]["DNI"];
                    this.CarRestitucionF = response.body.atributos[0]["RESTITUCION"];
                    this.CarCumResDerEgreso = response.body.atributos[0]["RESTITUCION_DERECHOS"];
                    this.CarAus = response.body.atributos[0]["AUS"];
                    this.CarFallecimiento = response.body.atributos[0]["FALLECIMIENTO"];
                    this.GradoParentesco = response.body.atributos[0]["GRADO_PARENTESCO"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];
                }
             });

        }


    }
  })
