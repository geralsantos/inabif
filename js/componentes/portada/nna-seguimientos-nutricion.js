Vue.component('nna-seguimientos-nutricion', {
    template: '#nna-seguimientos-nutricion',
    data:()=>({
     
        Plan_Intervencion:null,
        Meta_PAI:null,
        Informe_Tecnico:null,
        Cumple_Intervencion:null,
        Estado_Nutricional_Peso	:null,
        Estado_Nutricional_Talla:null,
        Hemeglobina :null,
        Analisis_Hemoglobina :null,
                        
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
                swal('Error', 'Residente no existe', 'warning');
                return false;
            }
            let valores = {
               
                Plan_Intervencion:this.Plan_Intervencion,
                Meta_PAI:this,Meta_PAI,
                Informe_Tecnico:this.Informe_Tecnico,
                Cumple_Intervencion:this.Cumple_Intervencion,
                Estado_Nutricional_Peso	:null,
                Estado_Nutricional_Talla:null,
                Hemeglobina :this.Hemeglobina,
                Analisis_Hemoglobina :this.Analisis_Hemoglobina,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                
            this.$http.post('insertar_datos?view',{tabla:'NNAnutricion_Semestral', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'NNAnutricion_Semestral', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Nro_Talleres_E = response.body.atributos[0]["NRO_TALLERES_E"];
                    this.Nro_Campanas = response.body.atributos[0]["NRO_CAMPANAS"];
                    this.Nro_Atencion_Fisi = response.body.atributos[0]["NRO_ATENCION_FISI"];
                    this.Nro_Atencon_Ocupa = response.body.atributos[0]["NRO_ATENCON_OCUPA"];
                    this.Nro_Atencion_Lengua = response.body.atributos[0]["NRO_ATENCION_LENGUA"];
          
                }
             });

        },
        
    }
  })
