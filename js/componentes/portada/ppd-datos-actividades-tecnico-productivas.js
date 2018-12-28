Vue.component('ppd-datos-actividades-tecnico-productivas', {
    template:'#ppd-datos-actividades-tecnico-productivas',
    data:()=>({
        CarNumBiohuerto:null,
        CarNumManualidades:null,
        CarNumReposteria:null,
        CarNumPaseos:null,
        CarNumCulturales:null,
        CarNumCivicas:null,
        CarNumFutbol:null,
        CarNumNatacion:null,
        CarNumDeportes:null,
        CArNumDinero:null,
        CarNumDecisiones:null,
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
            if (this.residente_id==null) {
                swal('Error', 'Residente no existe', 'success');
                return false;
            }
            let valores = { Num_Biohuerto: this.CarNumBiohuerto,
                Num_Manualidades: this.CarNumManualidades,
                Num_Panaderia: this.CarNumReposteria,
                Num_Paseos: this.CarNumPaseos,
                Num_Culturales: this.CarNumCulturales,
                Num_Civicas: this.CarNumCivicas,
                Num_Futbol: this.CarNumFutbol,
                Num_Natacion: this.CarNumNatacion,
                Num_otrosDe: this.CarNumDeportes,
                Num_ManejoDinero: this.CArNumDinero,
                Num_decisiones: this.CarNumDecisiones,
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

                        }
            this.$http.post('insertar_datos?view',{tabla:'CarActividades', valores:valores}).then(function(response){

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
                console.log(word);
                this.$http.post('ejecutar_consulta?view',{like:word }).then(function(response){
                    console.log(response.body);
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
        actualizar(id){
            this.id_residente = id;
            this.coincidencias = [];
            this.bloque_busqueda = false;
            console.log(id);
            this.$http.post('cargar_datos_residente?view',{tabla:'CarActividades', residente_id:this.id_residente }).then(function(response){
                console.log(response.body);
                if( response.body.atributos != undefined){

                    this.CarNumBiohuerto = response.body.atributos[0]["Num_Biohuerto"];
                    this.CarNumManualidades = response.body.atributos[0]["Num_Manualidades"];
                    this.CarNumReposteria = response.body.atributos[0]["Num_Panaderia"];
                    this.CarNumPaseos = response.body.atributos[0]["Num_Paseos"];
                    this.CarNumCulturales = response.body.atributos[0]["Num_Culturales"];
                    this.CarNumCivicas = response.body.atributos[0]["Num_Civicas"];
                    this.CarNumFutbol = response.body.atributos[0]["Num_Futbol"];
                    this.CarNumNatacion = response.body.atributos[0]["Num_Natacion"];
                    this.CarNumDeportes = response.body.atributos[0]["Num_otrosDe"];
                    this.CArNumDinero = response.body.atributos[0]["Num_ManejoDinero"];
                    this.CarNumDecisiones = response.body.atributos[0]["Num_decisiones"];
                }
             });

        },
    }
  })
