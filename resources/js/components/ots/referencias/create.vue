<template>   
    <div class="modal fade" id="nuevo">
        <div class="modal-dialog modal-lg">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h3 class="modal-title"> Referencias <small>{{tabla}}</small></h3>
                </div>
              
                <div class="modal-body">
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea v-model="inputsData.observaciones" class="form-control noresize" rows="3" placeholder="" maxlength="250"></textarea>
                    </div>    
               
                    <div class="col-md-6">     
                        <div v-if="inputsData.path1 == null">
                            <img :src="path_empty" class="margin" alt="..." width="304" height="236">
                        </div>    
                        <div v-else>
                          <img :src="inputsData.path1" class="margin" alt="..." width="304" height="236">  
                        </div>               
                     
                        <div class="form-group">                          
                            <input type="file" class="form-control" id="inputFile1" name="file" @change="onFileSelected($event,'imagen1')">
                            <button class="hide"  @click.prevent="onUpload($event,'1')" >upload</button>
                        </div>                                              
                    </div>   

                    

                    <div class="col-md-6">             
                        <div v-if="inputsData.path2 == null">
                            <img :src="path_empty" class="margin" alt="..." width="304" height="236">
                        </div>    
                        <div v-else>
                          <img :src="inputsData.path2" class="margin" alt="..." width="304" height="236">  
                        </div>
                        <div class="form-group">
                           
                            <input type="file" class="form-control" id="inputFile2" name="file" @change="onFileSelected($event,'imagen2')">
                            <button class="hide" @click.prevent="onUpload($event,'2')" >upload</button>
                        </div>                            
                    </div>    
                
                    <div class="col-md-6">
                        <div v-if="inputsData.path3 == null">
                            <img :src="path_empty" class="margin" alt="..." width="304" height="236">
                        </div>    
                        <div v-else>
                          <img :src="inputsData.path3" class="margin" alt="..." width="304" height="236">  
                        </div>
                        <div class="form-group">
                          
                            <input type="file" class="form-control" id="inputFile3" name="file" @change="onFileSelected($event,'imagen3')">
                            <button class="hide" @click.prevent="onUpload($event,'3')" >upload</button>
                        </div>  
                    </div>
                    <div class="col-md-6">  
                        <div v-if="inputsData.path4 == null">
                            <img :src="path_empty" class="margin" alt="..." width="304" height="236">
                        </div>    
                        <div v-else>
                          <img :src="inputsData.path4" class="margin" alt="..." width="304" height="236">  
                        </div>
                        <div class="form-group">
                                  
                            <input type="file" class="form-control" id="inputFile4" name="file" @change="onFileSelected($event,'imagen4')" >
                            <button class="hide" @click.prevent="onUpload($event,'4')" >upload</button>
                        </div>
                    </div>   
                 
               </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-primary" v-on:click.prevent="storeRegistro()" >Guardar</a>
                    <button type="button" class="btn btn-default" name="button" data-dismiss="modal" >Cancelar</button>
                </div>
                              
        
            </div>
        </div>         
    </div>       
</template>
                 
                     
                
            

<script>
 import {mapState} from 'vuex'
 import { eventSetReferencia } from '../../event-bus';
export default {

    props :{
      inputsData : {
       type : Object,
       required : true
     },
     index :'',
     tabla : {
       type : String,
       required : true
     },

    },

    data() { return {  

        selectedFile1 : null,
        selectedFile2 : null,
        selectedFile3 : null,
        selectedFile4 : null,
        errors:{}, 
        path_empty : 'https://via.placeholder.com/304x236.png',     
        
        referencia : {
            tabla: '',           
            observaciones:'', 
            path1 :'',
            path2 :'',
            path3 :'',
            path4 :''

        },
     
         }
    
    },
    created :function ()  {
      
      
      eventSetReferencia.$on('open', function(){

      
          console.log(this.path_empty);
          console.log(this.inputsData);
          this.setReferencia();
          $('#nuevo').modal('show');   
          

      }.bind(this));

    },
    
    computed :{
    
         ...mapState(['url','AppUrl'])
    }, 
   
    methods: {          
         
 
            setReferencia : function(){           

                this.referencia.observaciones = this.inputsData.observaciones;

                if (this.inputsData.path1 != null )                   
                    this.referencia.path1 = this.inputsData.path1;
               
                else
                    this.referencia.path1 = this.path_empty
                
                if (this.inputsData.path2 != null)
                    this.referencia.path2 = this.inputsData.path2;
                else
                    this.referencia.path2= this.path_empty
                
                if (this.inputsData.path3 != null)
                    this.referencia.path3 = this.inputsData.path3;
                else
                    this.referencia.path3= this.path_empty
                
                if (this.inputsData.path4 != null)
                    this.referencia.path4 = this.inputsData.path4;
                else
                    this.referencia.path4= this.path_empty
                
           },
            storeRegistro: function(){               
                
                this.inputsData.tabla = this.tabla
                let Ref = this.inputsData;
                this.$emit('setReferencia',Ref);
                

                this.referencia.tabla = '';          
                this.referencia.observaciones='';
                this.referencia.path1 ='';
                this.referencia.path2 ='';
                this.referencia.path3 ='';
                this.referencia.path4 ='';
                        

              },
            onFileSelected(event,imagen) {


                switch (imagen) {
                       case 'imagen1':
                           this.selectedFile1 = event.target.files[0];
                           this.onUpload('1');
                           break;
                       case 'imagen2':
                           this.selectedFile2 = event.target.files[0];
                           this.onUpload('2');
                           break;
                       case 'imagen3' :
                           this.selectedFile3 = event.target.files[0];
                           this.onUpload('3');
                           break;
                       case 'imagen4':
                           this.selectedFile4 = event.target.files[0];
                           this.onUpload('4');
                           break;
                
                   }

               
            },
            onUpload(path) {
              let settings = { headers: { 'content-type': 'multipart/form-data' } }
               const fd = new FormData();
               
               switch (path) {
                       case '1':
                           fd.append('image',this.selectedFile1);  
                           break;
                       case '2':
                           fd.append('image',this.selectedFile2);  
                           break;
                       case '3' :
                           fd.append('image',this.selectedFile3);  
                           break;
                       case '4':
                           fd.append('image',this.selectedFile4);  
                           break;                
                   }
              
               axios.defaults.baseURL = this.url;     
               var url = 'storage/create';
               console.log(fd);
               axios.post(url,fd,settings)
               .then (response => {

                   switch (path) {
                       case '1':
                           this.inputsData.path1 = this.AppUrl + '/' + response.data
                           break;
                       case '2':
                           this.inputsData.path2 = this.AppUrl + '/' + response.data
                           break;
                       case '3' :
                           this.inputsData.path3 = this.AppUrl + '/' + response.data
                           break;
                       case '4':
                           this.inputsData.path4 = this.AppUrl + '/' + response.data
                           break;
                
                   }
                   
                   path = response.data
                   console.log(path);
               }).catch(response => {
                    console.log(response)
                })

            }
}
    
}
</script>


