
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">

  <style type='text/css'>
#rotate
{
  height:155px;
}

#vertical
{
    -webkit-transform:rotate(-90deg);
    -moz-transform:rotate(-90deg);
    -o-transform: rotate(-90deg);
    margin-left: -50px;
    margin-right: -50px;
}

.bordered {
    border-color: #000000;
    border-style: solid;
    border-width: 2px; 
    border-collapse: collapse;   
}
  </style>
</head>
<body>
<table id="codexpl">
    <tr >
        <th >#</th>
        <th><span >98</span></th>
        <th id="rotate" class="bordered"><div id="vertical">A_LONG_HEADER</div></th>
    </tr>
    <tr>
        <td>1</td>
        <td>This</td>
        <td>c</td>
    </tr>
    <tr>
        <td>2</td>
        <td>6</td>
        <td>two</td>
    </tr>
    <tr>
        <td>3</td>
        <td>is</td>
        <td>not</td>
    </tr>
    <tr>
        <td>4</td>
        <td>the</td>
        <td>Column</td>
    </tr>
    <tr>
        <td>5</td>
        <td>first</td>
        <td>One</td>
    </tr>
</table>
<p>TEST</p>

</body>
</html>


    <!--
    <table style="text-align: center;" width="100%">
        <tbody>            
                <tr>
                    <td>                     
                        <table>    
                            <tbody>
                                <tr>
                                    <td style="text-align: center; width: 330px;height: 275px;">
                                           
                                            @if ($informe_us->path1_calibracion)
                                                <img src="{{ public_path($informe_us->path1_calibracion) }}" alt="" style="height: 160px; width: 234px;">
                                             @endif  
                       
                                    </td>
                              
                                    <td style="text-align: center; width: 330px;height: 275px;">
                                            @if ($informe_us->path2_calibracion)
                                                <img src="{{ public_path($informe_us->path2_calibracion')}}" alt="" style="height: 160px; width: 234px;">
                                            @endif  
                                    </td>
                              
                                </tr>
                               
                                <tr>
                                    <td style="text-align: center; width: 330px;height: 275px;">
                                            @if ($informe_us->path3_calibracion)
                                                 <img src="{{ public_path($informe_us->path3_calibracion) }}" alt="" style="height: 160px; width: 234px;">
                                           @endif  
                                    </td>

                                    <td style="text-align: center; width: 330px;height: 275px;">
                                            @if ($informe_us->path4_calibracion)
                                                <img src="{{ public_path($informe_us->path4_calibracion) }}" alt="" style="height: 160px; width: 234px;">
                                            @endif  
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
     </table>
    -->