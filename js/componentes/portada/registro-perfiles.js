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
        centro_id:null,
        niveles_usuarios:[],
        nivel_id:null,
    }),
    created:function(){
    },
    mounted:function(){
        this.buscar_centros();
        this.listar_usuarios();
        this.listar_nivelesusuarios();
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
                Nombre: this.Nombre,
                Correo: this.Correo,
                DNI:this.DNI,
                NumCel: this.NumCel,
                NumCel: this.NumCel,
                NIVEL :this.nivel_id,
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
        EliminarUsuario(usuario){
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    let where = {id:usuario.ID}
                    this.$http.post('delete_datos?view',{tabla:'usuarios',where:where}).then(function(response){
                        if( response.body.resultado ){
                            swal("Usuario Eliminado!", {
                                icon: "success",
                              });
                            this.listar_usuarios();
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
        listar_usuarios(){
            this.$http.post('buscar?view',{tabla:'usuarios'}).then(function(response){
                if( response.body.data ){
                    this.usuarios= response.body.data;
                }

            });
        },
        listar_nivelesusuarios(){
            this.$http.post('buscar?view',{tabla:'niveles_usuarios'}).then(function(response){
                if( response.body.data ){
                    this.niveles_usuarios= response.body.data;
                }

            });
        }
    }
  })
