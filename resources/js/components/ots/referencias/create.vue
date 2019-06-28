<template>   
    <div class="modal fade" id="nuevo">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Referencia</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Observaciones</label>
                        <textarea v-model="observaciones" class="form-control noresize" rows="3" placeholder="" maxlength="250"></textarea>
                    </div>            
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Imagen 1</label>
                        <input type="file" class="form-control" name="file" @change="onFileSelected('1')" >
                        <button @click.prevent="onUpload('1')" >upload</button>
                    </div>            
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Imagen 2</label>
                        <input type="file" class="form-control" name="file" @change="onFileSelected('2')">
                        <button @click.prevent="onUpload('2')" >upload</button>
                    </div>            
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Imagen 3</label>
                        <input type="file" class="form-control" name="file" @change="onFileSelected('3')">
                        <button @click.prevent="onUpload('3')" >upload</button>
                    </div>            
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Imagen 4</label>
                        <input type="file" class="form-control" name="file" @change="onFileSelected('4')">
                          <button @click.prevent="onUpload('4')" >upload</button>
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
 import { eventNewRegistro } from '../../event-bus';
export default {
    props :{
       index: '' 
    },
    data() { return {  

        selectedFile1 : null,
        selectedFile2 : null,
        selectedFile3 : null,
        selectedFile4 : null,
        errors:{},
        observaciones:'', 
        path1 :'',
        path2 :'',
        path3 :'',
        path4 :'',      
     
         }
    
    },
 created: function () {
    eventNewRegistro.$on('open', this.openModal)
  
    },
    computed :{
    
         ...mapState(['url'])
    }, 
   
    methods: {
           openModal : function(){
                this.newRegistro={};
                $('#nuevo').modal('show');         
            },
            storeRegistro: function(){               
        
                this.$emit('setReferencia',this.observaciones,this.path1,this.path2,this.path3,this.path4);    

              },
            onFileSelected(event,index) {

                switch (index) {
                       case 1:
                           this.selectedFile1 = revent.target.files[0]
                           break;
                       case 2:
                           this.selectedFile2 = event.target.files[0]
                           break;
                       case 3 :
                           this.selectedFile3 = event.target.files[0]
                           break;
                       case 4:
                           this.selectedFile4 = event.target.files[0]
                           break;
                
                   }

               
            },
            onUpload(event,path) {
              let settings = { headers: { 'content-type': 'multipart/form-data' } }
               const fd = new FormData();
               fd.append('image',this.selectedFile);                
               axios.defaults.baseURL = this.url;     
               var url = 'storage/create';
               axios.post(url,fd,settings)
               .then (response => {

                   switch (path) {
                       case 1:
                           this.path1 = response.data
                           break;
                       case 2:
                           this.path2 = response.data
                           break;
                       case 3 :
                           this.path3 = response.data
                           break;
                       case 4:
                           this.path4 = response.data
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