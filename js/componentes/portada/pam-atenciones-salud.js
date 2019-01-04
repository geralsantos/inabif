Vue.component('pam-atenciones-salud', {
    template:'#pam-atenciones-salud',
    data:()=>({
        Residente_Salida:null,
        Salidas:null,
        Atenciones_Cardiovascular:null,
        Atenciones_Nefrologia:null,
        Atenciones_Oncologia:null,
        Atenciones_Neurocirugia:null,
        Atenciones_Dermatologia:null,
        Atenciones_Endocrinologo:null,
        Atenciones_Gastroenterologia:null,
        Atenciones_Hematologia:null,
        Atenciones_Inmunologia:null,
        AtencionesMedicFisiRehabilita:null,
        Atenciones_Neumologia:null,
        Atenciones_Nutricion:null,
        Atenciones_Neurologia:null,
        Atenciones_Oftalmologia:null,
        AtencionOtorrinolaringologia:null,
        Atenciones_Psiquiatria:null,
        Atenciones_Traumatologia:null,
        Atenciones_Urologia:null,
        Atenciones_Odontologia:null,
        MedicinaGeneral_Geriatrica:null,
        Nro_Atenciones_OtrosServicios:null,
        ResidenteHospitalizadoPeriodo:null,
        Motivo_Hospitalizacion:null,
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

                Residente_Salida:this.Residente_Salida,
                Salidas:this.Salidas,
                Atenciones_Cardiovascular:this.Atenciones_Cardiovascular,
                Atenciones_Nefrologia:this.Atenciones_Nefrologia,
                Atenciones_Oncologia:this.Atenciones_Oncologia,
                Atenciones_Neurocirugia:this.Atenciones_Neurocirugia,
                Atenciones_Dermatologia:this.Atenciones_Dermatologia,
                Atenciones_Endocrinologo:this.Atenciones_Endocrinologo,
                Atenciones_Gastroenterologia:this.Atenciones_Gastroenterologia,
                Atenciones_Hematologia:this.Atenciones_Hematologia,
                Atenciones_Inmunologia:this.Atenciones_Inmunologia,
                AtencionesMedicFisiRehabilita:this.AtencionesMedicFisiRehabilita,
                Atenciones_Neumologia:this.Atenciones_Neumologia,
                Atenciones_Nutricion:this.Atenciones_Nutricion,
                Atenciones_Neurologia:this.Atenciones_Neurologia,
                Atenciones_Oftalmologia:this.Atenciones_Oftalmologia,
                AtencionOtorrinolaringologia:this.AtencionOtorrinolaringologia,
                Atenciones_Psiquiatria:this.Atenciones_Psiquiatria,
                Atenciones_Traumatologia:this.Atenciones_Traumatologia,
                Atenciones_Urologia:this.Atenciones_Urologia,
                Atenciones_Odontologia:this.Atenciones_Odontologia,
                MedicinaGeneral_Geriatrica:this.MedicinaGeneral_Geriatrica,
                Nro_Atenciones_OtrosServicios:this.Nro_Atenciones_OtrosServicios,
                ResidenteHospitalizadoPeriodo:this.ResidenteHospitalizadoPeriodo,
                Motivo_Hospitalizacion:this.Motivo_Hospitalizacion,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }

            this.$http.post('insertar_datos?view',{tabla:'pam_AtencionesSalud', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_AtencionesSalud', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Residente_Salida = response.body.atributos[0]["RESIDENTE_SALIDA"];
                    this.Salidas = response.body.atributos[0]["SALIDAS"];
                    this.Atenciones_Cardiovascular = response.body.atributos[0]["ATENCIONES_CARDIOVASCULAR"];
                    this.Atenciones_Nefrologia = response.body.atributos[0]["ATENCIONES_NEFROLOGIA"];
                    this.Atenciones_Oncologia = response.body.atributos[0]["ATENCIONES_ONCOLOGIA"];
                    this.Atenciones_Neurocirugia = response.body.atributos[0]["ATENCIONES_NEUROCIRUGIA"];
                    this.Atenciones_Dermatologia = response.body.atributos[0]["ATENCIONES_DERMATOLOGIA"];
                    this.Atenciones_Endocrinologo = response.body.atributos[0]["ATENCIONES_ENDOCRINOLOGO"];
                    this.Atenciones_Gastroenterologia = response.body.atributos[0]["ATENCIONES_GASTROENTEROLOGIA"];
                    this.Atenciones_Hematologia = response.body.atributos[0]["ATENCIONES_HEMATOLOGIA"];
                    this.Atenciones_Inmunologia = response.body.atributos[0]["ATENCIONES_INMUNOLOGIA"];
                    this.AtencionesMedicFisiRehabilita = response.body.atributos[0]["ATENCIONESMEDICFISIREHABILITA"];
                    this.Atenciones_Neumologia = response.body.atributos[0]["ATENCIONES_NEUMOLOGIA"];
                    this.Atenciones_Nutricion = response.body.atributos[0]["ATENCIONES_NUTRICION"];
                    this.Atenciones_Neurologia = response.body.atributos[0]["ATENCIONES_NEUROLOGIA"];
                    this.Atenciones_Oftalmologia = response.body.atributos[0]["ATENCIONES_OFTALMOLOGIA"];
                    this.AtencionOtorrinolaringologia = response.body.atributos[0]["ATENCIONOTORRINOLARINGOLOGIA"];
                    this.Atenciones_Psiquiatria = response.body.atributos[0]["ATENCIONES_PSIQUIATRIA"];
                    this.Atenciones_Traumatologia = response.body.atributos[0]["ATENCIONES_TRAUMATOLOGIA"];
                    this.Atenciones_Urologia = response.body.atributos[0]["ATENCIONES_UROLOGIA"];
                    this.Atenciones_Odontologia = response.body.atributos[0]["ATENCIONES_ODONTOLOGIA"];
                    this.MedicinaGeneral_Geriatrica = response.body.atributos[0]["MEDICINAGENERAL_GERIATRICA"];
                    this.Nro_Atenciones_OtrosServicios = response.body.atributos[0]["NRO_ATENCIONES_OTROSSERVICIOS"];
                    this.ResidenteHospitalizadoPeriodo = response.body.atributos[0]["RESIDENTEHOSPITALIZADOPERIODO"];
                    this.Motivo_Hospitalizacion = response.body.atributos[0]["MOTIVO_HOSPITALIZACION"];
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

            this.Residente_Salida = null;
            this.Salidas = null;
            this.Atenciones_Cardiovascular = null;
            this.Atenciones_Nefrologia = null;
            this.Atenciones_Oncologia = null;
            this.Atenciones_Neurocirugia = null;
            this.Atenciones_Dermatologia = null;
            this.Atenciones_Endocrinologo = null;
            this.Atenciones_Gastroenterologia = null;
            this.Atenciones_Hematologia = null;
            this.Atenciones_Inmunologia = null;
            this.AtencionesMedicFisiRehabilita = null;
            this.Atenciones_Neumologia = null;
            this.Atenciones_Nutricion = null;
            this.Atenciones_Neurologia = null;
            this.Atenciones_Oftalmologia = null;
            this.AtencionOtorrinolaringologia = null;
            this.Atenciones_Psiquiatria = null;
            this.Atenciones_Traumatologia = null;
            this.Atenciones_Urologia = null;
            this.Atenciones_Odontologia = null;
            this.MedicinaGeneral_Geriatrica = null;
            this.Nro_Atenciones_OtrosServicios = null;
            this.ResidenteHospitalizadoPeriodo = null;
            this.Motivo_Hospitalizacion = null;
            this.id = null;


            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_AtencionesSalud', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Residente_Salida = response.body.atributos[0]["RESIDENTE_SALIDA"];
                    this.Salidas = response.body.atributos[0]["SALIDAS"];
                    this.Atenciones_Cardiovascular = response.body.atributos[0]["ATENCIONES_CARDIOVASCULAR"];
                    this.Atenciones_Nefrologia = response.body.atributos[0]["ATENCIONES_NEFROLOGIA"];
                    this.Atenciones_Oncologia = response.body.atributos[0]["ATENCIONES_ONCOLOGIA"];
                    this.Atenciones_Neurocirugia = response.body.atributos[0]["ATENCIONES_NEUROCIRUGIA"];
                    this.Atenciones_Dermatologia = response.body.atributos[0]["ATENCIONES_DERMATOLOGIA"];
                    this.Atenciones_Endocrinologo = response.body.atributos[0]["ATENCIONES_ENDOCRINOLOGO"];
                    this.Atenciones_Gastroenterologia = response.body.atributos[0]["ATENCIONES_GASTROENTEROLOGIA"];
                    this.Atenciones_Hematologia = response.body.atributos[0]["ATENCIONES_HEMATOLOGIA"];
                    this.Atenciones_Inmunologia = response.body.atributos[0]["ATENCIONES_INMUNOLOGIA"];
                    this.AtencionesMedicFisiRehabilita = response.body.atributos[0]["ATENCIONESMEDICFISIREHABILITA"];
                    this.Atenciones_Neumologia = response.body.atributos[0]["ATENCIONES_NEUMOLOGIA"];
                    this.Atenciones_Nutricion = response.body.atributos[0]["ATENCIONES_NUTRICION"];
                    this.Atenciones_Neurologia = response.body.atributos[0]["ATENCIONES_NEUROLOGIA"];
                    this.Atenciones_Oftalmologia = response.body.atributos[0]["ATENCIONES_OFTALMOLOGIA"];
                    this.AtencionOtorrinolaringologia = response.body.atributos[0]["ATENCIONOTORRINOLARINGOLOGIA"];
                    this.Atenciones_Psiquiatria = response.body.atributos[0]["ATENCIONES_PSIQUIATRIA"];
                    this.Atenciones_Traumatologia = response.body.atributos[0]["ATENCIONES_TRAUMATOLOGIA"];
                    this.Atenciones_Urologia = response.body.atributos[0]["ATENCIONES_UROLOGIA"];
                    this.Atenciones_Odontologia = response.body.atributos[0]["ATENCIONES_ODONTOLOGIA"];
                    this.MedicinaGeneral_Geriatrica = response.body.atributos[0]["MEDICINAGENERAL_GERIATRICA"];
                    this.Nro_Atenciones_OtrosServicios = response.body.atributos[0]["NRO_ATENCIONES_OTROSSERVICIOS"];
                    this.ResidenteHospitalizadoPeriodo = response.body.atributos[0]["RESIDENTEHOSPITALIZADOPERIODO"];
                    this.Motivo_Hospitalizacion = response.body.atributos[0]["MOTIVO_HOSPITALIZACION"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

                }
             });

        }

    }
  })
