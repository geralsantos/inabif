Vue.component('nna-datos-familiares-sociales-residente', {
    template: '#nna-datos-familiares-sociales-residente',
    data:()=>({
        
        Familiares:null,
        Parentesco:null,
        Tipo_Familia:null,
        Problematica_Fami:null,

        problematicas:[],
        
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
        this.cargar_problematicas();
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
               
                Familiares:this.Familiares,
                Parentesco:this.Parentesco,
                Tipo_Familia:this.Tipo_Familia,
                Problematica_Fami:this.Problematica_Fami, 
             
                Residente_Id: this.id_residente,
                Periodo_Mes: moment().format("MM"),
                Periodo_Anio:moment().format("YYYY")

            }
                
            this.$http.post('insertar_datos?view',{tabla:'NNAFamiliaresResidente', valores:valores}).then(function(response){

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

            this.$http.post('cargar_datos_residente?view',{tabla:'NNAFamiliaresResidente', residente_id:this.id_residente }).then(function(response){

                if( response.body.atributos != undefined){

                    this.Familiares = response.body.atributos[0]["FAMILIARES"];
                    this.Parentesco = response.body.atributos[0]["PARENTESCO"];
                    this.Tipo_Familia = response.body.atributos[0]["TIPO_FAMILIA"];
                    this.Problematica_Fami = response.body.atributos[0]["PROBLEMATICA_FAMI"];

                }
             });

        },

        cargar_problematicas(){
            let codigo = 'nna';
            this.$http.post('buscar?view',{tabla:'Carproblematica_familiar', codigo:codigo}).then(function(response){
                if( response.body.data ){
                    this.problematicas= response.body.data;
                    
                }

            });
        }
        
    }
  })
