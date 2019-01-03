Vue.component('pam-actividades-sociales', {
    template:'#pam-actividades-sociales',
    data:()=>({
        Atencion_Social:null,
        Visita_Familiares:null,
        Nro_Visitas:null,
        Visitas_Amigos:null,
        Nro_Visitas_Amigos:null,
        Descriptivo_Persona_Visita:null,
        Aseguramiento_Universal_Salud:null,
        Fecha_Emision_Obtencion_Seguro:null,
        DNI:null,
        Fecha_Emision_DNI:null,
       
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
               
                Atencion_Social:this.Atencion_Social,
                Visita_Familiares:this.Visita_Familiares,
                Nro_Visitas:this.Nro_Visitas,
                Nro_Visitas_Amigos:this.Nro_Visitas_Amigos,
                Descriptivo_Persona_Visita:this.Descriptivo_Persona_Visita,
                Aseguramiento_Universal_Salud:this.Aseguramiento_Universal_Salud,
                Fecha_Emision_Obtencion_Seguro: moment(this.Fecha_Emision_Obtencion_Seguro).format("YY-MMM-DD"),
                DNI:this.DNI,
                Fecha_Emision_DNI:moment(this.Fecha_Emision_DNI).format("YY-MMM-DD"),
           
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

                        }
                        console.log(valores)
            this.$http.post('insertar_datos?view',{tabla:'pam_ActividadesSociales', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_ActividadesSociales', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Atencion_Social = response.body.atributos[0]["ATENCION_SOCIAL"];
                    this.Visita_Familiares = response.body.atributos[0]["VISITA_FAMILIARES"];
                    this.Nro_Visitas = response.body.atributos[0]["NRO_VISITAS"];
                    this.Nro_Visitas_Amigos = response.body.atributos[0]["NRO_VISITAS_AMIGOS"];
                    this.Descriptivo_Persona_Visita = response.body.atributos[0]["DESCRIPTIVO_PERSONA_VISITA"];
                    this.Aseguramiento_Universal_Salud = response.body.atributos[0]["ASEGURAMIENTO_UNIVERSAL_SALUD"];
                    this.Fecha_Emision_Obtencion_Seguro = moment(response.body.atributos[0]["FECHA_EMISION_OBTENCION_SEGURO"]).format("YYYY-MM-DD");
                    this.DNI = response.body.atributos[0]["DNI"];
                    this.Fecha_Emision_DNI = moment(response.body.atributos[0]["FECHA_EMISION_DNI"]).format("YYYY-MM-DD");
            
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

            this.Atencion_Social = null;
            this.Visita_Familiares = null;
            this.Nro_Visitas = null;
            this.Nro_Visitas_Amigos = null;
            this.Descriptivo_Persona_Visita = null;
            this.Aseguramiento_Universal_Salud = null;
            this.Fecha_Emision_Obtencion_Seguro = null;
            this.DNI = null;
            this.Fecha_Emision_DNI = null;


            this.id_residente = residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido = (residente.APELLIDO==undefined)?'':residente.APELLIDO;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_ActividadesSociales', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Atencion_Social = response.body.atributos[0]["ATENCION_SOCIAL"];
                    this.Visita_Familiares = response.body.atributos[0]["VISITA_FAMILIARES"];
                    this.Nro_Visitas = response.body.atributos[0]["NRO_VISITAS"];
                    this.Nro_Visitas_Amigos = response.body.atributos[0]["NRO_VISITAS_AMIGOS"];
                    this.Descriptivo_Persona_Visita = response.body.atributos[0]["DESCRIPTIVO_PERSONA_VISITA"];
                    this.Aseguramiento_Universal_Salud = response.body.atributos[0]["ASEGURAMIENTO_UNIVERSAL_SALUD"];
                    this.Fecha_Emision_Obtencion_Seguro = moment(response.body.atributos[0]["FECHA_EMISION_OBTENCION_SEGURO"]).format("YYYY-MM-DD");
                    this.DNI = response.body.atributos[0]["DNI"];
                    this.Fecha_Emision_DNI = moment(response.body.atributos[0]["FECHA_EMISION_DNI"]).format("YYYY-MM-DD");
            
                }
             });

        }
    }
  })
