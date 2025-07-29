<h1 style="color:blue">Print</h1>
<?php $exam_detail[0]->exam_name;


print_r($exam_detail);?>
<?php //print_r($data);?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
      table {
        border: 3px solid black;
        border-spacing: 0 15px;
      }
      td {
        width: 150px;
        text-align: center;
      }
    </style>
  </head>
  <body>
    <table align="center">
      <tbody >
        <tr>
          <th colspan="3">Name of institute</th>
        </tr>
        <tr>
          <td>Institute Logo : </td>
          <td>Name of exam : <?php echo $exam_detail[0]->exam_name;?></td>
          <td>Date : <?php echo $exam_detail[0]->exam_date;?></td>
        </tr>
        <tr>
          <td scope="row"></td>
          <td>Class : <?php echo $exam_detail[0]->class_name;?></td>
          <td>Duration : <?php echo $exam_detail[0]->exam_time;?></td>
        </tr>
        <tr>
          <td scope="row">UID Barcode(if any)</td>
          <td>Subject  : <?php echo $exam_detail[0]->subject_name;?></td>
          <td>Marks  : <?php echo $exam_detail[0]->total_mark;?></td>
        </tr>
        <tr>
          <td style="outline: solid; text-align: start; padding: 3rem 0 3rem 0;" colspan="3">Instruction(if any)</td>
        </tr>
		<?php $i = 1; foreach($data as $dv){?>
        <tr>
          <td><?php echo $i;?> : <?php echo $dv->question;?></td>
        </tr>
       
		<?php $i++;}?>
        <tfoot>
          <th colspan="3">End of Question Paper</th>
        </tfoot>
      </tbody>
    </table>
  </body>
</html>
