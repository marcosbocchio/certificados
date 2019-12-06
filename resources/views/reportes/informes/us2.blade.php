
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">

  <style type='text/css'>
#rotate
{
  height:125px;
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
<table id="codexpl" class="bordered">
    <tr >
        <th >#</th>
        <th class="bordered"><span >98</span></th>
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
        <td id="rotate" class="bordered">One</td>
    </tr>
</table>
<p>TEST</p>

</body>
</html>