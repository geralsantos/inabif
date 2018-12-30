Vue.component('ppd-datos-centro-servicios', {
    template: '#ppd-datos-centro-servicios',
    data:()=>({
        CarCodEntidad:null,
        CarNomEntidad:null,
        CarCodLinea:null,
        CarLineaI:null,
        CarCodServicio:null,
        CarNomServicio:null,
        CarDepart:null,
        CarProv:null,
        areaResidencia:null,
        centroPoblado:null,
        CarDistrito:null,
        codigoCentroAtencion:null,
        nombreCentroAtencion:null,

        departamentos:[],
        provincias:[],
        distritos:[],

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
        this.cargar_departamentos();
    },
    updated:function(){
    },
    watch:{
        Depatamento_Procedencia:function(val){ 
            this.buscar_provincias();
        }
    },
    methods:{
        guardar(){
            if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'success');
                return false;
            }
            let valores = {
                Cod_Entidad:this.CarCodEntidad,
                Nom_Entidad:this.CarNomEntidad,
                Cod_Linea:this.CarCodLinea,
                Linea_Intervencion:this.CarLineaI,
                Cod_Servicio:this.CarCodServicio,
                Nom_Servicio:this.CarNomServicio,
                Ubigeo_Ine: this.CarDepart+this.CarProv+this.CarDistrito,
                Departamento_CAtencion:this.CarDepart,
                Provincia_CAtencion:this.CarProv,
                Distrito_CAtencion:this.CarDistrito,
                Centro_Poblado:this.centroPoblado,
                Centro_Residencia:this.areaResidencia,
                Cod_CentroAtencion:this.codigoCentroAtencion,
                Nom_CentroAtencion:this.nombreCentroAtencion,
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")
                        }
            this.$http.post('insertar_datos?view',{tabla:'CarCentroServicio', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarCentroServicio', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarCodEntidad = response.body.atributos[0]["COD_ENTIDAD"];
                    this.CarNomEntidad = response.body.atributos[0]["NOM_ENTIDAD"];
                    this.CarCodLinea = response.body.atributos[0]["COD_LINEA"];
                    this.CarLineaI = response.body.atributos[0]["LINEA_INTERVENCION"];
                    this.CarCodServicio = response.body.atributos[0]["COD_SERVICIO"];
                    this.CarNomServicio = response.body.atributos[0]["NOM_SERVICIO"];
                    this.CarDepart = response.body.atributos[0]["DEPARTAMENTO_CATENCION"];
                    this.CarProv = response.body.atributos[0]["PROVINCIA_CATENCION"];
                    this.CarDistrito = response.body.atributos[0]["DISTRITO_CATENCION"];
                    this.centroPoblado = response.body.atributos[0]["CENTRO_POBLADO"];
                    this.areaResidencia = response.body.atributos[0]["CENTRO_RESIDENCIA"];
                    this.codigoCentroAtencion = response.body.atributos[0]["COD_CENTROATENCION"];
                    this.nombreCentroAtencion = response.body.atributos[0]["NOM_CENTROATENCION"];

                }
             });

        },
        cargar_departamentos(){
            this.departamentos=[];
            this.$http.post('buscar_departamentos?view',{tabla:'ubigeo'}).then(function(response){
                if( response.body.data != undefined){
                    this.departamentos= response.body.data;
                    this.cargar_provincias();
                }
             });
        },
        cargar_provincias(){

            this.provincias=[];
            let cod = this.CarDepart;
            this.$http.post('buscar_provincia?view',{tabla:'ubigeo', cod:this.Depatamento_Procedencia}).then(function(response){
                if( response.body.data != undefined){
                    this.provincias= response.body.data;
                    this.cargar_distritos();
                }
            });
        },
        cargar_distritos(){

            this.distritos=[];
            let cod = this.CarProv;
            this.$http.post('buscar_distritos?view',{tabla:'ubigeo', cod:this.Provincia_Procedencia}).then(function(response){
                if( response.body.data != undefined){
                    this.distritos= response.body.data;
                }
             });
        },
    }
  })
