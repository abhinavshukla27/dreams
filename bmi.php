<?php 
/* 
  Description: Body Mass Index Calculator 

  Author: Murray Moffatt for A Web 4 U Designs 

  Notes: Originally written for use on CarolynGibson.com 

  History: 
    2003-04-?? : Initial coding. 
    2005-02-13 : Remove extra CarolynGibson.com HTML and make 
      stand-alone for publishing on WeberDev.com. 
    2005-02-16 : Get $step variable from $_POST and add a 
      "Go Back" option at the end. 
*/ 
?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
<title>Body Mass Index</title> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> 
<meta name="author" content="A Web 4 U Designs - www.aweb4u.co.nz"> 
</head> 
<body bgcolor="#FFFFFF" text="#000000"> 
<h3>Body Mass Index (BMI)</h3> 
<?php 
$step = $_POST['step']; 
if ($step == "") { 
?> 
<p>The Body Mass Index (BMI) is a formula used to estimate the proportion 
  of your body that consists of fat. It is currently the best guide for 
  calculating a healthy weight range for people aged between 20 and 65.</p> 
<p>Do you want to work in metric (centimetres and kilograms) or imperial 
  (inches and pounds)?</p> 
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" name="unitsForm" id="unitsForm"> 
  <table border="0" cellspacing="1" cellpadding="2"> 
    <tr> 
      <td align="left"><input name="units" type="radio" value="metric" checked> 
        Metric</td> 
    </tr> 
    <tr> 
      <td align="left"><input type="radio" name="units" value="imperial"> 
        Imperial</td> 
    </tr> 
    <tr> 
      <td><input type="submit" name="Submit" value="Next ->"> 
        <input name="step" type="hidden" id="step" value="1"> 
      </td> 
    </tr> 
  </table> 
</form> 
<?php 
} 
if ($step == "1") { 
  $units = $_POST["units"]; 
?> 
<p>Type your weight and height measurements into the boxes below:</p> 
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" name="inputForm" id="inputForm"> 
  <table border="0" cellspacing="1" cellpadding="2"> 
    <tr> 
      <td align="right"><b>Your weight:</b></td> 
      <td align="left"><input name="weight" type="text" id="weight" size="6" maxlength="6"> 
        <?php if ($units == "metric") echo " kilos"; else echo "pounds"; ?> 
      </td> 
    </tr> 
    <tr> 
      <td align="right"><b>Your height:</b></td> 
      <td align="left"><input name="height" type="text" id="height" size="6" maxlength="6"> 
        <?php if ($units == "metric") echo " cm (i.e. 177 is 1.77 meters)"; else echo " inches (i.e. 67 is 5 feet 7 inches)"; ?> 
      </td> 
    </tr> 
    <tr> 
      <td><input name="step" type="hidden" id="step" value="2"> 
        <input name="units" type="hidden" id="units" value="<?php echo $units; ?>"> 
      </td> 
      <td><input type="submit" name="Submit" value="Next ->"> 
      </td> 
    </tr> 
  </table> 
</form> 
<?php 
} 
if ($step == "2") { 
  $units = $_POST["units"]; 
  $weight = $_POST["weight"]; 
  $height = $_POST["height"]; 

  if (!IsValidNumber($weight, ".", 2, 1, 999)) { 
    echo "<p>The weight measurement you entered, \"$weight\", is invalid.<br>"; 
    echo "Please enter a number between 1 and 999, optionally with up to two decimal places.<br>"; 
    echo "For example <b>90.5</b> is 90 and a half, <b>105.25</b> is 105 and a quarter.</p>"; 
    echo "<p>Please press Back on your browser and try again.</p>"; 
    die("</body></html>"); 
  } 
  
  if (!IsValidNumber($height, ".", 2, 1, 999)) { 
    echo "<p>The height measurement you entered, \"$height\", is invalid.<br>"; 
    echo "Please enter a number between 1 and 999, optionally with up to two decimal places.<br>"; 
    echo "For example <b>90.5</b> is 90 and a half, <b>105.25</b> is 105 and a quarter.</p>"; 
    echo "<p>Please press Back on your browser and try again.</p>"; 
    die("</body></html>"); 
  } 

  if ($units == "metric") { 
    $height = $height / 100; // Convert from centimeters to meters 
    $bmi = round($weight / ($height * $height), 1); 
    $height = $height * 100; // Convert back to centimeters 
  } else { 
    $heightcm = ($height * 2.54) / 100; // Convert from inches to meters 
    $weightkilo = $weight * 0.4536; // Convert from pounds to kilos 
    $bmi = round($weightkilo / ($heightcm * $heightcm), 1); 
  } 
?> 
<p>According to your height of <?php echo $height; ?> 
  <?php if ($units == "metric") echo "cm"; else echo "inches"; ?> 
  and weight of <?php echo $weight; ?> 
  <?php if ($units == "metric") echo "kilograms"; else echo "pounds"; ?> 
  your Body Mass Index is <b><?php echo $bmi; ?></b>.</p> 
<p>The answer that you get with this equation is NOT your weight but is 
  the factor that is used to establish your healthy weight range.</p> 
<p>A Body Mass Index of <?php echo $bmi; ?> indicates that 
<?php 
  if ($bmi < 20) { 
    echo " you are underweight."; 
  } 
  if ($bmi >= 20 and $bmi <= 24.9) { 
    echo " your weight is within the ideal range."; 
  } 
  if ($bmi >= 25 and $bmi <= 26.9) { 
    echo " you are slightly overweight."; 
  } 
  if ($bmi > 27) { 
    echo " you are overweight and at risk of weight-related problems."; 
  } 
?> 
</p> 
<p><a href="<?php echo $_SERVER["PHP_SELF"];?>">Go Back</a><p> 
<?php 
} 

function IsValidNumber($number, $decimal = null, $dec_prec = null, $min = null, $max = null) { 
  if (is_array($number)) { 
    extract($number); 
  } 
  $dec_prec   = $dec_prec ? "{1,$dec_prec}" : '+'; 
  $dec_regex  = $decimal  ? "[$decimal][0-9]$dec_prec" : ''; 
  if (!preg_match("|^[-+]?\s*[0-9]+($dec_regex)?\$|", $number)) { 
    return false; 
  } 
  if ($decimal != '.') { 
    $number = strtr($number, $decimal, '.'); 
  } 
  $number = (float)$number; 
  if ($min !== null && $min > $number) { 
    return false; 
  } 
  if ($max !== null && $max < $number) { 
    return false; 
  } 
  return true; 
} 
?> 
</body> 
</html>