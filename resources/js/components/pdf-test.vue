<template>
    <div>
        <div id="sector1">
            <h2>Esto es una prueba</h2>
        </div>

            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Donut Chart</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                    
                </div>

                <div class="box-body">
                    <div class="col-md-4">
                        <div id="sector2" style="padding: 10px; ">
                            <doughnut-chart :chart-data="data"></doughnut-chart>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div id="sector3" style="padding: 10px; ">
                            <bar-chart :chart-data="data"></bar-chart>
                        </div>    
                   </div>
                </div>
               
            </div>

        <button @click="download">Download PDF </button>
    </div>
</template>
<script>

import DoughnutChart from './chart.js/DoughnutChart.js'
import BarChart from './chart.js/BarChart.js'
import html2canvas from 'html2canvas';

export default {

    components: {
      DoughnutChart,
      BarChart
    },
    
    data (){return{  

            data:{
                    labels: [
                        'Red',
                        'Yellow',
                        'Blue',
                        'green',
                    ],
                datasets: [
                    {
                        data: [3, 17, 25,55],
                        backgroundColor: [
                            'Red',    // color for data at index 0
                            'Yellow',  // color for data at index 3
                            'Blue',   // color for data at index 1
                            'green',  // color for data at index 2
                            //...
                        ]
                    }
                ],
                }
        }
    },

    methods :{   
     

            async download (){

                const doc = new jsPDF();

                await html2canvas(document.querySelector("#sector2")).then(canvas => {

                    var imgData = canvas.toDataURL('image/png')                 
                    doc.addImage(imgData,'PNG',80,30,50,50)

                });

                await html2canvas(document.querySelector("#sector3")).then(canvas => {
                    var imgData = canvas.toDataURL('image/png')
                    doc.addImage(imgData,'PNG',80,120,50,50)
                   
                });

                const html_sector1 = document.getElementById('sector1').innerHTML;
                 await doc.fromHTML(html_sector1,75,10); 

                doc.save("test.pdf")

        }
    }
}
</script>

<style>
  .small {
    max-width: 150px;
    margin:  100px auto;
  }

</style>