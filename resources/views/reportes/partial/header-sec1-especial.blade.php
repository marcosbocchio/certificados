<style>
.header{
    height: 31.92px;
    width: 100%;
    padding: 5px 0px 0px 0px; 
}
.cont{
    width:100%;
    margin: -4px 0px 2px 0px;
    box-shadow: rgba(0, 0, 0, 0.45) 0px 25px 20px -20px;
}
.color1 {
    display:inline-block;
    height: 5px;
    width: 25%;
    background: #7f8e2b;
    padding:0px;
    margin: 0px -4px 0px -2px;
}

.color2 {
    display:inline-block;
    height: 5px;
    width: 25%;
  background: #c0504d;
  padding:0px;
  margin: 0px -2px 0px 0px;
  box-shadow: rgba(0, 0, 0, 0.45) 0px 25px 20px -20px;
}

.color3 {
    display:inline-block;
    height: 5px;
    width: 25%;
    background: #f1ab00;
    padding:0px;
    margin: 0px 0px 0px -2px;
}

.color4 {
    display:inline-block;
    height: 5px;
    width: 25%;
    background: #4f81bd;
    padding:0px;
    margin: 0px 0px 0px -4px;
}
</style>

<table class="header">
    <tbody>
        <tr>
            <td class="logo">
                <img src="{{ public_path('img/aesa.png')}}" alt="x">
            </td>
            <td style="width: 50%;">
                <table style="border-collapse: collapse;">
                    <tbody style="text-align: center;">
                        <tr>
                            <td style="font-size: 7pt;">
                                <b>FORMULARIO</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 9.8pt;">
                                <b>INFORME DE ENSAYO RADIOGRAFICO</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 8.80pt;">
                                <b>Radiographic Examination Report</b>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt;">
                                <b>{{ $nro }}({{ $fecha }} - AESA Privada)</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
            <td style="width: 20%;">
                    <img  src="storage/logos-contratistas/ZncK9ijcmxVj4QyndfsWXIgromtnsYaZULjkME5S.png" alt="">
            </td>
        </tr>
    </tbody>
</table>
<div class="cont">
    <div class="color1"></div>
    <div class="color2"></div>
    <div class="color3"></div>
    <div class="color4"></div>
</div>
    

  

        
