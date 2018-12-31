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
        verRegistro(usuario){
            if (isempty(usuario)) {
                    this.id_usuario=null;
                    this.Apellido= null;
                    this.Nombre= null;
                    this.Correo= null;
                    this.DNI=null;
                    this.NumCel= null;
                    this.centro_id =null;
                    this.nivel_id =null,

                    this.showModal = true;
            }else{
                console.log(usuario);
 //let  where = {'id':usuario.ID};
              //this.$http.post('buscar?view',{where:where}).then(function(response){
                    //this.registro = response.body.atributos[0];
                    this.id_usuario=usuario.ID;
                    this.Apellido= usuario.APELLIDO;
                    this.Nombre= usuario.NOMBRE;
                    this.Correo= usuario.CORREO;
                    this.DNI=usuario.DNI;
                    this.NumCel= usuario.NUMCEL;
                    this.centro_id =usuario.CENTRO_ID,
                    this.nivel_id =usuario.NIVEL,

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
