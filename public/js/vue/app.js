
var vm = new Vue({

  el:'#amb',
  created : function(){
    this.getRegistros();
  },
  data:{
    registros: [],
    title:'hola',
    errors:[]
  },
  methods: {

    getRegistros : function(){

      var urlRegistros = 'users';
      axios.get(urlRegistros).then(response =>{
          this.registros = response.data
      });
    }
  }

});
