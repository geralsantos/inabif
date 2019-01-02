Vue.component('nna-datos-centro-servicios', {
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
        id_residente:null
    }),
    created:function(){
    },
    mounted:function(){
        this.buscar_departamentos();
    },
    updated:function(){
    },
    watch:{
        Departamento_Centro:function(val){ 
            this.buscar_provincias();
        }
    },
    methods:{
        guardar(){
            if (this.id_residente==null) {
                swal('Error', 'Residente no existe', 'warning');
                return false;
            }
            let valores = {
           
                Cod_Entidad:this.Cod_Entidad,
                Nom_Entidad:this.Nom_Entidad,
                Cod_Linea:this.Cod_Linea,
                Nom_Linea:this.Nom_Linea,
                Linea_Intervencion:this.Cod_Entidad,
                Cod_Servicio:this.Cod_Servicio,
                NomC_Servicio:this.NomC_Servicio,
                Ubigeo:this.Departamento_Centro + this.Provincia_centro + this.Departamento_Centro,
                Departamento_Centro :this.Departamento_Centro,
                Provincia_centro:this.Provincia_centro,
                Distrito_centro :this.Distrito_centro,
                Area_Residencia :this.Area_Residencia,
                CodigoC_Atencion :this.CodigoC_Atencion,
                NomC_Atencion :this.NomC_Atencion,
                Fecha_Registro :moment().format("YY-MMM-DD"),
       
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                
            this.$http.post('insertar_datos?view',{tabla:'NNACentroServicios', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'NNACentroServicios', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Cod_Entidad = response.body.atributos[0]["COD_ENTIDAD"];
                    this.Nom_Entidad = response.body.atributos[0]["NOM_ENTIDAD"];
                    this.Cod_Linea = response.body.atributos[0]["COD_LINEA"];
                    this.Nom_Linea = response.body.atributos[0]["NOM_LINEA"];
                    this.Linea_Intervencion = response.body.atributos[0]["LINEA_INTERVENCION"];
                    this.Cod_Servicio = response.body.atributos[0]["COD_SERVICIO"];
                    this.NomC_Servicio = response.body.atributos[0]["NOMC_SERVICIO"];
                    this.Departamento_Centro = response.body.atributos[0]["DEPARTAMENTO_CENTRO"];
                    this.Provincia_centro = response.body.atributos[0]["PROVINCIA_CENTRO"];
                    this.Distrito_centro = response.body.atributos[0]["DISTRITO_CENTRO"];
                    this.Area_Residencia = response.body.atributos[0]["AREA_RESIDENCIA"];
                    this.CodigoC_Atencion = response.body.atributos[0]["CODIGOC_ATENCION"];
                    this.NomC_Atencion = response.body.atributos[0]["NOMC_ATENCION"];

                }
             });

        },
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
        
    }
  })
