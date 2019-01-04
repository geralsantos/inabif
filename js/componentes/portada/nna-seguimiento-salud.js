Vue.component('nna-seguimiento-salud', {
    template: '#nna-seguimiento-salud',
    data:()=>({

        Intervencion :null,
        Diagnostico_Psiquiatrico_1:null,
        Diagnostico_Psiquiatrico_2:null,
        Diagnostico_Psiquiatrico_3:null,
        Diagnostico_Neurologico_1:null,
        Diagnostico_Neurologico_2:null,
        Diagnostico_Neurologico_3:null,
        Diagnostico_Cronico_1:null,
        Diagnostico_Cronico_2	:null,
        Diagnostico_Cronico_3	:null,
        Diagnostico_Agudo_1 :null,
        Diagnostico_Agudo_2 :null,
        Diagnostico_Agudo_3 :null,
        VIH  :null,
        ETS   :null,
        TBC   :null,
        HepatitisA :null,
        HepatitisB :null,
        Caries     :null,
        Discapacidad     :null,
        Discapacidad_Fisica     :null,
        Discapacidad_Intelectual:null,
        Discapacidad_Sensorial :null,
        Discapacidad_Mental:null,
        SIS   :null,
        ESSALUD    :null,
        Tipo_Seguro :null,
        CONADIS    :null,
        A_Medicina_General :null,
        A_Cirujia_General        :null,
        A_Traumatologia    :null,
        A_Odontologia      :null,
        A_Medicina_Interna       :null,
        A_Cardiovascular   :null,
        A_Dermatologia     :null,
        A_Endrocrinologia        :null,
        A_Gastroentrologia       :null,
        A_Gineco_Obstetricia:null,
        A_Hermatologia     :null,
        A_Nefrologia       :null,
        A_Infectologia     :null,
        A_Inmunologia      :null,
        A_Reumatologia     :null,
        A_Neumologia       :null,
        A_Neurologia       :null,
        A_Oftalmologia     :null,
        A_Otorrinolaringologia :null,
        A_Oncologia  :null,
        A_Psicriatica      :null,
        A_Cirujia          :null,
        A_Urologia   :null,
        A_Nutricion  :null,
        A_Pedriatria       :null,
        A_Rehabilitacion   :null,
        A_Gineco_Menores   :null,
        A_Psicologia       :null,
        Atencion_Total     :null,
        Hospitalizado    :null,
        Emergencia :null,
        CRED  :null,
        Inmunizacion     :null,
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

                Intervencion :this.Intervencion,
                Diagnostico_Psiquiatrico_1:this.Diagnostico_Psiquiatrico_1,
                Diagnostico_Psiquiatrico_2:this.Diagnostico_Psiquiatrico_2,
                Diagnostico_Psiquiatrico_3:this.Diagnostico_Psiquiatrico_3,
                Diagnostico_Neurologico_1:this.Diagnostico_Neurologico_1,
                Diagnostico_Neurologico_2:this.Diagnostico_Neurologico_2,
                Diagnostico_Neurologico_3:this.Diagnostico_Neurologico_3,
                Diagnostico_Cronico_1:this.Diagnostico_Cronico_1,
                Diagnostico_Cronico_2	:this.Diagnostico_Cronico_2,
                Diagnostico_Cronico_3	:this.Diagnostico_Cronico_3,
                Diagnostico_Agudo_1 :this.Diagnostico_Agudo_1,
                Diagnostico_Agudo_2 :this.Diagnostico_Agudo_2,
                Diagnostico_Agudo_3 :this.Diagnostico_Agudo_3,
                VIH  :this.VIH,
                ETS   :this.ETS,
                TBC   :this.TBC,
                HepatitisA :this.HepatitisA,
                HepatitisB :this.HepatitisB,
                Caries     :this.Caries,
                Discapacidad     :this.Discapacidad,
                Discapacidad_Fisica     :this.Discapacidad_Fisica,
                Discapacidad_Intelectual:this.Discapacidad_Intelectual,
                Discapacidad_Sensorial :this.Discapacidad_Sensorial,
                Discapacidad_Mental:this.Discapacidad_Mental,
                SIS   :this.SIS,
                ESSALUD    :this.ESSALUD,
                Tipo_Seguro :this.Tipo_Seguro,
                CONADIS    :this.CONADIS,
                A_Medicina_General :this.A_Medicina_General,
                A_Cirujia_General        :this.A_Cirujia_General,
                A_Traumatologia    :this.A_Traumatologia,
                A_Odontologia      :this.A_Odontologia,
                A_Medicina_Interna       :this.A_Medicina_Interna,
                A_Cardiovascular   :this.A_Cardiovascular,
                A_Dermatologia     :this.A_Dermatologia,
                A_Endrocrinologia        :this.A_Endrocrinologia,
                A_Gastroentrologia       :this.A_Gastroentrologia,
                A_Gineco_Obstetricia:this.A_Gineco_Obstetricia,
                A_Hermatologia     :this.A_Hermatologia,
                A_Nefrologia       :this.A_Nefrologia,
                A_Infectologia     :this.A_Infectologia,
                A_Inmunologia      :this.A_Inmunologia,
                A_Reumatologia     :this.A_Reumatologia,
                A_Neumologia       :this.A_Neumologia,
                A_Neurologia       :this.A_Neurologia,
                A_Oftalmologia     :this.A_Oftalmologia,
                A_Otorrinolaringologia :this.A_Otorrinolaringologia,
                A_Oncologia  :this.A_Oncologia,
                A_Psicriatica      :this.A_Psicriatica,
                A_Cirujia          :this.A_Cirujia,
                A_Urologia   :this.A_Urologia,
                A_Nutricion  :this.A_Nutricion,
                A_Pedriatria       :this.A_Pedriatria,
                A_Rehabilitacion   :this.A_Rehabilitacion,
                A_Gineco_Menores   :this.A_Gineco_Menores,
                A_Psicologia       :this.A_Psicologia,
                Atencion_Total     :this.Atencion_Total,
                Hospitalizado    :this.Hospitalizado,
                Emergencia :this.Emergencia,
                CRED  :this.CRED,
                Inmunizacion     :this.Inmunizacion,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }

            this.$http.post('insertar_datos?view',{tabla:'NNASalud', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'NNASalud', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Intervencion = response.body.atributos[0]["INTERVENCION"];
                    this.Diagnostico_Psiquiatrico_1 = response.body.atributos[0]["DIAGNOSTICO_PSIQUIATRICO_1"];
                    this.Diagnostico_Psiquiatrico_2 = response.body.atributos[0]["DIAGNOSTICO_PSIQUIATRICO_2"];
                    this.Diagnostico_Psiquiatrico_3 = response.body.atributos[0]["DIAGNOSTICO_PSIQUIATRICO_3"];
                    this.Diagnostico_Neurologico_1 = response.body.atributos[0]["DIAGNOSTICO_NEUROLOGICO_1"];
                    this.Diagnostico_Neurologico_2 = response.body.atributos[0]["DIAGNOSTICO_NEUROLOGICO_2"];
                    this.Diagnostico_Neurologico_3 = response.body.atributos[0]["DIAGNOSTICO_NEUROLOGICO_3"];
                    this.Diagnostico_Cronico_1 = response.body.atributos[0]["DIAGNOSTICO_CRONICO_1"];
                    this.Diagnostico_Cronico_2 = response.body.atributos[0]["DIAGNOSTICO_CRONICO_2"];
                    this.Diagnostico_Cronico_3 = response.body.atributos[0]["DIAGNOSTICO_CRONICO_3"];
                    this.Diagnostico_Agudo_1 = response.body.atributos[0]["DIAGNOSTICO_AGUDO_1"];
                    this.Diagnostico_Agudo_2 = response.body.atributos[0]["DIAGNOSTICO_AGUDO_2"];
                    this.Diagnostico_Agudo_3 = response.body.atributos[0]["DIAGNOSTICO_AGUDO_3"];
                    this.VIH = response.body.atributos[0]["VIH"];
                    this.ETS = response.body.atributos[0]["ETS"];
                    this.TBC = response.body.atributos[0]["TBC"];
                    this.HepatitisA = response.body.atributos[0]["HEPATITISA"];
                    this.HepatitisB = response.body.atributos[0]["HEPATITISB"];
                    this.Caries = response.body.atributos[0]["CARIES"];
                    this.Discapacidad = response.body.atributos[0]["DISCAPACIDAD"];
                    this.Discapacidad_Fisica = response.body.atributos[0]["DISCAPACIDAD_FISICA"];
                    this.Discapacidad_Intelectual = response.body.atributos[0]["DISCAPACIDAD_INTELECTUAL"];
                    this.Discapacidad_Sensorial = response.body.atributos[0]["DISCAPACIDAD_SENSORIAL"];
                    this.Discapacidad_Mental = response.body.atributos[0]["DISCAPACIDAD_MENTAL"];
                    this.SIS = response.body.atributos[0]["SIS"];
                    this.ESSALUD = response.body.atributos[0]["ESSALUD"];
                    this.Tipo_Seguro = response.body.atributos[0]["TIPO_SEGURO"];
                    this.CONADIS = response.body.atributos[0]["CONADIS"];
                    this.A_Medicina_General = response.body.atributos[0]["A_MEDICINA_GENERAL"];
                    this.A_Cirujia_General = response.body.atributos[0]["A_CIRUJIA_GENERAL"];
                    this.A_Traumatologia = response.body.atributos[0]["A_TRAUMATOLOGIA"];
                    this.A_Odontologia = response.body.atributos[0]["A_ODONTOLOGIA"];
                    this.A_Medicina_Interna = response.body.atributos[0]["A_MEDICINA_INTERNA"];
                    this.A_Cardiovascular = response.body.atributos[0]["A_CARDIOVASCULAR"];
                    this.A_Dermatologia = response.body.atributos[0]["A_DERMATOLOGIA"];
                    this.A_Endrocrinologia = response.body.atributos[0]["A_ENDROCRINOLOGIA"];
                    this.A_Gastroentrologia = response.body.atributos[0]["A_GASTROENTROLOGIA"];
                    this.A_Gineco_Obstetricia = response.body.atributos[0]["A_GINECO_OBSTETRICIA"];
                    this.A_Hermatologia = response.body.atributos[0]["A_HERMATOLOGIA"];
                    this.A_Nefrologia = response.body.atributos[0]["A_NEFROLOGIA"];
                    this.A_Infectologia = response.body.atributos[0]["A_Infectologia"];
                    this.A_Inmunologia = response.body.atributos[0]["A_INMUNOLOGIA"];
                    this.A_Reumatologia = response.body.atributos[0]["A_REUMATOLOGIA"];
                    this.A_Neumologia = response.body.atributos[0]["A_NEUMOLOGIA"];
                    this.A_Neurologia = response.body.atributos[0]["A_NEUROLOGIA"];
                    this.A_Oftalmologia = response.body.atributos[0]["A_OFTALMOLOGIA"];
                    this.A_Otorrinolaringologia = response.body.atributos[0]["A_OTORRINOLARINGOLOGIA"];
                    this.A_Oncologia = response.body.atributos[0]["A_ONCOLOGIA"];
                    this.A_Psicriatica = response.body.atributos[0]["A_PSICRIATICA"];
                    this.A_Cirujia = response.body.atributos[0]["A_CIRUJIA"];
                    this.A_Urologia = response.body.atributos[0]["A_UROLOGIA"];
                    this.A_Nutricion = response.body.atributos[0]["A_NUTRICION"];
                    this.A_Pedriatria = response.body.atributos[0]["A_PEDRIATRIA"];
                    this.A_Rehabilitacion = response.body.atributos[0]["A_REHABILITACION"];
                    this.A_Gineco_Menores = response.body.atributos[0]["A_GINECO_MENORES"];
                    this.A_Psicologia = response.body.atributos[0]["A_PSICOLOGIA"];
                    this.Atencion_Total = response.body.atributos[0]["ATENCION_TOTAL"];
                    this.Hospitalizado = response.body.atributos[0]["HOSPITALIZADO"];
                    this.Emergencia = response.body.atributos[0]["EMERGENCIA"];
                    this.CRED = response.body.atributos[0]["CRED"];
                    this.Inmunizacion = response.body.atributos[0]["INMUNIZACION"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

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
            this.Diagnostico_Psiquiatrico_1 = null;
            this.Diagnostico_Psiquiatrico_2 = null;
            this.Diagnostico_Psiquiatrico_3 = null;
            this.Diagnostico_Neurologico_1 = null;
            this.Diagnostico_Neurologico_2 = null;
            this.Diagnostico_Neurologico_3 = null;
            this.Diagnostico_Cronico_1 = null;
            this.Diagnostico_Cronico_2 = null;
            this.Diagnostico_Cronico_3 = null;
            this.Diagnostico_Agudo_1 = null;
            this.Diagnostico_Agudo_2 = null;
            this.Diagnostico_Agudo_3 = null;
            this.VIH = null;
            this.ETS = null;
            this.TBC = null;
            this.HepatitisA = null;
            this.HepatitisB = null;
            this.Caries = null;
            this.Discapacidad = null;
            this.Discapacidad_Fisica = null;
            this.Discapacidad_Intelectual = null;
            this.Discapacidad_Sensorial = null;
            this.Discapacidad_Mental = null;
            this.SIS = null;
            this.ESSALUD = null;
            this.Tipo_Seguro = null;
            this.CONADIS = null;
            this.A_Medicina_General = null;
            this.A_Cirujia_General = null;
            this.A_Traumatologia = null;
            this.A_Odontologia = null;
            this.A_Medicina_Interna = null;
            this.A_Cardiovascular = null;
            this.A_Dermatologia = null;
            this.A_Endrocrinologia = null;
            this.A_Gastroentrologia = null;
            this.A_Gineco_Obstetricia = null;
            this.A_Hermatologia = null;
            this.A_Nefrologia = null;
            this.A_Infectologia = null;
            this.A_Inmunologia = null;
            this.A_Reumatologia = null;
            this.A_Neumologia = null;
            this.A_Neurologia = null;
            this.A_Oftalmologia = null;
            this.A_Otorrinolaringologia = null;
            this.A_Oncologia = null;
            this.A_Psicriatica = null;
            this.A_Cirujia = null;
            this.A_Urologia = null;
            this.A_Nutricion = null;
            this.A_Pedriatria = null;
            this.A_Rehabilitacion = null;
            this.A_Gineco_Menores = null;
            this.A_Psicologia = null;
            this.Atencion_Total = null;
            this.Hospitalizado = null;
            this.Emergencia = null;
            this.CRED = null;
            this.Inmunizacion = null;
            this.id = null;

            this.id_residente = residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'NNASalud', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Intervencion = response.body.atributos[0]["INTERVENCION"];
                    this.Diagnostico_Psiquiatrico_1 = response.body.atributos[0]["DIAGNOSTICO_PSIQUIATRICO_1"];
                    this.Diagnostico_Psiquiatrico_2 = response.body.atributos[0]["DIAGNOSTICO_PSIQUIATRICO_2"];
                    this.Diagnostico_Psiquiatrico_3 = response.body.atributos[0]["DIAGNOSTICO_PSIQUIATRICO_3"];
                    this.Diagnostico_Neurologico_1 = response.body.atributos[0]["DIAGNOSTICO_NEUROLOGICO_1"];
                    this.Diagnostico_Neurologico_2 = response.body.atributos[0]["DIAGNOSTICO_NEUROLOGICO_2"];
                    this.Diagnostico_Neurologico_3 = response.body.atributos[0]["DIAGNOSTICO_NEUROLOGICO_3"];
                    this.Diagnostico_Cronico_1 = response.body.atributos[0]["DIAGNOSTICO_CRONICO_1"];
                    this.Diagnostico_Cronico_2 = response.body.atributos[0]["DIAGNOSTICO_CRONICO_2"];
                    this.Diagnostico_Cronico_3 = response.body.atributos[0]["DIAGNOSTICO_CRONICO_3"];
                    this.Diagnostico_Agudo_1 = response.body.atributos[0]["DIAGNOSTICO_AGUDO_1"];
                    this.Diagnostico_Agudo_2 = response.body.atributos[0]["DIAGNOSTICO_AGUDO_2"];
                    this.Diagnostico_Agudo_3 = response.body.atributos[0]["DIAGNOSTICO_AGUDO_3"];
                    this.VIH = response.body.atributos[0]["VIH"];
                    this.ETS = response.body.atributos[0]["ETS"];
                    this.TBC = response.body.atributos[0]["TBC"];
                    this.HepatitisA = response.body.atributos[0]["HEPATITISA"];
                    this.HepatitisB = response.body.atributos[0]["HEPATITISB"];
                    this.Caries = response.body.atributos[0]["CARIES"];
                    this.Discapacidad = response.body.atributos[0]["DISCAPACIDAD"];
                    this.Discapacidad_Fisica = response.body.atributos[0]["DISCAPACIDAD_FISICA"];
                    this.Discapacidad_Intelectual = response.body.atributos[0]["DISCAPACIDAD_INTELECTUAL"];
                    this.Discapacidad_Sensorial = response.body.atributos[0]["DISCAPACIDAD_SENSORIAL"];
                    this.Discapacidad_Mental = response.body.atributos[0]["DISCAPACIDAD_MENTAL"];
                    this.SIS = response.body.atributos[0]["SIS"];
                    this.ESSALUD = response.body.atributos[0]["ESSALUD"];
                    this.Tipo_Seguro = response.body.atributos[0]["TIPO_SEGURO"];
                    this.CONADIS = response.body.atributos[0]["CONADIS"];
                    this.A_Medicina_General = response.body.atributos[0]["A_MEDICINA_GENERAL"];
                    this.A_Cirujia_General = response.body.atributos[0]["A_CIRUJIA_GENERAL"];
                    this.A_Traumatologia = response.body.atributos[0]["A_TRAUMATOLOGIA"];
                    this.A_Odontologia = response.body.atributos[0]["A_ODONTOLOGIA"];
                    this.A_Medicina_Interna = response.body.atributos[0]["A_MEDICINA_INTERNA"];
                    this.A_Cardiovascular = response.body.atributos[0]["A_CARDIOVASCULAR"];
                    this.A_Dermatologia = response.body.atributos[0]["A_DERMATOLOGIA"];
                    this.A_Endrocrinologia = response.body.atributos[0]["A_ENDROCRINOLOGIA"];
                    this.A_Gastroentrologia = response.body.atributos[0]["A_GASTROENTROLOGIA"];
                    this.A_Gineco_Obstetricia = response.body.atributos[0]["A_GINECO_OBSTETRICIA"];
                    this.A_Hermatologia = response.body.atributos[0]["A_HERMATOLOGIA"];
                    this.A_Nefrologia = response.body.atributos[0]["A_NEFROLOGIA"];
                    this.A_Infectologia = response.body.atributos[0]["A_Infectologia"];
                    this.A_Inmunologia = response.body.atributos[0]["A_INMUNOLOGIA"];
                    this.A_Reumatologia = response.body.atributos[0]["A_REUMATOLOGIA"];
                    this.A_Neumologia = response.body.atributos[0]["A_NEUMOLOGIA"];
                    this.A_Neurologia = response.body.atributos[0]["A_NEUROLOGIA"];
                    this.A_Oftalmologia = response.body.atributos[0]["A_OFTALMOLOGIA"];
                    this.A_Otorrinolaringologia = response.body.atributos[0]["A_OTORRINOLARINGOLOGIA"];
                    this.A_Oncologia = response.body.atributos[0]["A_ONCOLOGIA"];
                    this.A_Psicriatica = response.body.atributos[0]["A_PSICRIATICA"];
                    this.A_Cirujia = response.body.atributos[0]["A_CIRUJIA"];
                    this.A_Urologia = response.body.atributos[0]["A_UROLOGIA"];
                    this.A_Nutricion = response.body.atributos[0]["A_NUTRICION"];
                    this.A_Pedriatria = response.body.atributos[0]["A_PEDRIATRIA"];
                    this.A_Rehabilitacion = response.body.atributos[0]["A_REHABILITACION"];
                    this.A_Gineco_Menores = response.body.atributos[0]["A_GINECO_MENORES"];
                    this.A_Psicologia = response.body.atributos[0]["A_PSICOLOGIA"];
                    this.Atencion_Total = response.body.atributos[0]["ATENCION_TOTAL"];
                    this.Hospitalizado = response.body.atributos[0]["HOSPITALIZADO"];
                    this.Emergencia = response.body.atributos[0]["EMERGENCIA"];
                    this.CRED = response.body.atributos[0]["CRED"];
                    this.Inmunizacion = response.body.atributos[0]["INMUNIZACION"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];

                }
             });

        }

    }
  })
