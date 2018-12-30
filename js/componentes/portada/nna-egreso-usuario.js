Vue.component('nna-egreso-usuario', {
    template: '#nna-egreso-usuario',
    data:()=>({
     
        Fecha_Egreso:null,
        MotivoEgreso:null,
        Detalle_Motivo:null,
        Salud_AUS :null,
        Partida_Naci :null,
        DNI :null,
        Educacion :null,
        Reinsecion_Familiar:null,

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
               
                Fecha_Egreso:this.Fecha_Egreso,
                MotivoEgreso:this.MotivoEgreso,
                Detalle_Motivo:this.Detalle_Motivo,
                Salud_AUS :this.Salud_AUS,
                Partida_Naci :this.Partida_Naci,
                DNI :this.DNI,
                Educacion :this.Educacion,
                Reinsecion_Familiar:this.Reinsecion_Familiar,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                
            this.$http.post('insertar_datos?view',{tabla:'NNAEgresoUsuario', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'NNAEgresoUsuario', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Fecha_Egreso = response.body.atributos[0]["FECHA_EGRESO"];
                    this.MotivoEgreso = response.body.atributos[0]["MOTIVOEGRESO"];
                    this.Detalle_Motivo = response.body.atributos[0]["DETALLE_MOTIVO"];
                    this.Salud_AUS = response.body.atributos[0]["SALUD_AUS"];
                    this.Partida_Naci = response.body.atributos[0]["PARTIDA_NACI"];
                    this.DNI = response.body.atributos[0]["DNI"];
                    this.Educacion = response.body.atributos[0]["EDUCACION"];
                    this.Reinsecion_Familiar = response.body.atributos[0]["REINSECION_FAMILIAR"];
                 
                }
             });

        },
        
    }
  })
