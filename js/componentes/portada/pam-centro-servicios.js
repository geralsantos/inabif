var pam_centro_servicios = {
    template: '#pam-centro-servicios',
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

        this.cargar_departamentos();
        this.buscar_centro();
    },
    updated:function(){
    },
    watch:{
        CarDepart:function(val){
            this.cargar_provincias();
        }
    },
    methods:{



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
            this.$http.post('buscar_provincia?view',{tabla:'ubigeo', cod:this.CarDepart}).then(function(response){
                if( response.body.data != undefined){
                    this.provincias= response.body.data;
                    this.cargar_distritos();
                }
            });
        },
        cargar_distritos(){

            this.distritos=[];
            let cod = this.CarProv;
            this.$http.post('buscar_distritos?view',{tabla:'ubigeo', cod:this.CarProv}).then(function(response){
                if( response.body.data != undefined){
                    this.distritos= response.body.data;
                }
             });
        },
        buscar_centro(){
            this.$http.post('buscar_centro?view',{tabla:'centro_atencion' }).then(function(response){

                if( response.body.data != undefined){

                    let ubigeo =  response.body.data[0]["UBIGEO"];
                    let departamento = ubigeo.substring(0, 2);
                    let provincia = ubigeo.substring(0, 4);
                    let distrito = response.body.data[0]["UBIGEO"];
                    this.CarCodEntidad = response.body.data[0]["CODIGO_ENTIDAD"];
                    this.CarNomEntidad = response.body.data[0]["NOMBRE_ENTIDAD"];
                    this.CarCodLinea = response.body.data[0]["CODIGO_LINEA"];
                    this.CarLineaI = response.body.data[0]["LINEA_INTERVENCION"];
                    this.CarCodServicio = response.body.data[0]["COD_SERV"];
                    this.CarNomServicio = response.body.data[0]["NOM_SERV"];
                    this.CarDepart =departamento;
                    this.CarProv = provincia;
                    this.CarDistrito = distrito;

                    this.areaResidencia = response.body.data[0]["AREA_RESIDENCIA"];
                    this.codigoCentroAtencion = response.body.data[0]["COD_CA"];
                    this.nombreCentroAtencion = response.body.data[0]["NOM_CA"];

                }
             });
        },
    }
  }
