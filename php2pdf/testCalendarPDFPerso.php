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
$subject1 = new Matiere('Algo');
$subject2 = new Matiere('POO');
$begin1 = '2015-04-10 8:30';
$end1 = '2015-04-10 10:00';
$course1 = new Cours($subject1,strtotime($begin1),strtotime($end1));
$course1->setNumber(1);
$course1->setRoom('G102');
$course1->setTypeOfCourse(CM);
$edt = new EDTClasse($class);
$edt->addCourse($course1);

$begin2 = '2015-04-10 10:15';
$end2 = '2015-04-10 11:45';
$course2 = new Cours($subject1,strtotime($begin2),strtotime($end2));
$course2->setNumber(1);
$course2->setRoom('G102');
$course2->setTypeOfCourse(TD);
$edt->addCourse($course2);

$begin3 = '2015-04-10 13:45';
$end3 = '2015-04-10 15:15';
$course3 = new Cours($subject2,strtotime($begin3),strtotime($end3));
$course3->setNumber(1);
$course3->setRoom('F207');
$course3->setTypeOfCourse(TP);
$edt->addCourse($course3);

$pdf = new calendarPDF(); 
$pdf->drawEDT($edt);

?>
