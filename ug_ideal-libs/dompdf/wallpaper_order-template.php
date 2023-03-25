
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    table {
      margin:auto;
    }
    td {
      font-family: Arial;
    }
    .wallpaper_image-wrapper {
      width: 500px;
      height: 300px;
      overflow: hidden;
      border: 1px solid grey;
    }
    .wallpaper_image {
      margin-top: 50px;
      width: 100%;
      margin-top: 0%;
      margin-left: 0%;
    }
  </style>
</head>
<body>
 <table class="provider_data_table">
  <tr>
    <td>
      <img src="img/ug-ideal.png" alt="ЮгИдеал" width="100">
    </td>
    <td colspan="2"><b>company_name</b></td>
  </tr>
  <tr>
   <td colspan="2">company_address</td>
 </tr>
 <tr>
   <td>company_phones</td>
   <td>company_email</td>
 </tr>
 <tr>
  <td>Время работы:</td>
  <td>work_time</td>
</tr>
<tr>
 <td><b>ЗАКАЗЧИК:</b></td>
 <td>customer_fio</td>
</tr>
<tr>
 <td>Email: customer_mail</td>
 <td>тел.: customer_phone</td>
</tr>
</table>
<table>
 <tr>
   <td>
    <div class="wallpaper_image-wrapper">
      <img src="../../ug_ideal-core/order_image.jpg" alt="">
    </div>       
  </td>
</tr>
</table>

<table>
 <tr>
   <td>Изображение (артикул): </td>
   <td>imageName</td>
   <td> | </td>
   <td>Высота стены: </td>
   <td>wallY</td>
 </tr>

 <tr>
   <td>Ширина стены: </td>
   <td>wallX</td>
   <td> | </td>
   <td>Ширина рулона: </td>
   <td>roll</td>
 </tr>
 
 <tr>
   <td>Фактура: </td>
   <td>texture</td>
   <td> | </td>
   <td>Стоимость: </td>
   <td>amount руб.</td>
 </tr>
 <tr>
   <td>Скидка: </td>
   <td>discount</td>
   <td> | </td>
   <td>Стоимость со скидкой: </td>
   <td>total руб.</td>
 </tr>
</table>

</body>
</html>