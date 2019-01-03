Vue.component('nna-seguimientos-salud', {
    template: '#nna-seguimientos-salud',
    data:()=>({
     
        Plan_Intervencion:null,
        Meta_PAI :null,
        Informe_tecnico :null,
        Cumple_Intervencion:null,
        Control_CRED:null,
        Vacunacion:null,
                        
        nombre_residente:null,
        isLoading:false,
        mes:moment().format("M"),
        anio:(new Date()).getFullYear(),
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null,
        modal_lista:false,
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
            if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'warning');
                return false;
            }
            let valores = {
               
                Plan_Intervencion:this.Plan_Intervencion,
                Meta_PAI :this.Meta_PAI,
                Informe_tecnico :this.Informe_tecnico,
                Cumple_Intervencion:this.Cumple_Intervencion,
                Control_CRED:this.Control_CRED,
                Vacunacion:this.Vacunacion,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                
            this.$http.post('insertar_datos?view',{tabla:'NNASalud_Semestral', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'NNASalud_Semestral', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Plan_Intervencion = response.body.atributos[0]["PLAN_INTERVENCION"];
                    this.Meta_PAI = response.body.atributos[0]["META_PAI"];
                    this.Informe_Tecnico = response.body.atributos[0]["INFORME_TECNICO"];
                    this.Cumple_Intervencion = response.body.atributos[0]["CUMPLE_INTERVENCION"];
                    this.Control_CRED = response.body.atributos[0]["CONTROL_CRED"];
                    this.Vacunacion = response.body.atributos[0]["VACUNACION"];
                  

                }
             });

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

            this.Plan_Intervencion = null;
            this.Meta_PAI = null;
            this.Informe_Tecnico = null;
            this.Cumple_Intervencion = null;
            this.Control_CRED = null;
            this.Vacunacion = null;

            this.id_residente = residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido = (residente.APELLIDO==undefined)?'':residente.APELLIDO;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'NNASalud_Semestral', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Plan_Intervencion = response.body.atributos[0]["PLAN_INTERVENCION"];
                    this.Meta_PAI = response.body.atributos[0]["META_PAI"];
                    this.Informe_Tecnico = response.body.atributos[0]["INFORME_TECNICO"];
                    this.Cumple_Intervencion = response.body.atributos[0]["CUMPLE_INTERVENCION"];
                    this.Control_CRED = response.body.atributos[0]["CONTROL_CRED"];
                    this.Vacunacion = response.body.atributos[0]["VACUNACION"];
                  

                }
             });

        }
        
    }
  })
