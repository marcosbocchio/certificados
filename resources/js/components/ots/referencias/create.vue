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
                        <input type="file" class="form-control" name="file" @change="onFileSelected" >
                        <button @click.prevent="onUpload" >upload</button>
                    </div>            
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Imagen 2</label>
                        <input type="file" class="form-control" name="file" >
                    </div>            
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Imagen 3</label>
                        <input type="file" class="form-control" name="file" >
                    </div>            
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Imagen 4</label>
                        <input type="file" class="form-control" name="file" >
                          <button @click="onUpload" >upload</button>
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

        selectedFile : null,
        errors:{},
        observaciones:'',       
     
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
        
                 this.$emit('setReferencia',this.observaciones);    
              

              },
            onFileSelected(event) {

                this.selectedFile = event.target.files[0]
            },
            onUpload(event) {

               const fd = new FormData();
               fd.append('image',this.selectedFile);                
               axios.defaults.baseURL = this.url;     
               var url = 'storage/create';
               axios.put(url,fd)
               .then (response => {
                   console.log(response);
               })

            }
}
    
}
</script>