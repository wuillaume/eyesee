
<?php
if (isset($_GET['form_id'])) {
      //  echo $_GET['form_id'];
  $form_id = $_GET['form_id'];
}else{
        // Fallback behaviour goes here
  echo "THERE IS NO FORM ENTERED";
}
?>

<?php
$result = $bdd->query("SELECT * FROM form_id WHERE form_id = $form_id");
$dataForm = $result->fetch();
$formName = $dataForm['form_name'];

$result = $bdd->query("SELECT * FROM step INNER JOIN form ON form.step_id = step.step_id WHERE form_id = $form_id ORDER By step_order
  ");
  ?>

  <div style="float:left;">

    <?php
        // $resultquery = $bdd->query('SELECT distinct(form.form_id),form_name FROM form RIGHT JOIN form_id ON form.form_id = form_id.form_id');
    $resultquery = $bdd->query('SELECT form_id,form_name FROM form_id');
    ?>

    <form action="map_read.php" method = "get">
     <select name="form_id">
      <?php 
      /* We get each form one by one */
      while ($list_form = $resultquery->fetch())
      {
        ?>

        <option value="<?php echo htmlspecialchars( $list_form['form_id']); ?>" rel="<?php echo htmlspecialchars( $list_form['form_id']); ?>"><?php echo htmlspecialchars( $list_form['form_name']); ?></option>
        <?php 
      }
      ?>
    </select>
    <input type="submit" name="submit"/>
  </form>

</div>

<div >
 <h1>
   <?php echo htmlspecialchars($formName); ?>
 </h1>
</div>
<br>
<p>
  <div id="c">



    <?php


    /* We get each step one by one */
    while ($data = $result->fetch())
    {
      $classFontsize = "btn-font-".htmlspecialchars($dataForm['btn_font_size']);
      ?>
      <button type="button" class="btn btn-warning btn-arrow-right <?php echo htmlspecialchars($classFontsize) ?>" style="background-color: <?php echo htmlspecialchars($data['step_color']) ?>;" onclick="show(<?php echo htmlspecialchars($data['step_id']); ?>)"><?php echo htmlspecialchars($data['title']); ?></button>

      <?php
    }
    ?>


  </div>

  <div id="left_menu"  style="margin-left:2em; float:left;">
<?php

  $resultMenuList = $bdd->query("SELECT * FROM menu_left WHERE form_id = $form_id ORDER By menu_left_id");

    while ($dataMenuList = $resultMenuList->fetch()){
      $url="";
      if(!is_null($dataMenuList['menu_left_link'])){
        $url="target='_blank' href='".$dataMenuList['menu_left_link']."'";
        
      }
      ?>
      <a <?php echo htmlspecialchars($url); ?> type="button" class="btn btn-warning" onclick="show('Add<?php echo htmlspecialchars($dataMenuList['menu_left_id']); ?>')"><?php echo htmlspecialchars($dataMenuList['menu_left_name']); ?></a><br>
      <?php
    }
      ?>    

  </div>


  <?php
  $result2 = $bdd->query('SELECT * FROM step');
  $resultMenu = $bdd->query('SELECT * FROM menu_left');
  ?>
  <div id="contentText">




    <?php

    // FETCHING THE MENU ELEMENTS
    while ($dataMenu = $resultMenu->fetch())
    {
      ?>
        <div id="contentAdd<?php echo htmlspecialchars($dataMenu['menu_left_id']); ?>" class="content hidden">
              <?php echo htmlspecialchars_decode($dataMenu['menu_left_text']); ?>
        </div>
      <?php
   }
    /* We get each step one by one */
    while ($data2 = $result2->fetch())
    {
      ?>
      <div id="content<?php echo htmlspecialchars($data2['step_id']); ?>" class="content hidden">

        <p>
         <?php echo htmlspecialchars_decode($data2['text']); ?>
       </p>
       <p>

        <?php

        if (!empty($data2['recording'])){
         ?>
         Play a recording : 

         <audio controls="" disabled="disabled" name="view_field15_Client" id="view_field15_Client">  <source src="Recordmp3js-master/recordings/<?php echo htmlspecialchars($data2['recording']) ?>" type="audio/wav">


          <?php
        }


        ?>
      </p>
      <p>
      </p>
    </div>



    <?php


  }
  ?>


  </div>
</p>

<hr />

