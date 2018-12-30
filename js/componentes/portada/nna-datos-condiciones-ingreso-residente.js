Vue.component('nna-datos-condiciones-ingreso-residente', {
    template: '#nna-datos-condiciones-ingreso-residente',
    data:()=>({
        
        Tipo_Doc:null,
        Numero_Doc:null,
        Lee_Escribe:null,
        Nivel_Educativo:null,
        Tipo_Seguro:null,
        SISFOH:null,
        
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
               
                Tipo_Doc:this.Tipo_Doc,
                Numero_Doc:this.Numero_Doc,
                Lee_Escribe :this.Lee_Escribe,
                Nivel_Educativo:this.Nivel_Educativo,
                Tipo_Seguro:this.Tipo_Seguro,
                SISFOH:this.SISFOH,

                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                
            this.$http.post('insertar_datos?view',{tabla:'NNACondicionIResidente', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'NNACondicionIResidente', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Tipo_Doc = response.body.atributos[0]["TIPO_DOC"];
                    this.Numero_Doc = response.body.atributos[0]["NUMERO_DOC"];
                    this.Lee_Escribe = response.body.atributos[0]["LEE_ESCRIBE"];
                    this.Nivel_Educativo = response.body.atributos[0]["NIVEL_EDUCATIVO"];
                    this.Tipo_Seguro = response.body.atributos[0]["TIPO_SEGURO"];
                    this.SISFOH = response.body.atributos[0]["SISFOH"];
                   

                }
             });

        },
        
    }
  })
