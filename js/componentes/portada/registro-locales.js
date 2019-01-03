Vue.component('registro-locales', {
    template:'#registro-locales',
    data:()=>({
        Apellido: this.Apellido,
        Nombre: this.Nom_Usuario,
        Correo: this.Correo,
        DNI:this.DNI,
        NumCel: this.NumCel,
        centroID:null,
        centros:[],
        showModal: false,
        tipo_centros:[],
        id_centro:null,
        centro_id:null,
        niveles_usuarios:[],
        nivel_id:null,
        tipo_centro_id: null,
        codigo_entidad:null,
        nombre_entidad:null,
        cod_serv:null,
        nom_ca :null,
        cod_ca:null,
        administrador_nombre:null,
        nombre_director :null,
        telefono :null,
        direccion_car :null,
        area_residencia :null,
        codigo_linea :null,
        linea_intervencion :null,
        nom_serv :null,
        departamentos:[],
        provincias:[],
        distritos:[],
        Depatamento_Procedencia:null,
        Provincia_Procedencia:null,
        Distrito_Procedencia:null,
    }),
    created:function(){
    },
    mounted:function(){
        this.buscar_centros();
        this.buscar_tipocentros();
        this.buscar_departamentos();
    },
    updated:function(){
    },
    watch:{
        Depatamento_Procedencia:function(val){ 
            this.buscar_provincias();
        }
    },
    methods:{
        guardar(){
            /*if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'warning');
                return false;
            }*/
            var valores = {
                tipo_centro_id: this.tipo_centro_id,
                codigo_entidad: this.codigo_entidad,
                nombre_entidad: this.nombre_entidad,
                cod_serv:this.cod_serv,
                ubigeo :this.Distrito_Procedencia,
                cod_ca: this.cod_ca,
                nom_ca: this.nom_ca,
                administrador_nombre: this.administrador_nombre,
                nombre_director :this.nombre_director,
                telefono :this.telefono,
                direccion_car :this.direccion_car,
                area_residencia :this.area_residencia,
                codigo_linea :this.codigo_linea,
                linea_intervencion :this.linea_intervencion,
                nom_serv :this.nom_serv,
                }
                console.log(valores);

                if (this.id_centro==null) {
                    console.log(valores);
                    this.$http.post('insertar_datos?view',{tabla:'centro_atencion', valores:valores}).then(function(response){

                        if( response.body.resultado ){
                            swal('', 'Registro Guardado', 'success');
                            this.buscar_centros();
                        }else{
                          swal("", "Un error ha ocurrido", "error");
                        }
                    });
                }else{
                    let where = {id:this.id_centro};
                    this.$http.post('update_datos?view',{tabla:'centro_atencion', valores:valores,where:where}).then(function(response){
                        if( response.body.resultado ){
                            swal('', 'Registro Actualizado', 'success');
                            this.buscar_centros();
                        }else{
                          swal("", "Un error ha ocurrido", "error");
                        }
                    });
                }
           
             
        },
        EliminarLocal(centro){
            swal({
                title: "Estás seguro?",
                text: "Desea Eliminar el local seleccionado: "+centro.NOM_CA,
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    let where = {id:centro.ID}
                    this.$http.post('delete_datos?view',{tabla:'centro_atencion',where:where}).then(function(response){
                        if( response.body.resultado ){
                            swal("Local Eliminado!", {
                                icon: "success",
                              });
                            this.buscar_centros();
                        }else{
                        swal("", "Un error ha ocurrido", "error");
                        }
                    });
                }
              });
            
        },
        verRegistro(centro){
            if (isempty(centro)) {
                this.id_centro=null;
                this.tipo_centro_id=null;
                this.codigo_entidad=null;
                this.nombre_entidad=null;
                this.cod_serv=null;
                this.cod_ca=null;
                this.nom_ca=null;
                this.administrador_nombre=null;
                this.nombre_director=null;
                this.telefono=null;
                this.direccion_car=null;
                this.area_residencia=null;
                this.codigo_linea=null;
                this.linea_intervencion=null;
                this.Depatamento_Procedencia=null;
                this.Provincia_Procedencia=null;
                this.Distrito_Procedencia=null;
                this.nom_serv=null;
                this.showModal = true;
            }else{
                console.log(centro);
 //let  where = {'id':usuario.ID};
              //this.$http.post('buscar?view',{where:where}).then(function(response){
                    //this.registro = response.body.atributos[0];
                this.id_centro=centro.ID;
                this.tipo_centro_id=centro.TIPO_CENTRO_ID;
                this.codigo_entidad=centro.CODIGO_ENTIDAD;
                this.nombre_entidad=centro.NOMBRE_ENTIDAD;
                this.cod_serv=centro.COD_SERV;
                this.cod_ca=centro.COD_CA;
                this.nom_ca=centro.NOM_CA;
                this.administrador_nombre=centro.ADMINISTRADOR_NOMBRE;
                this.nombre_director=centro.NOMBRE_DIRECTOR;
                this.telefono=centro.TELEFONO;
                this.direccion_car=centro.DIRECCION_CAR;
                this.area_residencia=centro.AREA_RESIDENCIA;
                this.codigo_linea=centro.CODIGO_LINEA;
                this.linea_intervencion=centro.LINEA_INTERVENCION;
                this.nom_serv=centro.NOM_SERV;
                this.Depatamento_Procedencia=(centro.UBIGEO).substr(0,2);
                this.Provincia_Procedencia=(centro.UBIGEO).substr(0,4);
                this.Distrito_Procedencia=centro.UBIGEO;

                this.showModal = true;
              //});
            }
           
          },
        buscar_centros(){
            this.$http.post('buscar?view',{tabla:'centro_atencion'}).then(function(response){
                if( response.body.data ){
                    this.centros= response.body.data;
                }

            });
        },
        buscar_tipocentros(){
            this.$http.post('buscar?view',{tabla:'tipo_centro'}).then(function(response){
                if( response.body.data ){
                    this.tipo_centros= response.body.data;
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
        buscar_provincias(){
            this.$http.post('buscar_provincia?view',{tabla:'ubigeo', cod:this.Depatamento_Procedencia}).then(function(response){
                if( response.body.data ){
                    this.provincias= response.body.data;
                    //this.Provincia_Procedencia = response.body.data[0]["CODPROV"];
                    this.buscar_distritos();
                }

            });
        },
        buscar_distritos(){
            this.$http.post('buscar_distritos?view',{tabla:'ubigeo', cod:this.Provincia_Procedencia}).then(function(response){
                if( response.body.data ){
                    this.distritos= response.body.data;
                    //this.Distrito_Procedencia = response.body.data[0]["CODDIST"];
                }

            });
        },
        mostrar_entidad(){
            console.log(this.tipo_centro_id)
           /* this.$http.post('buscar_distritos?view',{tabla:'ubigeo', cod:this.Provincia_Procedencia}).then(function(response){
                if( response.body.data ){
                    this.distritos= response.body.data;
                    //this.Distrito_Procedencia = response.body.data[0]["CODDIST"];
                }

            });*/
        }
        /*,
        listar_nivelesusuarios(){
            this.$http.post('buscar?view',{tabla:'niveles_usuarios'}).then(function(response){
                if( response.body.data ){
                    this.niveles_usuarios= response.body.data;
                }

            });
        }*/
    }
  })
