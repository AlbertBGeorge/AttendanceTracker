<!DOCTYPE html>
<head>
    <title>Attendance Tracker</title>
    <link rel="stylesheet" type="text/css" href="style3.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
<?php
$branch = $_POST['branch'];
$sem = $_POST['sem'];
if (isset($_POST['div']))
{
	$div = $_POST['div'];
}
else
{
	$div = "";
}
$roll = $_POST['roll'];
$batch = $branch.$sem.$div;
$roll += 2;
$html = file_get_contents('http://attendance.mec.ac.in/view4stud.php?class='.$batch.'&submit=view');
$doc = new DOMDocument();
libxml_use_internal_errors(TRUE);
if(!empty($html)) {
	$doc->loadHTML($html);
	libxml_clear_errors();
	$xpath = new DOMXPath($doc);
	
	$row = $xpath->query('//tr[1]/td');
	$subject = array();
	$sub = array();
	$classCount = array();
	$k = 0;
	if($row->length > 0){
		foreach($row as $prow){
			$x = trim($prow->nodeValue);
			if(strpos('HNLGrade', $x) !== false) {
			break;
			}
			if(strpos($x, '(') !== false) {
				$pos1 = strpos($x, '(');
				$pos2 = strpos($x, ')');
				$pos = $pos2 - $pos1;
				$sub[$k] = substr($x, 0, $pos1);
				$classCount[$k] = substr($x, $pos1+1, $pos-1);
				$k++;

			}
			array_push($subject, $x);
		}
	}	
	$row = $xpath->query('//tr['.$roll.']/td');
	$attn = array();
	if($row->length > 0){
		foreach($row as $prow){
			$x = trim($prow->nodeValue);
			if(strpos('HNL', $x) !== false) {
			break;
			}
			array_push($attn, $x);
		}
	}

	$bunk = array();
	for($i = 0; $i < sizeof($subject); $i++) {
		$bunk[$subject[$i]] = $attn[$i];
	}
}
?>
<?php
$subName = array(
    "MA102" => "Differential Equations",
    "CY100" => "Engineering Chemistry",
    "CY110" => "Chemistry Lab",
    "BE100" => "Engineering Mechanics",
    "BE102" => "Design & Engineering",
    "BE110" => "Engineering Graphics",
    "EE100" => "Basics of Electrical Engineering",
    "EE110" => "Electrical Workshop",
    "ME100" => "Basics of Mechanical Engineering",
    "ME110" => "Mechanical Workshop",
    "CS100" => "Computer Programming",
    "CS120" => "C Programming Lab",
    "EC100" => "Basics of Electronics Engineering",
    "EC110" => "Electronics Workshop",
    "CE100" => "Basics of Civil Engineering",
    "CE110" => "Civil Workshop",
    "GN102" => "Course U",
    "PH100" => "Engineering Physics",
    "PH110" => "Physics Lab",
    "MA202" => "Probability Distributions, Transforms and Numerical Methods",
 	"BM202" => "Biophysics",
 	"BM204" => "Integrated Circuits & Systems",
 	"BM206" => "Microcontrollers",
 	"BM208" => "Fundamentals of Computer Programming",
 	"HS200" => "Business Economics",
 	"BM232" => "Analog Circuits Lab",
 	"BM234" => "Computer Programming Lab",
 	"CS202" => "Computer Organization and Architecture",
	"CS204" => "Operating Systems",
	"CS206" => "Object Oriented Design and Programming",
	"CS208" => "Principles of Database Design",
	"CS232" => "Free and Open Source Software Lab",
	"CS234" => "Digital Systems Lab",
	"EE 801" => "Electronic Instrumentation",
	"EE 802" => "Electrical Machine Design",
	"EE 803" => "Power Systems III",
	"EE 804" => "ELECTIVE III",
	"EE 805" => "PROJECT",
	"MA204" => "Probability distributions, Random Processes and Numerical Methods",
	"EC202" => "Signals & Systems",
	"EC204" => "Analog Integrated Circuits",
	"EC206" => "Computer Organization",
	"EC208" => "Analog Communication Engineering",
	"HS201" => "Life Skills",
	"EC232" => "Analog Integrated Circuits Lab",
	"EC234" => "Logic Circuit Design Lab",
	"BM302" => "Analytical & Diagnostic Equipment",
	"BM304" => "Biomedical Signal Processing",
	"BM314" => "Principles of Logic System Design",
	"BM308" => "Computational Methods in Biomedical Engineering",
	"BM312" => "Control System Engineering",
	"BM36X" => "Elective 2",
	"BM332" => "Biomedical Signal Processing Lab",
	"BM336" => "Bioengineering Lab",
	"BM352" => "Comprehensive Exam",
	"CS302" => "Design and Analysis of Algorithms",
	"CS304" => "Compiler Design",
	"CS306" => "Computer Networks",
	"CS308" => "Software Engineering and Project Management",
	"HS300" => "Principles of Management",
	"CS36X" => "Elective 2",
	"CS332" => "Microprocessor Lab",
	"CS334" => "Network Programming Lab",
	"CS352" => "Comprehensive Exam",
	"EE302" => "Electromagnetics",
	"EE304" => "Advanced Control Theory",
	"EE306" => "Power System Analysis",
	"EE308" => "Electric Drives",
	"EE36X" => "Elective 2",
	"EE332" => "Systems and Control Lab",
	"EE334" => "Power Electronics and Drives Lab",
	"EE352" => "Comprehensive Exam",
	"EC302" => "Digital Communication",
	"EC304" => "VLSI",
	"EC306" => "Antenna & Wave Propagation",
	"EC308" => "Embedded System",
	"EC312" => "Object Oriented Programming",
	"EC36X" => "Elective 2",
	"EC332" => "Communication Engg Lab (Analog and Digital)",
	"EC334" => "Microcontroller Lab",
	"EC352" => "Comprehensive Exam",
	"EB 801" => "Principles of Radio diagnosis and Radiotherapy",
	"EB 802" => "Biomaterials",
	"EB 803" => "BIOPHOTONICS",
	"EB 804" => "ELECTIVE III",
	"EB 805" => "PROJECT",
	"CS 801" => "Advanced Architecture and parallel Processing",
	"CS 802" => "OBJECT ORIENTED MODELLING AND DESIGN",
	"CS 803" => "DISTRIBUTED COMPUTING",
	"CS 804" => "ELECTIVE III",
	"CS 805" => "PROJECT WORK",
	"EC 801" => "Multimedia Communication Systems",
	"EC 802" => "Wireless Communication",
	"EC 803" => "Computer Communication & Networking",
	"EC 804" => "ELECTIVE III",
	"EC 805" => "PROJECT",
);
?>
<div class="box1">
	<?php
	$pos = strpos($attn[1], ' ');
	$name = substr($attn[1], 0, $pos);
	?>
    <h1 align="center">HEY <?php echo "$name"; ?>!</h1>
    
                    <table id="t01" style="width:360px">
                        <?php
                        for($i = 0; $i <$k; $i++)
                        {
                        	$j = $i + 2;
                        	if ($attn[$j] != "Nil")
                        	{
                        	$at = $attn[$j] * $classCount[$i] / 100;
							$req = (3 * $classCount[$i] - $at * 4) / 4;
							$printMsg = "<b>Shortage</b>";
                        	$color = "red";
                        	$text_color = "red";
                        	$msg = "You need to attend";
							if ($req < 0) {
								$req = -1 * $req;
								if ($req % 1 > 0.5) {
									$req = round($req);
								}
								else {
									$req = round($req) + 1;
								}
								
								$printMsg = "Sufficient";
								$color = "white";
								$text_color = "green";
								$msg = "You can skip";
							}
							else {
								$req = round($req) + 1;
							}
                        	print "<tr>";
                          		print '<td><b><font color="white">'.$subName[$sub[$i]].'</font></b></td>';
                          		print '<td><font color="'.$color.'">Attendence &emsp;'.$printMsg.'</font></td>';
                          		print '<td><font color="white" face="verdana" size="3.5"><strong>'.$attn[$j].'%</strong></font>';
                          		print '<br><font size="1">'.$msg.'</font><br><b><font color="'.$text_color.'">'.$req.' CLASSES</font></b></td>';
                          	print "</tr>";	
                        	}
                        }
                        ?>
                    </table>
                      
                        
                      
                    </form>
            </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>