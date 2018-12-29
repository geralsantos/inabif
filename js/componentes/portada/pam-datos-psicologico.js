Vue.component('pam-datos-psicologico', {
    template:'#pam-datos-psicologico',
    data:()=>({
        
        Plan_Intervencion:null,
        Des_Meta:null,
        Informe_Tecnico:null,
        Des_Informe_Tecnico:null,
        Cumple_Intervencion:null,
        Deterioro_Cognitivo:null,
        Transtorno_Depresivo:null,
        Severidad_Trans_Depresivo:null,

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
                
                Plan_Intervencion:this.Plan_Intervencion,
                Des_Meta:this.Des_Meta,
                Informe_Tecnico:this.Informe_Tecnico,
                Des_Informe_Tecnico:this.Des_Informe_Tecnico,
                Cumple_Intervencion:this.Cumple_Intervencion,
                Deterioro_Cognitivo:this.Deterioro_Cognitivo,
                Transtorno_Depresivo:this.Transtorno_Depresivo,
                Severidad_Trans_Depresivo:this.Severidad_Trans_Depresivo,
    
            }
             
            this.$http.post('insertar_datos?view',{tabla:'pam_nutricion', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_nutricion', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Plan_Intervencion = response.body.atributos[0]["Plan_Intervencion"];
                    this.Des_Meta = response.body.atributos[0]["Des_Meta"];
                    this.Informe_Tecnico = response.body.atributos[0]["Informe_Tecnico"];
                    this.Des_Informe_Tecnico = response.body.atributos[0]["Des_Informe_Tecnico"];
                    this.Cumple_Intervencion = response.body.atributos[0]["Cumple_Intervencion"];
                    this.Deterioro_Cognitivo = response.body.atributos[0]["Deterioro_Cognitivo"];
                    this.Transtorno_Depresivo = response.body.atributos[0]["Transtorno_Depresivo"];
                    this.Severidad_Trans_Depresivo = response.body.atributos[0]["Severidad_Trans_Depresivo"];
                  
                }
             });

        },
       
    }
  })
