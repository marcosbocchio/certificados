
<template>
    <div class="row">
        <div class="col-md-3">
            <div class="box box-custom-enod">
                <div class="box-body box-profile">
                    <ul class="list-group list-group-unbordered">
                        <li class="list-group-item pointer">
                            <div v-show="!selTipo_equipamiento">
                                <span class="titulo-li">Tipo Equipamiento</span>
                                <a @click="selTipo_equipamiento = !selTipo_equipamiento" class="pull-right">
                                    <div v-if="tipo_equipamiento">{{tipo_equipamiento.codigo}}</div>
                                    <div v-else><span class="seleccionar">Seleccionar</span></div>
                                </a>
                            </div>
                            <v-select v-show="selTipo_equipamiento" v-model="tipo_equipamiento" label="codigo" :options="tipos_equipamiento" @input="CambioTipoEquipamiento()" ></v-select>
                        </li>

                        <li class="list-group-item pointer">
                            <input type="text" v-model="search" class="form-control" v-on:keyup.13="Buscar()" placeholder="Buscar...">                              
                        </li>
                                       
                    </ul>
                    <a  @click="Buscar()">
                        <button class="btn btn-enod btn-block"><span class="fa fa-search"></span>
                            Buscar
                        </button>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div id="qrcode" style="display: none"></div>
            <tabs :options="{ useUrlFragment: false }">
                <tab name="Interno Equipos">  
                    <div  v-if="(paginatedItems && paginatedItems.length)">
                        <div class="row">
                            <div class="col-lg-4">
                                <button type="button" class="btn btn-success" @click="exportarQr"><i class="fa fa-qrcode"></i>  Exportar QR</button>
                            </div>
                        </div>                           
                    </div>
                    <div class="row" style="margin-top: 25px;">
                        <div class="col-lg-12">
                            <div v-if="(paginatedItems && paginatedItems.length)">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Interno Equipos</h3>
                                    </div>     

                                    <div class="box-body">
                                        <div class="table-responsive">
                                        <table class="table table-striped table-condensed">
                                            <tbody>
                                                <tr>
                                                    <th class="col-md-1">Método</th>
                                                    <th class="col-md-1">N° Int</th>
                                                    <th class="col-md-1">N° serie</th>
                                                    <th class="col-md-2">Equipo</th>
                                                    <th class="col-md-3">Tipo equipamiento</th>
                                                    <th class="col-md-1">
                                                        <input type="checkbox" v-model="checkTodo" @click="selTodo">
                                                    </th>
                                                </tr>
                                                <tr v-for="(item,k) in paginatedItems" :key="item.id">
                                                    <td>{{ item.equipo.metodo_ensayos.metodo }}</td>
                                                    <td>{{ item.nro_interno }} </td>                                 
                                                    <td>{{ item.nro_serie }} </td>
                                                    <td>{{ item.equipo.codigo}} </td>
                                                    <td v-if="item.equipo.tipo_equipamiento">{{ item.equipo.tipo_equipamiento.codigo }} </td>
                                                    <td v-else> </td>
                                                    <td>
                                                        <input type="checkbox" id="checkbox" v-model="item.check" @click="setCheck(item)">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <table id="tableQr" class="table" v-if="false">
                                            <tbody>
                                                <tr v-for="index in Math.ceil(TablaInternoEquipos.length/cantColumPdf)" :key="index">
                                                    <td v-if="((index * cantColumPdf) - 3) < TablaInternoEquipos.length"> <img :src="TablaInternoEquipos[(index * cantColumPdf) - 3].qr" alt=""></td>
                                                    <td v-else>-</td>
                                                    <td v-if="((index * cantColumPdf) - 2) < TablaInternoEquipos.length"> <img :src="TablaInternoEquipos[(index * cantColumPdf) - 2].qr" alt=""></td>
                                                    <td v-else>-</td>
                                                    <td v-if="((index * cantColumPdf) - 1) < TablaInternoEquipos.length"> <img :src="TablaInternoEquipos[(index * cantColumPdf) - 1].qr" alt=""></td>
                                                    <td v-else>-</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>                          
                              </div>
                            <paginate
                                v-model="page"
                                :page-count="pageCount"
                                :click-handler="paginate"
                                :prev-text="'Prev'"
                                :next-text="'Next'"
                                :container-class="'pagination'">         
                            </paginate>
                            </div>
                            <div v-else>
                                <h4>No hay datos para mostrar</h4>
                            </div>
                        </div>
                    </div>
                </tab>
              </tabs>
        </div>
         <loading
            :active.sync="isLoading"
            :loader="'bars'"
            :color="'red'">
         </loading>
    </div>
