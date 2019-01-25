Vue.component('reniec-consulta', {
    template:'#reniec-consulta',
    data:()=>({
        Apellido_p:null,
        Apellido_m:null,
        Nombres:null,
        NumDoc:null,

        nombre_residente:null,
        isLoading:false,
        mes:moment().format("M"),
        anio:(new Date()).getFullYear(),
        coincidencias:[],
        bloque_busqueda:false,
        id_residente:null,
        modal_lista:false,
        pacientes:[],
        showModal: false,
        residente_seleccionado :[],
        data_reniec:{},
        cboopcionreniec:null,
    }),
    created:function(){
    },
    mounted:function(){
     
    },
    methods:{
        inicializar(){
            this.id_residente=null;
            this.residente_seleccionado =[];            this.data_reniec={};
            this.cboopcionreniec=null;
        },
        buscar_residente(){
            this.id_residente = null;

            var word = this.nombre_residente;
            if( word.length >= 2){
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
            this.id_residente = coincidencia.ID;               this.id=coincidencia.ID;
            let nombre=(coincidencia.NOMBRE==undefined)?'':coincidencia.NOMBRE;
            let apellido_p = (coincidencia.APELLIDO_P==undefined)?'':coincidencia.APELLIDO_P;
            let apellido_m = (coincidencia.APELLIDO_M==undefined)?'':coincidencia.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.coincidencias = [];
            this.bloque_busqueda = false;
            this.residente_seleccionado=[];
            this.NumDoc = coincidencia.DNI_RESIDENTE;

            this.residente_seleccionado.push(coincidencia);
            console.log(coincidencia);
           

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

            this.Apellido_p = null;
            this.Apellido_m = null;
            this.Nombres = null;
            this.NumDoc = null;

            this.id_residente = residente.ID;  this.id=residente.ID;
            let nombre=(residente.NOMBRE==undefined)?'':residente.NOMBRE;
            let apellido_p = (residente.APELLIDO_P==undefined)?'':residente.APELLIDO_P;
            let apellido_m = (residente.APELLIDO_M==undefined)?'':residente.APELLIDO_M;
            let apellido = apellido_p + ' ' + apellido_m;
            this.nombre_residente=nombre + ' ' + apellido;
            this.modal_lista = false;
            this.NumDoc = residente.DNI_RESIDENTE;
            this.residente_seleccionado=[];
            this.residente_seleccionado.push(residente);

        },
        consulta_reniec(){
            if (!isempty(this.id_residente)) {
                let where = {dni:this.NumDoc}
                this.$http.post('consulta_reniec?view',where).then(function(response){
                    if( response.body.data != undefined){
                        var x2js = new X2JS();
                        let data_reniec = JSON.parse(JSON.stringify(x2js.xml_str2json(response.body.data)));
                        let coResultado = data_reniec.Envelope.Body.consultarResponse.return.coResultado; 
                        let deResultado = data_reniec.Envelope.Body.consultarResponse.return.deResultado;

                        if (coResultado=='0000') 
                        {
                            this.data_reniec.NumDoc = this.NumDoc;
                            this.data_reniec.Apellido_p = data_reniec.Envelope.Body.consultarResponse.return.datosPersona.apPrimer;
                            this.Apellido_p = data_reniec.Envelope.Body.consultarResponse.return.datosPersona.apPrimer;
                            this.data_reniec.Apellido_m = data_reniec.Envelope.Body.consultarResponse.return.datosPersona.apSegundo;
                            this.data_reniec.Nombres = data_reniec.Envelope.Body.consultarResponse.return.datosPersona.prenombres;
                        }else{
                            swal("ERROR",(coResultado+" : "+deResultado), "warning")
                        }
                    }else{
                        swal("", "No existe él residente", "error")
                    }
                });
            }else{
                swal("", "No hay residente seleccionado", "warning")
            }
        },
        actualiza_reniec(){
            if (!isempty(this.id_residente)) {
                let where = {dni:this.NumDoc,cboopcionreniec:cboopcionreniec,Apellido_p:this.data_reniec.Apellido_p,Apellido_m:this.data_reniec.Apellido_m,Nombres:this.data_reniec.Nombres,id_residente:this.id_residente};
                this.$http.post('actualiza_reniec?view',where).then(function(response){
                    if( response.body.resultado != undefined){
                        swal("Actualizado", "El residente ha sido actualizado con éxito", "success");
                    }else{
                        swal("Error", "Ha ocurrido un error al actualizar al residente", "error")
                    }
                });
            }else{
                swal("", "No hay residente seleccionado", "warning")
            }
        }

    }
  })
