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
        tipo_documento :null,
        pacientes:[]
    }),
    created:function(){
    },
    mounted:function(){
    },
    updated:function(){
    },
    methods:{
        guardar(){
            let self = this;
            if (self.tipo_documento == null) {
                swal("Error", "Un error ha ocurrido", "error");
                return false;
            }
            var formData = new FormData(document.getElementById("formuploadajax"))
            formData.append("archivo",document.getElementById('archivo'));
            formData.append("residente_id",self.id_residente);
            formData.append("tipo_documento",self.tipo_documento);
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
        listar_archivos_adjuntos(){
            let where = {residente_id:this.id_residente}
            console.log(where);
            this.archivos = [];
            this.$http.post('cargar_datos?view',{tabla:"archivos_adjuntados",where:where}).then(function(response){
                console.log(response);
                if( response.body.atributos ){
                    this.archivos= response.body.atributos;
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
            let where = {residente_id:this.id_residente}
            this.$http.post('cargar_datos?view',{tabla:'archivos_adjuntados', where:where }).then(function(response){

                if( response.body.atributos != undefined){

                    this.id = response.body.atributos[0]["RESIDENTE_ID"];
                    this.archivos= response.body.atributos;

                }else{
                    this.archivos= [];
                    swal("Error", "El residente aún no cuenta con archivos adjuntos", "error");
                }
             });

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
                this.id_residente = null;
                this.id = null;
                this.archivos = [];
            }
        },
        mostrar_lista_residentes(){

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

            this.id=null;
            this.archivos=[];
            this.id_residente = residente.ID;
            this.nombre_residente = (residente.NOMBRE==undefined)?'':residente.NOMBRE;
            this.id=residente.ID;
            this.bloque_busqueda = false;
            let where = {residente_id:this.id_residente}
            this.modal_lista = false
            this.$http.post('cargar_datos?view',{tabla:'archivos_adjuntados', where:where }).then(function(response){

                if( response.body.atributos != undefined){

                    this.id = response.body.atributos[0]["RESIDENTE_ID"];
                    this.archivos= response.body.atributos;

                }else{
                    this.archivos= [];
                    swal("Error", "El residente aún no cuenta con archivos adjuntos", "error");
                }
             });

        }

    }
  })
