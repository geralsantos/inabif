Vue.component('ppd-datos-salud-mental', {
    template:'#ppd-datos-salud-mental',
    data:()=>({
        CarTrastornosNeurologico:null,
        CarNeurologicoPrincipal:null,
        CarTrastornoConduta:null,
        CarDificultadHabla:null,
        CarMetodoHabla:null,
        CarComprension:null,
        CarDificultadPresenta:null,
        CarRealizaActividades:null,
        CarEspeficicarActividades:null,

        transtornos:[],
        tipos:[],
        actividades:[],

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
        this.buscar_tipos();
        this.buscar_actividades();
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
                Transtorno_Neurologico: this.CarTrastornosNeurologico,
                Des_Transtorno: this.CarNeurologicoPrincipal,
                Tipo_Transtorno: this.CarTrastornoConduta,
                Dificultad_Habla: this.CarDificultadHabla,
                Metodo_Comunicarse: this.CarMetodoHabla,
                Comprension: this.CarComprension,
                Tipo_Dificultad: this.CarDificultadPresenta,
                Actividades_Diarias: this.CarRealizaActividades,
                Especificar: this.CarEspeficicarActividades,

                Residente_Id: this.id_residente,
                Periodo_Mes: parseFloat(moment().format("MM")),
                Periodo_Anio:parseFloat(moment().format("YYYY"))

            }
console.log(valores);
            this.$http.post('insertar_datos?view',{tabla:'CarSaludMental', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'CarSaludMental', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarTrastornosNeurologico = response.body.atributos[0]["TRANSTORNO_NEUROLOGICO"];
                    this.CarNeurologicoPrincipal = response.body.atributos[0]["DES_TRANSTORNO"];
                    this.CarTrastornoConduta = response.body.atributos[0]["TIPO_TRANSTORNO"];
                    this.CarDificultadHabla = response.body.atributos[0]["DIFICULTAD_HABLA"];
                    this.CarMetodoHabla = response.body.atributos[0]["METODO_COMUNICARSE"];
                    this.CarComprension = response.body.atributos[0]["COMPRENSION"];
                    this.CarDificultadPresenta = response.body.atributos[0]["TIPO_DIFICULTAD"];
                    this.CarRealizaActividades = response.body.atributos[0]["ACTIVIDADES_DIARIAS"];
                    this.CarEspeficicarActividades = response.body.atributos[0]["ESPECIFICAR"];

                }
             });

        },
        buscar_tipos(){
            this.$http.post('buscar?view',{tabla:'pam_tipo_transtorno_conducta'}).then(function(response){
                if( response.body.data ){
                    this.tipos= response.body.data;
                }

            });
        },
        buscar_actividades(){
            this.$http.post('buscar?view',{tabla:'pam_actividades_diaria'}).then(function(response){
                if( response.body.data ){
                    this.actividades= response.body.data;
                }

            });
        },


    }
  })
