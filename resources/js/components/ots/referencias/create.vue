<template>   
<div class="row">
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
                        <textarea v-model="referencia.observaciones" class="form-control noresize" rows="3" placeholder="" maxlength="500"></textarea>
                    </div>    
               
                    <div class="col-md-6">     
                        <div v-if="referencia.path1 == null">
                            <img :src="path_empty1" class="margin" alt="..." width="304" height="236">
                        </div>    
                        <div v-else>
                           <img :src="referencia.path1" class="margin" alt="..." width="304" height="236">  
                        </div>               
                     
                        <div class="form-group">                          
                            <input type="file" class="form-control" ref="inputFile1" id="inputFile1" name="file" @change="onFileSelected($event,'imagen1')">
                            <button class="hide"  @click.prevent="onUpload($event,'1')" >upload</button>
                        </div>                                              
                    </div>
                    

                    <div class="col-md-6">             
                        <div v-if="referencia.path2 == null">
                            <img :src="path_empty2" class="margin" alt="..." width="304" height="236">
                        </div>    
                        <div v-else>
                          <img :src="referencia.path2" class="margin" alt="..." width="304" height="236">  
                        </div>
                        <div class="form-group">
                           
                            <input type="file" class="form-control" ref="inputFile2" id="inputFile2" name="file" @change="onFileSelected($event,'imagen2')">
                            <button class="hide" @click.prevent="onUpload($event,'2')" >upload</button>
                        </div>                            
                    </div>    
                
                    <div class="col-md-6">
                        <div v-if="referencia.path3 == null">
                            <img :src="path_empty3" class="margin" alt="..." width="304" height="236">
                        </div>    
                        <div v-else>
                          <img :src="referencia.path3" class="margin" alt="..." width="304" height="236">  
                        </div>
                        <div class="form-group">
                          
                            <input type="file" class="form-control" ref="inputFile3" id="inputFile3" name="file" @change="onFileSelected($event,'imagen3')">
                            <button class="hide" @click.prevent="onUpload($event,'3')" >upload</button>
                        </div>  
                    </div>
                    <div class="col-md-6">  
                        <div v-if="referencia.path4 == null">
                            <img :src="path_empty4" class="margin" alt="..." width="304" height="236">
                        </div>    
                        <div v-else>
                          <img :src="referencia.path4" class="margin" alt="..." width="304" height="236">  
                        </div>
                        <div class="form-group">
                                  
                            <input type="file" class="form-control" ref="inputFile4" id="inputFile4" name="file" @change="onFileSelected($event,'imagen4')" >
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
        path_empty1 : '/img/imagen1.jpg',
        path_empty2 : '/img/imagen2.jpg', 
        path_empty3 : '/img/imagen3.jpg', 
        path_empty4 : '/img/imagen4.jpg',     
        
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
      
         
          this.setReferencia();
          $('#nuevo').modal('show');   
          
      }.bind(this));
    },

     
    computed :{
    
         ...mapState(['url','AppUrl']),

         

         
    }, 
   
    methods: {     
        
        	clearSelectedFile (inputref) {

                    const input = inputref
                    input.type = 'text';
                    input.type = 'file';      

                },
         
 
            setReferencia : function(){    
                 
                this.$nextTick(function () {                    
                    
                this.referencia.observaciones = this.inputsData.observaciones;                  

                if (this.inputsData.path1 != null )
                    this.referencia.path1 = this.inputsData.path1;               
                else{
                    this.referencia.path1 = this.path_empty1;
                    this.clearSelectedFile(this.$refs.inputFile1);
                   }
                
                if (this.inputsData.path2 != null)
                    this.referencia.path2 = this.inputsData.path2;
                else{
                    this.referencia.path2= this.path_empty2;
                      this.clearSelectedFile(this.$refs.inputFile2);
                }
                if (this.inputsData.path3 != null)
                    this.referencia.path3 = this.inputsData.path3;
                else{
                    this.referencia.path3= this.path_empty3;
                     this.clearSelectedFile(this.$refs.inputFile3);

                }
                if (this.inputsData.path4 != null)
                    this.referencia.path4 = this.inputsData.path4;
                else{
                    this.referencia.path4= this.path_empty4;
                     this.clearSelectedFile(this.$refs.inputFile4);
                }
                    })
           },
            storeRegistro: function(){               
                
                this.referencia.tabla = this.tabla
                let Ref = this.referencia;
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
               var url = 'storage/referencia';
               console.log(fd);
               axios.post(url,fd,settings)
               .then (response => {
                   switch (path) {
                       case '1':
                           this.referencia.path1 = '/' + response.data
                           break;
                       case '2':
                           this.referencia.path2 =  '/' + response.data
                           break;
                       case '3' :
                           this.referencia.path3 = '/' + response.data
                           break;
                       case '4':
                           this.referencia.path4 = '/' + response.data
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