</template>

<script>
import {mapState} from 'vuex';
import Tabs from 'vue-tabs-component';
import Loading from 'vue-loading-overlay';
import paginate from 'vuejs-paginate'
import qrcodeVue from 'qrcode.vue'

export default {

    components: {
      Loading,
      paginate,
      qrcodeVue
    },

    data() { return {
      tipo_equipamiento: '',
      selTipo_equipamiento: false,   
      search:'',  
      TablaInternoEquipos: [],
      TablaInternoEquiposCheck: [],
      paginatedItems: [],
      pageCount: 0,   
      page: 0,   
      checkTodo: false,
      cantColumPdf : 3,
     }
    },

    mounted() {
      this.$store.dispatch('loadTiposEquipamiento');     
    },

    computed :{
        ...mapState(['isLoading','tipos_equipamiento','url']),
    },

    methods :{
      async CambioTipoEquipamiento() {
        this.selTipo_equipamiento = !this.selTipo_equipamiento;
      },
      async Buscar () { 
        this.$store.commit('loading', true);
        this.checkTodo = false;
        this.TablaInternoEquipos = [];
        try {
          let url = 'qr-interno-equipos/tipo_equipamiento/' + (this.tipo_equipamiento ? this.tipo_equipamiento.id : 'null') + '/search/' + (this.search ? this.search : 'null') + '?api_token=' + Laravel.user.api_token;
          let res = await axios.get(url);
          this.TablaInternoEquipos = res.data;
          this.paginatedItems = this.TablaInternoEquipos;
          this.totalRows = this.TablaInternoEquipos.length
          console.log('Total: ',this.totalRows);
          console.log('Calculo:',(this.totalRows % 10))
          this.pageCount = (this.totalRows % 10) == 0  ? (this.totalRows / 10) : (Math.floor(this.totalRows / 10) + 1);
          console.log(this.pageCount);
          this.page = 1;  
          this.paginate(1);
          var qrcode = new QRCode('qrcode',{ 
            width: 300,
            height: 300,
            colorDark : "#000000",
            colorLight : "#ffffff",
            });         
          for (const item of this.TablaInternoEquipos) {
              Object.defineProperty(item, 'check', { value: false, enumerable: true, writable:true, configurable: true})
                let id = item.id.toString();
                qrcode.makeCode(`${window.location.origin}/area/enod/int/${id}/doc`);
                console.log(`${window.location.origin}/area/enod/int/${id}/doc`);
                jQuery('#qrcode canvas').css('padding', '20px');
                const delay = ms => new Promise(res => setTimeout(res, ms));
                await delay(5);                        
                Object.defineProperty(item, 'qr', { value: qrcode._oDrawing._elCanvas.toDataURL("image/png"), enumerable: true, writable:true, configurable: true}) 
          };     
        }catch(error){

        }finally {this.$store.commit('loading', false);}

     },    

    paginate(page_number) {
    console.log('--------------')    
    let page_size = 10;    
/*     console.log(page_number);
    console.log((page_number -1) * page_size)
    console.log((page_number ) * page_size) */

    let itemsToParse = this.TablaInternoEquipos;
    this.paginatedItems = itemsToParse.slice(
        (page_number -1) * page_size,
        (page_number) * page_size
    );
    },

    setCheck (item) {
        console.log(this.TablaInternoEquipos.findIndex(e => e.id == item.id))
        console.log(item.check);
        let index = this.TablaInternoEquipos.findIndex(e => e.id == item.id);
        this.TablaInternoEquipos[index].check = item.check;          
    },  
    selTodo() {
        this.TablaInternoEquipos.forEach(function(item) {
            item.check = !this.checkTodo;
        }.bind(this))
        this.paginatedItems.forEach(function(item) {
            item.check = !this.checkTodo;
        }.bind(this))        
    },      
/*     exportarQr2 () {
        const doc = new jsPDF("p", "mm", "a4"); 
        doc.setFont("serif");
        console.log('entro en el exports')
        doc.autoTable({
            html: "#tableQr",
            bodyStyles:{minCellHeight:50},
            columnStyles: {
                    0: { halign: 'center', fillColor: [255, 255, 255], lineColor: [0, 0, 0], lineWidth: 0.5, cellWidth: 'auto' },
                    1: { halign: 'center', fillColor: [255, 255, 255], lineColor: [0, 0, 0], lineWidth: 0.5, cellWidth: 'auto' },
                    2: { halign: 'center', fillColor: [255, 255, 255], lineColor: [0, 0, 0], lineWidth: 0.5, cellWidth: 'auto' }                    
                },            
            didDrawCell:function(data) {
                if (typeof(data.cell.raw.getElementsByTagName('img')[0]) != 'undefined') {
                    var td = data.cell.raw;              
                    var img = td.getElementsByTagName('img')[0];       
                    var dim = data.cell.height - data.cell.padding('vertical');
                    var textPos = data.cell.getTextPos();
                    doc.addImage(img.src, textPos.x,  textPos.y, dim, dim);
                }
            }
        })
        doc.save("qr.pdf");
    },     */ 
    
    exportarQr () {
        this.$store.commit('loading', true);
        window.jsPDF = window.jspdf.jsPDF;
        this.TablaInternoEquiposCheck = this.TablaInternoEquipos.filter(e => e.check === true)   
        var doc = new jsPDF();
        var startId = 1;
        var endId = this.TablaInternoEquiposCheck.length;
        let x = 0;
        let y = 10;
        let j = 0;
        let k = 0;
        let paddingH = 10;
        let paddingT = 10;  
        let items = 0;
        const qrSize = 70;
        const A4pageWidth = 210; // 210mm
        const A4pageHeight = 297; // 297mm
        const vPadding = 10;
        const textPadding = 10;        

        for (let i = 0; i <= endId  - startId; ++i) {
            if (items >= 12) {
                doc.addPage();
                x = 0;
                y = 10;
                j = 0;
                k = 0;
                items = 0;
            }
            let imageData = new Image(qrSize, qrSize);
            imageData.src = this.TablaInternoEquiposCheck[i].qr;
            console.log('src: ' ,imageData.src);
            // doc.text("Scan me", x, y);
            console.log(`x : ${x} , y : ${y}`);
            console.log(`qrSize : ${qrSize}`);
            doc.addImage(imageData, "PNG", x + paddingH, y, 40, 40);
            doc.setFontSize(8);
            doc.text(`N° Int ${this.TablaInternoEquiposCheck[i].nro_interno} / N° Serie ${this.TablaInternoEquiposCheck[i].nro_serie}`, x + textPadding, y + 45);

            doc.setLineDash([2, 2], 0);
            doc.line(x + 5,  y - 3 , x + 55 , y - 3);
            doc.line(x + 55,  y - 3 , x + 55 , y + 47);
            doc.line(x + 55,  y + 47 , x + 5 , y + 47);
            doc.line(x + 5,  y - 3 , x + 5 , y + 47);

            // console.log("x,y", x, y);
            items++;
            if (x >= A4pageWidth - qrSize) {
                x = 0;
                k = 0;
                y = ++j * qrSize + vPadding;
            } else {
                x = ++k * qrSize;
            }
        }
        this.$store.commit('loading', false);
        doc.save("a4.pdf");
            
    }

    }
}

</script>
<style scope>
.pagination {
    color : blue
}
.page-item {
}

</style> 