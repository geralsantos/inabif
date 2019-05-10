var reporte_nominal= {
    template:'#reporte-nominal',
    data:()=>({

       residentes:[],

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
    beforeDestroy() {
      },
    methods:{

        buscar_residente(){
            this.id_residente = null;

            var word = this.nombre_residente;
            if( word.length >= 2){
                this.coincidencias = [];
                this.bloque_busqueda = true;
                this.isLoading = true;

                this.$http.post('buscar_residente_nominal?view',{like:word }).then(function(response){

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

        },
        mostrar_reporte_nominal(){

            this.$http.post('mostrar_reporte_nominal?view',{id_residente:this.id_residente}).then(function(response){

                if( response.body.data != undefined){
                    this.residentes = response.body.data;

                }else{
                    swal("", "No hay registros para este reporte", "error");
                }
            });

        },
        descargar_reporte_matriz_nominal(){

            let datos = {id_residente:this.id_residente};
            let self = this
            //window.open(('descargar_reporte_matriz_nominal?view&id_residente='+self.id_residente),'_blank');
            this.$http.post('descargar_reporte_matriz_nominal?view',datos).then(function(response){

                if( response.body.data != undefined){
                   /* window.open('http://YOUR_URL','_blank');
                    var $a = $("<a>"); 
                    $a.attr("href",data.file); 
                    $("body").append($a); 
                    $a.attr("download","file.xls"); 
                    $a[0].click(); 
                    $a.remove();*/
                    //ExportExcel("tbl_temp","",response.body.data);
                   tableToExcel('tbl_temp','Reporte Nominal',response.body.data);
                    this.matriz_general = response.body.data;

                }else{
                    swal("", "El residente no cuenta con registros para este reporte", "error");
                }
            });

        },
        mostrar_lista_residentes(){
            this.id_residente = null;
            this.isLoading = true;
                this.$http.post('ejecutar_consulta_lista_nominal?view',{}).then(function(response){

                    if( response.body.data != undefined){
                        let data = response.body.data;
                          // => objects for [['barney', 36], ['barney', 34], ['fred', 48], ['fred', 40]]
                        let new_data = (_.sortBy(data, ['apellido_p']));
                        this.modal_lista = true;
                        this.isLoading = false;

                        new_data = new_data.map( function( item ){
                            for(var key in item){
                                var upper = key.toUpperCase();
                                // check if it already wasn't uppercase
                                if( upper !== key ){ 
                                    item[ upper ] = item[key];
                                    delete item[key];
                                }
                            }
                            return item;
                        });
                        console.log(new_data)
                        this.pacientes = new_data;

                    }else{
                        swal("", "No existe ningún residente", "error")
                    }
                 });

        },
        elegir_residente(residente){

            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
let apellido = apellido_p + ' ' + apellido_m;

            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

        }


    }
  }
