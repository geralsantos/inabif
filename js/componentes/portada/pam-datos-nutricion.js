Vue.component('pam-datos-nutricion-salud', {
    template:'#pam-datos-nutricion',
    data:()=>({
        Plan_Intervencion:null,
        Meta_PAI:null,
        Informe_Tecnico:null,
        Des_Informe_Tecnico:null,
        Cumple_Intervencion:null,
        Estado_Nutricional_IMC:null,
        Peso:null,
        Talla:null,
        Hemoglobina:null,
             
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
                Meta_PAI:this.Meta_PAI,
                Informe_Tecnico:this.Informe_Tecnico,
                Des_Informe_Tecnico:this.Des_Informe_Tecnico,
                Cumple_Intervencion:this.Cumple_Intervencion,
                Estado_Nutricional_IMC:this.Estado_Nutricional_IMC,
                Peso:this.Peso,
                Talla:this.Talla,
                Hemoglobina:this.Hemoglobina,
    
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

                    this.discapacidad = response.body.atributos[0]["discapacidad"];
                    this.discapacidad_fisica = response.body.atributos[0]["discapacidad_fisica"];
                    this.discapacidad_intelectual = response.body.atributos[0]["discapacidad_intelectual"];
                    this.discapacidad_sensorial = response.body.atributos[0]["discapacidad_sensorial"];
                    this.presenta_discapacidad_mental = response.body.atributos[0]["presenta_discapacidad_mental"];
                    this.dx_certificado = response.body.atributos[0]["dx_certificado"];
                    this.carnet_conadis = response.body.atributos[0]["carnet_conadis"];
                    this.grado_dependencia_pam = response.body.atributos[0]["grado_dependencia_pam"];
                    this.motivo_dif_desplazamiento = response.body.atributos[0]["motivo_dif_desplazamiento"];
                    this.enfermedad_ingreso_1 = response.body.atributos[0]["enfermedad_ingreso_1"];
                    this.tipo_patologia = response.body.atributos[0]["tipo_patologia"];
                    this.enfermedad_ingreso_2 = response.body.atributos[0]["enfermedad_ingreso_2"];
                    this.nivel_hemoglobina = response.body.atributos[0]["nivel_hemoglobina"];
                    this.presenta_anema = response.body.atributos[0]["presenta_anema"];
                    this.peso = response.body.atributos[0]["peso"];
                    this.talla = response.body.atributos[0]["talla"];
                    this.estado_nutricional = response.body.atributos[0]["estado_nutricional"];
                }
             });

        },
       
    }
  })
