Vue.component('pam-atenciones-salud', {
    template:'#pam-atenciones-salud',
    data:()=>({
        Terapia_Fisica_Rehabilitacion:null,
        Arte:null,
        Nro_Arte:null,
        Dibujo_Pintura:null,
        Nro_Arte_Dibujo_Pintura:null,
        Manualidades:null,
        Nro_Arte_Manualidades:null,
        Otros:null,
        Nro_Arte_Otros:null,
            
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
                Id: 1,
                Terapia_Fisica_Rehabilitacion:this.Terapia_Fisica_Rehabilitacion,
                Arte:this.Arte,
                Nro_Arte:this.Nro_Arte,
                Dibujo_Pintura:this.Dibujo_Pintura,
                Nro_Arte_Dibujo_Pintura:this.Nro_Arte_Dibujo_Pintura,
                Manualidades:this.Manualidades,
                Nro_Arte_Manualidades:this.Nro_Arte_Manualidades,
                Otros:this.Otros,
                Nro_Arte_Otros:this.Nro_Arte_Otros,
           
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                  
            this.$http.post('insertar_datos?view',{tabla:'pam_ActividadSociorecrea', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_ActividadSociorecrea', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Terapia_Fisica_Rehabilitacion = response.body.atributos[0]["Terapia_Fisica_Rehabilitacion"];
                    this.Arte = response.body.atributos[0]["Arte"];
                    this.Nro_Arte = response.body.atributos[0]["Nro_Arte"];
                    this.Dibujo_Pintura = response.body.atributos[0]["Dibujo_Pintura"];
                    this.Nro_Arte_Dibujo_Pintura = response.body.atributos[0]["Nro_Arte_Dibujo_Pintura"];
                    this.Manualidades = response.body.atributos[0]["Manualidades"];
                    this.Nro_Arte_Manualidades = response.body.atributos[0]["Nro_Arte_Manualidades"];
                    this.Otros = response.body.atributos[0]["Otros"];
                    this.Nro_Arte_Otros = response.body.atributos[0]["Nro_Arte_Otros"];

        
                }
             });

        },
        
    }
  })
