Vue.component('cargar-archivos', {
    template:'#cargar-archivos',
    data:()=>({
        
        showModal: false,
        archivo:null,
        archivos:[],
       
    }),
    created:function(){
    },
    mounted:function(){
    
    },
    updated:function(){
    },
    methods:{
        guardar(){
            var formData = new FormData(document.getElementById("formuploadajax"))
            formData.append("archivo",document.getElementById('archivo'));
           /* formData.append("anio",(this.anio));
            formData.append("mes",(this.mes));*/
            this.$http.post('adjuntar_archivo?view',formData,{headers: {'Content-Type': 'multipart/form-data'}}).then(function(response){
            });
        },
        eliminar(usuario){
            swal({
                title: "Estás seguro?",
                text: "Desea Eliminar el usuario seleccionado: "+usuario.NOMBRE,
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
                    this.nivel_id =null;
                    this.usuario=null;
                    this.clave=null;
                    this.cclave=null;
                    this.showModal = true;
                    this.mostrar = true;
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
                    this.usuario=usuario.USUARIO;
                    this.clave=usuario.CLAVE;
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
            this.$http.post('listar_usuarios?view').then(function(response){
                if( response.body.data ){
                    this.usuarios= response.body.data;
                }

            });
        },
        mostrar_formulario(){
            this.showModal = true;
        }

    }
  })
