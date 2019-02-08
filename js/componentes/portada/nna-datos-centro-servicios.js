var nna_datos_centro_servicios = {
    template: '#nna-datos-centro-servicios',
    data:()=>({

        Cod_Entidad:null,
        Nom_Entidad:null,
        Cod_Linea:null,
        Nom_Linea:null,
        Linea_Intervencion:null,
        Cod_Servicio :null,
        NomC_Servicio:null,
        Departamento_Centro:null,
        Provincia_centro:null,
        Distrito_centro:null,
        Area_Residencia:null,
        CodigoC_Atencion:null,
        NomC_Atencion:null,

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

        this.buscar_departamentos();
        this.buscar_centro();

    },
    updated:function(){
    },
    watch:{
        Departamento_Centro:function(val){
            this.buscar_provincias();
        }
    },
    methods:{

        buscar_departamentos(){
            this.$http.post('buscar_departamentos?view',{tabla:'ubigeo'}).then(function(response){
                if( response.body.data ){
                    this.departamentos= response.body.data;

                }

            });
        },
        buscar_provincias(){
            this.$http.post('buscar_provincia?view',{tabla:'ubigeo', cod:this.Departamento_Centro}).then(function(response){
                if( response.body.data ){
                    this.provincias= response.body.data;
                    this.buscar_distritos();
                }

            });
        },
        buscar_distritos(){
            this.$http.post('buscar_distritos?view',{tabla:'ubigeo', cod:this.Provincia_centro}).then(function(response){
                if( response.body.data ){
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
                    this.Cod_Entidad = response.body.data[0]["CODIGO_ENTIDAD"];
                    this.Nom_Entidad = response.body.data[0]["NOMBRE_ENTIDAD"];
                    this.Cod_Linea = response.body.data[0]["CODIGO_LINEA"];
                    this.Linea_Intervencion = response.body.data[0]["LINEA_INTERVENCION"];
                    this.Cod_Servicio = response.body.data[0]["COD_SERV"];
                    this.NomC_Servicio = response.body.data[0]["NOM_SERV"];
                    this.Departamento_Centro = departamento;
                    this.Provincia_centro =provincia;
                    this.Distrito_centro =  distrito;
                    this.Area_Residencia = response.body.data[0]["AREA_RESIDENCIA"];
                    this.CodigoC_Atencion = response.body.data[0]["COD_CA"];
                    this.NomC_Atencion = response.body.data[0]["NOM_CA"];

                }
             });
        },

    }
  }
