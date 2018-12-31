Vue.component('registro-perfiles', {
    template:'#registro-perfiles',
    data:()=>({
        Apellido: this.Apellido,
        Nombre: this.Nom_Usuario,
        Correo: this.Correo,
        DNI:this.DNI,
        NumCel: this.NumCel,
        centroID:null,
        centros:[],
        showModal: false,
        usuarios:[],
        id_usuario:null,
    }),
    created:function(){
    },
    mounted:function(){
        this.buscar_centros();
        this.listar_usuarios();
    },
    updated:function(){
    },
    methods:{
        guardar(){
            /*if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'success');
                return false;
            }*/
            let valores = {
                Apellido: this.Apellido,
                Nombre: this.Nom_Usuario,
                Correo: this.Correo,
                DNI:this.DNI,
                NumCel: this.NumCel,
                centro_id :1,
                }

            this.$http.post('insertar_datos?view',{tabla:'usuarios', valores:valores}).then(function(response){

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
                    this.Fecha_Nacimiento = moment(response.body.atributos[0]["FECHA_NACIMIENTO"]).format("YYYY-MM-DD");
                    this.Edad = response.body.atributos[0]["EDAD"];
                    this.Lengua_Materna = response.body.atributos[0]["LENGUA_MATERNA"];
                }
             });

        }, 
        verRegistro(usuario){
            this.showModal = true;
            let  where = {'id':usuario.ID};
              this.$http.post('buscar?view',{where:where}).then(function(response){
                  this.registro = response.body.atributos[0];
                  this.id_usuario=usuario.ID
                  this.showModal = true;
              });
          },
        buscar_centros(){
            this.$http.post('buscar?view',{tabla:'centro_atencion'}).then(function(response){
                if( response.body.data ){
                    this.lenguas= response.body.data;
                }

            });
        },
        listar_usuarios(){
            this.$http.post('buscar?view',{tabla:'usuarios'}).then(function(response){
                if( response.body.data ){
                    this.usuarios= response.body.data;
                }

            });
        }
    }
  })
