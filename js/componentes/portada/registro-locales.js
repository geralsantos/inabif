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
        id_usuario:null,
        centro_id:null,
        niveles_usuarios:[],
        nivel_id:null,
        tipo_centro_id: this.tipo_centro_id,
        codigo_entidad:null,
        nombre_entidad:null,
        cod_serv:null,
        cod_ca:null,
        administrador_nombre:null,
        nombre_director :null,
        telefono :null,
        direccion_car :null,
        area_residencia :null,
        codigo_linea :null,
        linea_intervencion :null,
        nom_serv :null,
    }),
    created:function(){
    },
    mounted:function(){
        this.buscar_centros();
        this.buscar_tipocentros();
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
                tipo_centro_id: this.tipo_centro_id,
                codigo_entidad: this.codigo_entidad,
                nombre_entidad: this.nombre_entidad,
                cod_serv:this.cod_serv,
                cod_ca: this.cod_ca,
                administrador_nombre: this.administrador_nombre,
                nombre_director :this.nombre_director,
                telefono :this.telefono,
                direccion_car :this.direccion_car,
                area_residencia :this.area_residencia,
                codigo_linea :this.codigo_linea,
                linea_intervencion :this.linea_intervencion,
                nom_serv :this.nom_serv,
                }
                if (this.id_usuario==null) {
                    this.$http.post('insertar_datos?view',{tabla:'usuarios', valores:valores}).then(function(response){

                        if( response.body.resultado ){
                            swal('', 'Registro Guardado', 'success');
                            this.listar_usuarios();
                        }else{
                          swal("", "Un error ha ocurrido", "error");
                        }
                    });
                }else{
                    let where = {id:this.id_usuario};
                    this.$http.post('update_datos?view',{tabla:'usuarios', valores:valores,where:where}).then(function(response){
                        if( response.body.resultado ){
                            swal('', 'Registro Actualizado', 'success');
                            this.listar_usuarios();
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
                this.tipo_centro_id=null;
                this.codigo_entidad=null;
                this.nombre_entidad=null;
                this.cod_serv=null;
                this.cod_ca=null;
                this.administrador_nombre=null;
                this.nombre_director=null;
                this.telefono=null;
                this.direccion_car=null;
                this.area_residencia=null;
                this.codigo_linea=null;
                this.linea_intervencion=null;
                this.nom_serv=null;
                this.showModal = true;
            }else{
                console.log(centro);
 //let  where = {'id':usuario.ID};
              //this.$http.post('buscar?view',{where:where}).then(function(response){
                    //this.registro = response.body.atributos[0];
                this.tipo_centro_id=centro.TIPO_CENTRO_ID;
                this.codigo_entidad=centro.CODIGO_ENTIDAD;
                this.nombre_entidad=centro.NOMBRE_ENTIDAD;
                this.cod_serv=centro.COD_SERV;
                this.cod_ca=centro.COD_CA;
                this.administrador_nombre=centro.ADMINISTRADOR_NOMBRE;
                this.nombre_director=centro.NOMBRE_DIRECTOR;
                this.telefono=centro.TELEFONO;
                this.direccion_car=centro.DIRECCION_CAR;
                this.area_residencia=centro.AREA_RESIDENCIA;
                this.codigo_linea=centro.CODIGO_LINEA;
                this.linea_intervencion=centro.LINEA_INTERVENCION;
                this.nom_serv=centro.NOM_SERV;

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
        }/*,
        listar_nivelesusuarios(){
            this.$http.post('buscar?view',{tabla:'niveles_usuarios'}).then(function(response){
                if( response.body.data ){
                    this.niveles_usuarios= response.body.data;
                }

            });
        }*/
    }
  })
