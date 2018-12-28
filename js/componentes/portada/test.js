
Vue.component('modulos',{
  	props:["changeviewevent"],
  	template:`
        <div v-html="htmlrender" @click="showTemplate($event)" id="geral"> </div>
         `,
  	data:()=>({
  		duration:5000,
      expandNews: false,
      rowsmodulos:[],
      styleObject: {
        width: '100%',

      },
      htmlrender: '',
      rowsmodulos_det:[],
      url:{
        getmodulos:'getModulos?view'
      }
  	}),
  	created:()=>{
     // console.log(this.rowsmodulos_det);
  	},
  	mounted:function(){
      this.modulos_sidenav();
  	},
  	watch:{

  	},
  	methods:{
      showTemplate:function(e){

        let tmp = $(e.currentTarget).find('.menu-item-has-children.dropdown:hover').find('.sub-menu.children:hover').find('li:hover');
        if (!isempty(tmp.attr('data-url'))) {
          this.changeviewevent(tmp.attr('data-url'));
        }
      },
      modulos_sidenav:function(){
        this.$http.post('list_modulos?view',{}).then(function(response){
          this.htmlrender = response.body;
          this.rowsmodulos=response.body;
          $('.menu-item-has-children').click(function(){
            console.log("click");
            if ($(this).children('ul').hasClass('show')) {
              $(this).children('ul').find("ul").removeClass('show')
            }else{
              $(this).children('ul').addClass('show')
            }
          })
          console.log(response.body);
        });
  	}
  }
  })
