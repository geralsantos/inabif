var pam_datos_identificacion_residente = {
    template:'#pam-datos-identificacion-residente',
    data:()=>({
        Ape_Paterno:null,
        Ape_Materno:null,
        Nom_Usuario:null,
        pais_procedente_id:null,
        departamento_procedente_id:null,
        departamento_nacimiento_id:null,
        provincia_nacimiento_id:null,
        distrito_nacimiento_id:null,
        Sexo:null,
        Fecha_Nacimiento:null,
        Edad:null,
        Lengua_Materna:null,
        id:null,

        paises:[],
        departamentos:[],
        provincias:[],
        distritos:[],
        lenguas:[],
        departamentos2:[],

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
        this.buscar_paises();
        this.buscar_lenguas();
        this.buscar_departamentos();
        this.buscar_departamentos2();
    },
    updated:function(){
    },
    watch:{
        departamento_nacimiento_id:function(val){
            this.buscar_provincias();
        },
        Fecha_Nacimiento:function(val){
            this.Edad = moment().diff(val, 'year');
        }
    },
    methods:{
        inicializar(){
            this.Ape_Paterno = null;
            this.Ape_Materno = null;
            this.Nom_Usuario = null;
            this.pais_procedente_id = null;
            this.departamento_procedente_id = null;
            this.departamento_nacimiento_id = null;
            this.provincia_nacimiento_id = null;
            this.distrito_nacimiento_id = null;
            this.Sexo = null;
            this.Fecha_Nacimiento = null;
            this.Edad = null;
            this.Lengua_Materna = null;
            this.id = null;

            this.paises=[];
            this.departamentos=[];
            this.provincias=[];
            this.distritos=[];
            this.lenguas=[];
            this.departamentos2=[];

            this.nombre_residente=null;
            this.isLoading=false;
            this.mes=moment().format("M");
            this.anio=(new Date()).getFullYear();
            this.coincidencias=[];
            this.bloque_busqueda=false;
            this.id_residente=null;
            this.modal_lista=false;
            this.pacientes = [];

            this.buscar_paises();
            this.buscar_lenguas();
            this.buscar_departamentos();
            this.buscar_departamentos2();
        },
        guardar(){
            /*if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'success');
                return false;
            }*/
            let valores = {

                residente_apellido_paterno: this.Ape_Paterno,
                residente_apellido_materno: this.Ape_Materno,
                residente_nombre: this.Nom_Usuario,
                pais_procedente_id: this.pais_procedente_id,
                departamento_procedente_id: this.departamento_procedente_id,
                departamento_nacimiento_id: this.departamento_nacimiento_id,
                provincia_nacimiento_id: this.provincia_nacimiento_id,
                distrito_nacimiento_id: this.distrito_nacimiento_id,
                sexo: this.Sexo,
                fecha_nacimiento:  moment(this.Fecha_Nacimiento, "YYYY-MM-DD").format("YYYY-MM-DD"),
                edad: this.Edad,
                lengua_materna: this.Lengua_Materna,

                //Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

                }
                console.log(this.Fecha_Nacimiento);
                console.log(valores);
           /* this.$http.post('insertar_datos?view',{tabla:'pam_datos_identificacion', valores:valores}).then(function(response){

                if( response.body.resultado ){
                    swal('', 'Registro Guardado', 'success');

                }else{
                  swal("", "Un error ha ocurrido", "error");
                }
            });*/
            let valores_arr = Object.values(valores);
                for (let index = 0; index < valores_arr.length; index++) {
                    if (isempty(valores_arr[index])) {
                        swal('Error', 'Debe llenar todos los campos', 'warning');
                        return false;
                    }
                }
                var valores_residente = {
                    nombre : this.Nom_Usuario,
                    apellido_p : this.Ape_Paterno,
                    apellido_m : this.Ape_Materno,
                    pais_id : this.pais_procedente_id,
                    departamento_naci_cod : this.departamento_nacimiento_id,
                    provincia_naci_cod : this.provincia_nacimiento_id,
                    distrito_naci_cod : this.distrito_nacimiento_id,
                    sexo: this.Sexo,
                    fecha_naci :  moment(this.Fecha_Nacimiento, "YYYY-MM-DD").format("YYYY-MM-DD"),
                    edad: this.Edad,
                    lengua_materna: this.Lengua_Materna,
                    documento :this.Numero_Doc
                    }
                if (isempty(this.id_residente)) {

                    this.$http.post('insertar_datos?view',{tabla:'residente', valores:valores_residente,lastid:true}).then(function(response){
                        valores.Residente_Id = response.body.lastid;
                        this.$http.post('insertar_datos?view',{tabla:'pam_datos_identificacion', valores:valores}).then(function(response){
                            if( response.body.resultado ){
                                this.inicializar();
                                swal('', 'Registro Guardado', 'success');
                            }else{
                              swal("", "Un error ha ocurrido", "error");
                            }
                        });
                    });
                }else{
                    valores.Residente_Id = this.id_residente;
                    let where = {id:this.id_residente};
                    this.$http.post('update_datos?view',{tabla:'residente', valores:valores_residente,where:where}).then(function(response){
                        this.$http.post('insertar_datos?view',{tabla:'pam_datos_identificacion', valores:valores}).then(function(response){
                            if( response.body.resultado ){
                                this.inicializar();
                                swal('', 'Registro Guardado', 'success');
                            }else{
                              swal("", "Un error ha ocurrido", "error");
                            }
                        });
                    });
                    
                }

        },
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

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_datos_identificacion', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){
                    this.Ape_Paterno = response.body.atributos[0]["RESIDENTE_APELLIDO_PATERNO"];
                    this.Ape_Materno = response.body.atributos[0]["RESIDENTE_APELLIDO_MATERNO"];
                    this.Nom_Usuario = response.body.atributos[0]["RESIDENTE_NOMBRE"];
                    this.pais_procedente_id = response.body.atributos[0]["PAIS_PROCEDENTE_ID"];
                    this.departamento_procedente_id = response.body.atributos[0]["DEPARTAMENTO_PROCEDENTE_ID"];
                    this.departamento_nacimiento_id = response.body.atributos[0]["DEPARTAMENTO_NACIMIENTO_ID"];
                    this.provincia_nacimiento_id = response.body.atributos[0]["PROVINCIA_NACIMIENTO_ID"];
                    this.distrito_nacimiento_id = response.body.atributos[0]["DISTRITO_NACIMIENTO_ID"];
                    this.Sexo = response.body.atributos[0]["SEXO"];
                    this.Edad = response.body.atributos[0]["EDAD"];
                    var fecha_naci = !isempty(response.body.atributos[0]["FECHA_NACIMIENTO"]);
                    var da = fecha_naci ? (moment().format("YYYY") )+"-"+moment(response.body.atributos[0]["FECHA_NACIMIENTO"],'DD-MMM').format("MM-DD").toString():null;
                    this.Fecha_Nacimiento = fecha_naci ? moment(da,"YYYY-MM-DD").subtract(this.Edad,'years').format("YYYY-MM-DD"): null;
                    //this.Fecha_Nacimiento = isempty(response.body.atributos[0]["FECHA_NACIMIENTO"])?null:moment(response.body.atributos[0]["FECHA_NACIMIENTO"],'DD-MMM-YY').format("YYYY-MM-DD");
                    this.Lengua_Materna = response.body.atributos[0]["LENGUA_MATERNA"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];
                }
             });

        },
        buscar_paises(){
            this.$http.post('buscar?view',{tabla:'paises'}).then(function(response){
                if( response.body.data ){
                    this.paises= response.body.data;
                }

            });
        },

        buscar_departamentos(){
            this.$http.post('buscar_departamentos?view',{tabla:'ubigeo'}).then(function(response){
                if( response.body.data ){
                    this.departamentos= response.body.data;
                    //this.Depatamento_Procedencia = response.body.data[0]["CODDEPT"];
                    //this.buscar_provincias();

                }

            });
        },
        buscar_departamentos2(){
            this.$http.post('buscar_departamentos?view',{tabla:'ubigeo'}).then(function(response){
                if( response.body.data ){
                    this.departamentos2= response.body.data;
                    //this.Depatamento_Procedencia = response.body.data[0]["CODDEPT"];
                    //this.buscar_provincias();

                }

            });
        },
        buscar_provincias(){
            this.$http.post('buscar_provincia?view',{tabla:'ubigeo', cod:this.departamento_nacimiento_id}).then(function(response){
                if( response.body.data ){
                    this.provincias= response.body.data;
                    //this.Provincia_Procedencia = response.body.data[0]["CODPROV"];
                    this.buscar_distritos();
                }

            });
        },
        buscar_distritos(){
            this.$http.post('buscar_distritos?view',{tabla:'ubigeo', cod:this.provincia_nacimiento_id}).then(function(response){
                if( response.body.data ){
                    this.distritos= response.body.data;
                    //this.Distrito_Procedencia = response.body.data[0]["CODDIST"];
                }

            });
        },
        buscar_lenguas(){
            this.$http.post('buscar?view',{tabla:'pam_lengua_materna'}).then(function(response){
                if( response.body.data ){
                    this.lenguas= response.body.data;
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

            this.Ape_Paterno = null;
            this.Ape_Materno = null;
            this.Nom_Usuario = null;
            this.pais_procedente_id = null;
            this.departamento_procedente_id = null;
            this.departamento_nacimiento_id = null;
            this.provincia_nacimiento_id = null;
            this.distrito_nacimiento_id = null;
            this.Sexo = null;
            this.Fecha_Nacimiento = null;
            this.Edad = null;
            this.Lengua_Materna = null;
            this.id = null;


            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_datos_identificacion', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){
                    this.Ape_Paterno = response.body.atributos[0]["RESIDENTE_APELLIDO_PATERNO"];
                    this.Ape_Materno = response.body.atributos[0]["RESIDENTE_APELLIDO_MATERNO"];
                    this.Nom_Usuario = response.body.atributos[0]["RESIDENTE_NOMBRE"];
                    this.pais_procedente_id = response.body.atributos[0]["PAIS_PROCEDENTE_ID"];
                    this.departamento_procedente_id = response.body.atributos[0]["DEPARTAMENTO_PROCEDENTE_ID"];
                    this.departamento_nacimiento_id = response.body.atributos[0]["DEPARTAMENTO_NACIMIENTO_ID"];
                    this.provincia_nacimiento_id = response.body.atributos[0]["PROVINCIA_NACIMIENTO_ID"];
                    this.distrito_nacimiento_id = response.body.atributos[0]["DISTRITO_NACIMIENTO_ID"];
                    this.Sexo = response.body.atributos[0]["SEXO"];
                    this.Edad = response.body.atributos[0]["EDAD"];
                    var fecha_naci = !isempty(response.body.atributos[0]["FECHA_NACIMIENTO"]);
                    var da = fecha_naci ? (moment().format("YYYY") )+"-"+moment(response.body.atributos[0]["FECHA_NACIMIENTO"],'DD-MMM').format("MM-DD").toString():null;
                    this.Fecha_Nacimiento = fecha_naci ? moment(da,"YYYY-MM-DD").subtract(this.Edad,'years').format("YYYY-MM-DD"): null;
                    //this.Fecha_Nacimiento = isempty(response.body.atributos[0]["FECHA_NACIMIENTO"])?null:moment(response.body.atributos[0]["FECHA_NACIMIENTO"],'DD-MMM-YY').format("YYYY-MM-DD");
                    this.Lengua_Materna = response.body.atributos[0]["LENGUA_MATERNA"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];
                }
             });

        }

    }
  }
