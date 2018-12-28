Vue.component('ppd-datos-atencion-psicologica', {
    template: '#ppd-datos-atencion-psicologica',
    data:()=>({
        CarNumHabilidadesBasicas:null,
        CarNumHabilidadesConceptuales:null,
        CarNumHabilidadesSociales:null,
        CarNumHablidadesPracticas:null,
        CarNumModificacionConducta:null,

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
            let valores = { Num_HBasicas: this.CarNumHabilidadesBasicas,
                Num_HConceptuales: this.CarNumHabilidadesConceptuales,
                Num_HSociales: this.CarNumHabilidadesSociales,
                Num_HPracticas: this.CarNumHablidadesPracticas,
                Num_HModificacion: this.CarNumModificacionConducta
                        }
            this.$http.post('insertar_datos?view',{tabla:'CarAtencionPsicologica', valores:valores}).then(function(response){

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
            let where = {"id_residente": this.id_residente, "estado": 1}
            this.$http.post('cargar_datos_residente?view',{tabla:'CarAtencionPsicologica', where:where }).then(function(response){

                if( response.body.atributos != undefined){

                    this.CarNumHabilidadesBasicas = response.body.atributos[0]["Num_HBasicas"];
                    this.CarNumHabilidadesConceptuales = response.body.atributos[0]["Num_HConceptuales"];
                    this.CarNumHabilidadesSociales = response.body.atributos[0]["Num_HSociales"];
                    this.CarNumHablidadesPracticas = response.body.atributos[0]["Num_HPracticas"];
                    this.CarNumModificacionConducta = response.body.atributos[0]["Num_HModificacion"];
                
                }
             });

        },
    }
  })
