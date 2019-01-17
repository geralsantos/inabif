Vue.component('reniec-consulta', {
    template:'#reniec-consulta',
    data:()=>({
        Ape_Paterno:null,
        Ape_Materno:null,
        Nom_Usuario:null,
        Pais_Procencia:null,
        Depatamento_Procedencia:null,
        Provincia_Procedencia:null,
        Distrito_Procedencia:null,
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
    methods:{
        inicializar(){
            this.Ape_Paterno = null;
            this.Ape_Materno = null;
            this.Nom_Usuario = null;
            this.Pais_Procencia = null;
            this.Depatamento_Procedencia = null;
            this.Provincia_Procedencia = null;
            this.Distrito_Procedencia = null;
            this.Sexo = null;
            this.Fecha_Nacimiento = null;
            this.Edad = null;
            this.Lengua_Materna = null;
            this.id = null;

            this.nombre_residente=null;
            this.isLoading=false;
            this.mes=moment().format("M");
            this.anio=(new Date()).getFullYear();
            this.coincidencias=[];
            this.bloque_busqueda=false;
            this.id_residente=null;
            this.modal_lista=false;
            this.pacientes = [];

        },
        guardar(){
            /*if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'warning');
                return false;
            }*/
            let valores = {
                Ape_Paterno: this.Ape_Paterno,
                Ape_Materno: this.Ape_Materno,
                Nom_Usuario: this.Nom_Usuario,
                Pais_Procencia: this.Pais_Procencia,
                Depatamento_Procedencia: this.Depatamento_Procedencia || null,
                Provincia_Procedencia: this.Provincia_Procedencia || null,
                Distrito_Procedencia: this.Distrito_Procedencia || null,
                Sexo: this.Sexo,
                Fecha_Nacimiento:  moment(this.Fecha_Nacimiento, "YYYY-MM-DD").format("YYYY-MM-DD"),
                Edad: this.Edad,
                Lengua_Materna: this.Lengua_Materna,

                //Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

                }

            /*this.$http.post('insertar_datos?view',{tabla:'CarIdentificacionUsuario', valores:valores}).then(function(response){

                if( response.body.resultado ){
                    swal('', 'Registro Guardado', 'success');

                }else{
                  swal("", "Un error ha ocurrido", "error");
                }
            });*/
           /* let valores_arr = Object.values(valores);
                for (let index = 0; index < valores_arr.length; index++) {
                    if (isempty(valores_arr[index])) {
                        swal('Error', 'Debe llenar todos los campos', 'warning');
                        return false;
                    }
                }*/
                if (isempty(this.id_residente)) {
                    let valores_residente = {


                        nombre : this.Nom_Usuario,
                        apellido_p : this.Ape_Paterno,
                        apellido_m : this.Ape_Materno,
                        pais_id : this.Pais_Procencia,
                        departamento_naci_cod : this.Depatamento_Procedencia || null,
                        provincia_naci_cod : this.Provincia_Procedencia || null,
                        distrito_naci_cod : this.Distrito_Procedencia || null,
                        sexo: this.Sexo,
                        fecha_naci :  moment(this.Fecha_Nacimiento, "YYYY-MM-DD").format("YYYY-MM-DD"),
                        edad: this.Edad,
                        lengua_materna: this.Lengua_Materna,
                        //documento :this.Numero_Doc
                        }
                        console.log(valores_residente);
                    this.$http.post('insertar_datos?view',{tabla:'residente', valores:valores_residente,lastid:true}).then(function(response){
                        valores.Residente_Id = response.body.lastid;
                        console.log(response.body.lastid);
                        this.$http.post('insertar_datos?view',{tabla:'CarIdentificacionUsuario', valores:valores}).then(function(response){
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
                    this.$http.post('insertar_datos?view',{tabla:'CarIdentificacionUsuario', valores:valores}).then(function(response){
                        if( response.body.resultado ){
                            this.inicializar();
                            swal('', 'Registro Guardado', 'success');
                        }else{
                          swal("", "Un error ha ocurrido", "error");
                        }
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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarIdentificacionUsuario', residente_id:this.id_residente }).then(function(response){

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
            this.Pais_Procencia = null;
            this.Depatamento_Procedencia = null;
            this.Provincia_Procedencia = null;
            this.Distrito_Procedencia = null;
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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarIdentificacionUsuario', residente_id:this.id_residente }).then(function(response){

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
             });

        }

    }
  })
