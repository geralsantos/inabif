Vue.component('reniec-consulta', {
    template:'#reniec-consulta',
    data:()=>({
        Apellido_p:null,
        Apellido_m:null,
        Nombres:null,
        NumDoc:null,

        nombre_residente:null,
        isLoading:false,
        mes:moment().format("M"),
        anio:(new Date()).getFullYear(),
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null,
        modal_lista:false,
        pacientes:[],
        showModal: false,
        residente_seleccionado :[],
        data_reniec:{},
    }),
    created:function(){
    },
    mounted:function(){
     
    },
    methods:{
        buscar_residente(){
            this.id_residente = null;

            var word = this.nombre_residente;
            if( word.length >= 2){
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
            this.residente_seleccionado=[];
            this.residente_seleccionado.push(coincidencia);
            console.log(coincidencia);
            /*this.$http.post('cargar_datos_residente?view',{tabla:'CarIdentificacionUsuario', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){
                    this.Ape_Paterno = response.body.atributos[0]["APE_PATERNO"];
                    this.Ape_Materno = response.body.atributos[0]["APE_MATERNO"];
                    this.Nom_Usuario = response.body.atributos[0]["NOM_USUARIO"];
                    this.Pais_Procencia = response.body.atributos[0]["PAIS_PROCENCIA"];
                    this.Depatamento_Procedencia = response.body.atributos[0]["DEPATAMENTO_PROCEDENCIA"];
                    this.Provincia_Procedencia = response.body.atributos[0]["PROVINCIA_PROCEDENCIA"];
                    this.Distrito_Procedencia = response.body.atributos[0]["DISTRITO_PROCEDENCIA"];
                    this.Sexo = response.body.atributos[0]["SEXO"];
                    this.Edad = response.body.atributos[0]["EDAD"];
                    this.Fecha_Nacimiento = moment().subtract(this.Edad,'years').format("YYYY-MM-DD");
                    this.Lengua_Materna = response.body.atributos[0]["LENGUA_MATERNA"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];
                }
             });*/

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

            this.Apellido_p = null;
            this.Apellido_m = null;
            this.Nombres = null;
            this.NumDoc = null;

            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;
            this.residente_seleccionado.push(residente);

        },
        consulta_reniec(){
            if (!isempty(this.id_residente)) {
                let where = {dni:this.NumDoc}
                this.$http.post('consulta_reniec?view',where).then(function(response){

                    if( response.body.data != undefined){
                        var x2js = new X2JS();
                        let data_reniec = JSON.parse(JSON.stringify(x2js.xml_str2json(response.body.data)));
                        let coResultado = this.data_reniec.Envelope.Body.consultarResponse.return.coResultado; 
                        let deResultado = this.data_reniec.Envelope.Body.consultarResponse.return.deResultado;

                        if (codigoResponse=='0000') 
                        {
                            this.data_reniec.NumDoc = this.NumDoc;
                            this.data_reniec.Apellido_p = data_reniec.Envelope.Body.consultarResponse.return.datosPersona.apPrimer;
                            this.data_reniec.Apellido_m = data_reniec.Envelope.Body.consultarResponse.return.datosPersona.apSegundo;
                            this.data_reniec.Nombres = data_reniec.Envelope.Body.consultarResponse.return.datosPersona.prenombres;
                        }else{
                            swal("ERROR",(coResultado+" : "+deResultado), "error")
                        }
                       console.log(this.data_reniec);
                        //alert(this.data_reniec.Envelope.Body.consultarResponse.return.datosPersona.apPrimer);
                        this.modal_lista = true;
                        this.isLoading = false;
                        this.pacientes = response.body.data;
                    }else{
                        swal("", "No existe él residente", "error")
                    }
                });
            }else{
                swal("", "No hay residente seleccionado", "error")
            }
        }

    }
  })
