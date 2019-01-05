Vue.component('cargar-archivos', {
    template:'#cargar-archivos',
    data:()=>({
        
        showModal: false,
        archivo:null,
        archivos:[],
        nombre_residente:null,
        isLoading:false,
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null,
        modal_lista:false,
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
            this.$http.post('adjuntar_archivo?view',formData,{headers: {'Content-Type': 'multipart/form-data'}}).then(function(response){
                let data = response.body.resultado;
                if (data) {
                    swal("Subida", "El archivo ha sido subido.", "success");
                    this.listar_archivos_adjuntos();
                    this.showModal = false;
                }else{
                    swal("Error", "Un error ha ocurrido", "error");
                }
            });
        },
        eliminar(archivo){
            swal({
                title: "Estás seguro?",
                text: "Desea Eliminar el archivo seleccionado: "+archivo.NOMBRE,
                icon: "warning",
                buttons: true,
                dangerMode: true,
              })
              .then((willDelete) => {
                if (willDelete) {
                    let where = {id:archivo.ID}
                    this.$http.post('delete_datos?view',{tabla:'archivos_adjuntados',where:where}).then(function(response){
                        if( response.body.resultado ){
                            swal("Archivo Eliminado!", {
                                icon: "success",
                              });
                            this.listar_archivos_adjuntos();
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
        mostrar_formulario(){
            this.showModal = true;
        },
        descargar(archivo){
            console.log(archivo);
            downloadLink('/inabif/app/cargas/'+archivo.NOMBRE);
        },
        actualizar(coincidencia){
            this.id_residente = coincidencia.ID;     
            this.nombre_residente = (coincidencia.NOMBRE==undefined)?'':coincidencia.NOMBRE;          
            this.id=coincidencia.ID;
            this.coincidencias = [];
            this.bloque_busqueda = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'archivos_adjuntados', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){
                    
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];
                    this.archivos= response.body.atributos;

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
        }

    }
  })
