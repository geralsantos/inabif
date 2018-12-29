Vue.component('ppd-datos-identificacion-residente', {
    template:'#ppd-datos-identificacion-residente',
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

        paises:[],
        departamentos:[],
        provincias:[],
        distritos:[],
        lenguas:[],

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
        this.buscar_paises();
        this.buscar_lenguas();
        this.buscar_departamentos();
    },
    updated:function(){
    },
    methods:{
        guardar(){
            if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'success');
                return false;
            }
            let valores = {
                Ape_Paterno: this.Ape_Paterno,
                Ape_Materno: this.Ape_Materno,
                Nom_Usuario: this.Nom_Usuario,
                Pais_Procencia: this.Pais_Procencia,
                Depatamento_Procedencia: this.Depatamento_Procedencia,
                Provincia_Procedencia: this.Provincia_Procedencia,
                Distrito_Procedencia: this.Distrito_Procedencia,
                Sexo: this.Sexo,
                Fecha_Nacimiento:  moment(this.Fecha_Nacimiento, "YYYY-MM-DD").format("YY-MMM-DD"),
                Edad: this.Edad,
                Lengua_Materna: this.Lengua_Materna,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

                }

            this.$http.post('insertar_datos?view',{tabla:'CarIdentificacionUsuario', valores:valores}).then(function(response){

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
                    this.Fecha_Nacimiento = response.body.atributos[0]["FECHA_NACIMIENTO"];
                    this.Edad = response.body.atributos[0]["EDAD"];
                    this.Lengua_Materna = response.body.atributos[0]["LENGUA_MATERNA"];
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
                    this.Depatamento_Procedencia = response.body.data[0]["CODDEPT"];
                    this.buscar_provincias();

                }

            });
        },
        buscar_provincias(){
            this.$http.post('buscar_provincia?view',{tabla:'ubigeo', coddept:this.Depatamento_Procedencia}).then(function(response){
                if( response.body.data ){
                    this.provincias= response.body.data;
                    this.Provincia_Procedencia = response.body.data[0]["CODPROV"];
                    this.buscar_distritos();
                }

            });
        },
        buscar_distritos(){
            this.$http.post('buscar?view',{tabla:''}).then(function(response){
                if( response.body.data ){
                    this.distritos= response.body.data;
                    this.Distrito_Procedencia = response.body.data[0]["CODDIST"];
                }

            });
        },
        buscar_lenguas(){
            this.$http.post('buscar?view',{tabla:''}).then(function(response){
                if( response.body.data ){
                    this.lenguas= response.body.data;
                }

            });
        },

    }
  })
