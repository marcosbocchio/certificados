
<template>
    <div class="row">

        <div class="col-md-12">
            <div id="qrcode" style="display: none"></div>
            <tabs :options="{ useUrlFragment: false }">
                <tab name="Vehiculos">
                    <div  v-if="1">
                        <div class="row">
                            <div class="col-lg-4">
                                <button type="button" class="btn btn-success" @click="exportarQr"><i class="fa fa-qrcode"></i>  Exportar QR</button>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 25px;">
                        <div class="col-lg-12">
                            <div v-if="1">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Vehiculos</h3>
                                    </div>

                                    <div class="box-body">
                                        <div class="table-responsive">
                                        <table class="table table-striped table-condensed">
                                            <tbody>
                                                <tr>
                                                    <th class="col-md-3">N° Int</th>
                                                    <th class="col-md-3">Marca</th>
                                                    <th class="col-md-3">Modelo</th>
                                                    <th class="col-md-3">Patente</th>
                                                    <th class="col-md-1">
                                                        <input type="checkbox" v-model="checkTodo" @click="selTodo">
                                                    </th>
                                                </tr>
                                                <tr v-for="(item) in vehiculos" :key="item.id">
                                                    <td>{{ item.nro_interno }} </td>
                                                    <td>{{ item.marca }}</td>
                                                    <td>{{ item.modelo }} </td>
                                                    <td>{{ item.patente}} </td>
                                                    <td>
                                                        <input type="checkbox" id="checkbox" v-model="item.check" @click="setCheck(item)">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                              </div>
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
      vehiculo: '',
      selTipo_equipamiento: false,
      search:'',
      TablaVehiculos: [],
      TablaVehiculosCheck: [],
      pageCount: 0,
      page: 0,
      vehiculos2: [],
      checkTodo: false,
      cantColumPdf : 3,
     }
    },

    async created() {
      await this.$store.dispatch('loadVehiculos');
      this.Buscar2();
    },
    computed :{
        ...mapState(['isLoading','vehiculos','url']),
    },

    methods :{
      async CambioTipoEquipamiento() {
        this.selTipo_equipamiento = !this.selTipo_equipamiento;
      },
      async Buscar2 () {
        this.$store.commit('loading', true);
        try {
          this.totalRows = this.vehiculos.length
          console.log('Total: ',this.totalRows);
          console.log('Calculo:',(this.totalRows % 10))
          this.pageCount = (this.totalRows % 10) == 0  ? (this.totalRows / 10) : (Math.floor(this.totalRows / 10) + 1);
          console.log(this.pageCount);
          var qrcode = new QRCode('qrcode',{
            width: 300,
            height: 300,
            colorDark : "#000000",
            colorLight : "#ffffff",
            });
          for (const item of this.vehiculos) {
              Object.defineProperty(item, 'check', { value: false, enumerable: true, writable:true, configurable: true})
                let id = item.id.toString();
                qrcode.makeCode(`${window.location.origin}/area/enod/vehiculo/${id}/doc`);
                console.log(`${window.location.origin}/area/enod/vehiculo/${id}/doc`);
                jQuery('#qrcode canvas').css('padding', '20px');
                const delay = ms => new Promise(res => setTimeout(res, ms));
                await delay(5);
                Object.defineProperty(item, 'qr', { value: qrcode._oDrawing._elCanvas.toDataURL("image/png"), enumerable: true, writable:true, configurable: true})
          };
        }catch(error){

        }finally {this.$store.commit('loading', false);}
     },

    setCheck (item) {
        console.log(this.vehiculos.findIndex(e => e.id == item.id))
        let index = this.vehiculos.findIndex(e => e.id == item.id);
        this.vehiculos[index].check = item.check;
    },
    selTodo() {
        this.vehiculos.forEach(function(item) {
            item.check = !this.checkTodo;
            console.log(item.check)
        }.bind(this))
    },
    async exportarQr () {
        this.$store.commit('loading', true);
        window.jsPDF = window.jspdf.jsPDF;
        console.log(this.vehiculos)
        this.TablaVehiculosCheck = this.vehiculos.filter(e => e.check === true)
        var doc = new jsPDF();
        var startId = 1;
        var endId = this.TablaVehiculosCheck.length;
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
        console.log(endId)

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
            imageData.src = this.TablaVehiculosCheck[i].qr;
            console.log('src: ' ,imageData.src);
            // doc.text("Scan me", x, y);
            console.log(`x : ${x} , y : ${y}`);
            console.log(`qrSize : ${qrSize}`);
            doc.addImage(imageData, "PNG", x + paddingH, y, 40, 40);
            doc.setFontSize(8);
            doc.text(`N° Int ${this.TablaVehiculosCheck[i].nro_interno} / Patente ${this.TablaVehiculosCheck[i].patente}`, x + textPadding, y + 45);

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

</style>
