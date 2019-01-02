Vue.component('nna-actividades-sociorecreativas', {
    template:'#nna-actividades-sociorecreativas',
    data:()=>({
        
        Nro_Arte:null,
        Nro_BioHuerto:null,
        Nro_Zapateria:null,
        Nro_Carpinteria:null,
        Nro_Ceramica :null,
        Nro_Crianza:null,
        Nro_Dibujo:null,
        Nro_Tejido:null,
        Nro_Deportes:null, 
        Nro_Taller_Pro:null,

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
               
                Nro_Arte:this.Nro_Arte,
                Nro_BioHuerto:this.Nro_BioHuerto,
                Nro_Zapateria:this.Nro_Zapateria,
                Nro_Carpinteria:this.Nro_Carpinteria,
                Nro_Ceramica :this.Nro_Ceramica,
                Nro_Crianza:this.Nro_Crianza,
                Nro_Dibujo:this.Nro_Dibujo,
                Nro_Tejido:this.Nro_Tejido,
                Nro_Deportes:this.Nro_Deportes, 
                Nro_Taller_Pro:this.Nro_Taller_Pro,
                
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                
            this.$http.post('insertar_datos?view',{tabla:'NNAActividadesSociorecrea', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'NNAActividadesSociorecrea', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Nro_Arte = response.body.atributos[0]["NRO_ARTE"];
                    this.Nro_BioHuerto = response.body.atributos[0]["NRO_BIOHUERTO"];
                    this.Nro_Zapateria = response.body.atributos[0]["NRO_ZAPATERIA"];
                    this.Nro_Carpinteria = response.body.atributos[0]["NRO_CARPINTERIA"];
                    this.Nro_Ceramica = response.body.atributos[0]["NRO_CERAMICA"];
                    this.Nro_Crianza = response.body.atributos[0]["NRO_CRIANZA"];
                    this.Nro_Dibujo = response.body.atributos[0]["NRO_DIBUJO"];
                    this.Nro_Tejido = response.body.atributos[0]["NRO_TEJIDO"];
                    this.Nro_Deportes = response.body.atributos[0]["NRO_DEPORTES"];
                    this.Nro_Taller_Pro = response.body.atributos[0]["NRO_TALLER_PRO"];


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

            this.Nro_Arte = null;
            this.Nro_BioHuerto = null;
            this.Nro_Zapateria =  null;
            this.Nro_Carpinteria =  null;
            this.Nro_Ceramica =  null;
            this.Nro_Crianza =  null;
            this.Nro_Dibujo =  null;
            this.Nro_Tejido =  null;
            this.Nro_Deportes =  null;
            this.Nro_Taller_Pro =  null;

            this.id_residente = residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido = (residente.APELLIDO==undefined)?'':residente.APELLIDO;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'NNAActividadesSociorecrea', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Nro_Arte = response.body.atributos[0]["NRO_ARTE"];
                    this.Nro_BioHuerto = response.body.atributos[0]["NRO_BIOHUERTO"];
                    this.Nro_Zapateria = response.body.atributos[0]["NRO_ZAPATERIA"];
                    this.Nro_Carpinteria = response.body.atributos[0]["NRO_CARPINTERIA"];
                    this.Nro_Ceramica = response.body.atributos[0]["NRO_CERAMICA"];
                    this.Nro_Crianza = response.body.atributos[0]["NRO_CRIANZA"];
                    this.Nro_Dibujo = response.body.atributos[0]["NRO_DIBUJO"];
                    this.Nro_Tejido = response.body.atributos[0]["NRO_TEJIDO"];
                    this.Nro_Deportes = response.body.atributos[0]["NRO_DEPORTES"];
                    this.Nro_Taller_Pro = response.body.atributos[0]["NRO_TALLER_PRO"];


                }
             });

        }
        
    }
  })
