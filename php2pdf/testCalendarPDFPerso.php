<?php
//test pour ma classe calendarPDF

//files required (others classes)
require_once('calendarPDF.php');
require_once('../class.Classe.php');
require_once('../class.Cours.php');
require_once('../class.EDTClasse.php');
require_once('../class.Matiere.php');

//Objects initialization block
$class = new Classe("INFO2");
$subject = new Matiere('Algo');
$begin1 = new DateTime('2015-04-10 8:30:00');
$end1 = new DateTime('2015-04-10 10:00:00');
$course = new Cours($subject,$begin1,$end1);
$course->setNumber(1);
$course->setRoom('G102');
$course->setTypeOfCourse('CM');
$edt = new EDTClasse($class);
$edt->addCourse($course);

echo $edt->getClasse()->getName();
$listCourses = $edt->getListCourses();
$tempCourse = end($listCourses);
echo $tempCourse->getBegin_string();
/*
$pdf = new calendarPDF(); 
$pdf->drawEDT($edt);
*/

?>
