Vue.component('pam-actividades-sociorecreativas', {
    template:'#pam-actividades-sociorecreativas',
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
        id:null,

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
            let nombre=(coincidencia.NOMBRE==undefined)?'':coincidencia.NOMBRE;
            let apellido_p = (coincidencia.APELLIDO_P==undefined)?'':coincidencia.APELLIDO_P;
            let apellido_m = (coincidencia.APELLIDO_M==undefined)?'':coincidencia.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.coincidencias = [];
            this.bloque_busqueda = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_ActividadSociorecrea', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Terapia_Fisica_Rehabilitacion = response.body.atributos[0]["TERAPIA_FISICA_REHABILITACION"];
                    this.Arte = response.body.atributos[0]["ARTE"];
                    this.Nro_Arte = response.body.atributos[0]["NRO_ARTE"];
                    this.Dibujo_Pintura = response.body.atributos[0]["DIBUJO_PINTURA"];
                    this.Nro_Arte_Dibujo_Pintura = response.body.atributos[0]["NRO_ARTE_DIBUJO_PINTURA"];
                    this.Manualidades = response.body.atributos[0]["MANUALIDADES"];
                    this.Nro_Arte_Manualidades = response.body.atributos[0]["NRO_ARTE_MANUALIDADES"];
                    this.Otros = response.body.atributos[0]["OTROS"];
                    this.Nro_Arte_Otros = response.body.atributos[0]["NRO_ARTE_OTROS"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];


                }
             });

        },mostrar_lista_residentes(){

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

            this.Terapia_Fisica_Rehabilitacion = null;
            this.Arte = null;
            this.Nro_Arte = null;
            this.Dibujo_Pintura = null;
            this.Nro_Arte_Dibujo_Pintura = null;
            this.Manualidades = null;
            this.Nro_Arte_Manualidades = null;
            this.Otros = null;
            this.Nro_Arte_Otros = null;
            this.id = null;


            this.id_residente = residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;

            this.$http.post('cargar_datos_residente?view',{tabla:'pam_ActividadSociorecrea', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Terapia_Fisica_Rehabilitacion = response.body.atributos[0]["TERAPIA_FISICA_REHABILITACION"];
                    this.Arte = response.body.atributos[0]["ARTE"];
                    this.Nro_Arte = response.body.atributos[0]["NRO_ARTE"];
                    this.Dibujo_Pintura = response.body.atributos[0]["DIBUJO_PINTURA"];
                    this.Nro_Arte_Dibujo_Pintura = response.body.atributos[0]["NRO_ARTE_DIBUJO_PINTURA"];
                    this.Manualidades = response.body.atributos[0]["MANUALIDADES"];
                    this.Nro_Arte_Manualidades = response.body.atributos[0]["NRO_ARTE_MANUALIDADES"];
                    this.Otros = response.body.atributos[0]["OTROS"];
                    this.Nro_Arte_Otros = response.body.atributos[0]["NRO_ARTE_OTROS"];
                    this.id = response.body.atributos[0]["RESIDENTE_ID"];


                }
             });

        }

    }
  })
