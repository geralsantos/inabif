Vue.component('pam-datos-generales-egreso', {
    template:'#pam-datos-generales-egreso',
    data:()=>({
        Fecha_Egreso:null,
        MotivoEgreso:null,
        Retiro_Voluntario:null,
        Reinsercion_Familiar:null,
        Traslado_Entidad_Salud:null,
        Traslado_Otra_Entidad:null,
        Fallecimiento:null,
        RestitucionAseguramientoSaludo:null,
        Restitucion_Derechos_DNI:null,
        RestitucionReinsercionFamiliar:null,
              
        nombre_residente:null,
        isLoading:false,
        mes:moment().format("M"),
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
              
                Fecha_Egreso:moment(this.Fecha_Egreso).format("YY-MMM-DD"),
                MotivoEgreso:this.MotivoEgreso,
                Retiro_Voluntario:this.Retiro_Voluntario,
                Reinsercion_Familiar:this.Reinsercion_Familiar,
                Traslado_Entidad_Salud:this.Traslado_Entidad_Salud,
                Traslado_Otra_Entidad:this.Traslado_Otra_Entidad,
                Fallecimiento:this.Fallecimiento,
                RestitucionAseguramientoSaludo:this.RestitucionAseguramientoSaludo,
                Restitucion_Derechos_DNI:this.Restitucion_Derechos_DNI,
                RestitucionReinsercionFamiliar:this.RestitucionReinsercionFamiliar,
                
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                     
            this.$http.post('insertar_datos?view',{tabla:'pam_EgresoUsuario', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_EgresoUsuario', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Fecha_Egreso = moment(response.body.atributos[0]["FECHA_EGRESO"]).format("YYYY-MM-DD");
                    this.MotivoEgreso = response.body.atributos[0]["MOTIVOEGRESO"];
                    this.Retiro_Voluntario = response.body.atributos[0]["RETIRO_VOLUNTARIO"];
                    this.Reinsercion_Familiar = response.body.atributos[0]["REINSERCION_FAMILIAR"];
                    this.Traslado_Entidad_Salud = response.body.atributos[0]["TRASLADO_ENTIDAD_SALUD"];
                    this.Traslado_Otra_Entidad = response.body.atributos[0]["TRASLADO_OTRA_ENTIDAD"];
                    this.Fallecimiento = response.body.atributos[0]["FALLECIMIENTO"];
                    this.RestitucionAseguramientoSaludo = response.body.atributos[0]["RESTITUCIONASEGURAMIENTOSALUDO"];
                    this.Restitucion_Derechos_DNI = response.body.atributos[0]["RESTITUCION_DERECHOS_DNI"];
                    this.RestitucionReinsercionFamiliar = response.body.atributos[0]["RESTITUCIONREINSERCIONFAMILIAR"];

                }
             });

        },
        
    }
  })
