// File modified for GaliDAV

<div id="com_event_dialog">
<div id="com_event_dialog_tabs">
<?php
/**
  allday can be false (on editing). Hide some fields
 */

if (isset($allday) && $allday === FALSE) {
	unset($allday);
}

/*
 * Recurrence rules
 */
if (isset($recurrence)) {
	$recurrence_type = $recurrence['FREQ'];
	if (isset($recurrence['COUNT'])) {
		$recurrence_count = $recurrence['COUNT'];
	} elseif (isset($recurrence['UNTIL'])) {
		$recurrence_until = $recurrence['UNTIL'];
	}
}

$data_form = array(
	'id' => 'com_form',
	'class' => 'form-horizontal',
);
echo form_open('event/modify', $data_form);

// Define all form fields
$form_summary = array(
		'name' => 'summary',
		'value' => (isset($summary) && $summary !== FALSE) ? $summary : '',
		'class' => 'summary input-large',
		'maxlength' => '255',
		'size' => '25',
		);

$form_location = array(
		'name' => 'location',
		'value' => (isset($location) && $location !== FALSE) ? $location : '',
		'class' => 'location input-large',
		'maxlength' => '255',
		'size' => '25',
		);

$form_calendar = $calendars;

$form_startdate = array(
		'name' => 'start_date',
		'value' => $start_date,
		'class' => 'start_date input-small',
		'maxlength' => '10',
		'size' => '15',
		);

$form_enddate = array(
		'name' => 'end_date',
		'value' => $end_date,
		'class' => 'end_date input-small',
		'maxlength' => '10',
		'size' => '15',
		);

$form_starttime = array(
		'name' => 'start_time',
		'class' => 'time start_time input-mini',
		'maxlength' => '10',
		'value' => $start_time,
		'size' => '15',
		);

$form_endtime = array(
		'name' => 'end_time',
		'class' => 'time end_time input-mini',
		'maxlength' => '10',
		'value' => $end_time,
		'size' => '15',
		);

// Hide time fields if allday is true
if (isset($allday)) {
	$form_starttime['style'] = 'display: none';
	$form_endtime['style'] = 'display: none';
}

$form_allday = array(
		'name' => 'allday',
		'value' => 'true', // Value used if checkbox is marked
		'class' => 'allday',
		'checked' => isset($allday),
		);

$form_description = array(
		'name' => 'description',
		'class' => 'description input-large',
		'rows' => '4',
		'value' => (isset($description) && $description !== FALSE) ? $description : '',
		);

$form_recurrence_type = array(
		'none' => $this->i18n->_('labels', 'repeatno'),
		'DAILY' => $this->i18n->_('labels', 'repeatdaily'),
		'WEEKLY' => $this->i18n->_('labels', 'repeatweekly'),
		'MONTHLY' => $this->i18n->_('labels', 'repeatmonthly'),
		'YEARLY' => $this->i18n->_('labels', 'repeatyearly'),
		);


$form_recurrence_count = array(
		'name' => 'recurrence_count',
		'value' => (isset($recurrence_count) && $recurrence_count !== FALSE)
			? $recurrence_count : '',
		'class' => 'recurrence_count input-mini',
		'maxlength' => '20',
		'size' => '3',
		);
$form_recurrence_until = array(
		'name' => 'recurrence_until',
		'value' => (isset($recurrence_until) && $recurrence_until !== FALSE)
			? $recurrence_until : '',
		'class' => 'recurrence_until input-small',
		'maxlength' => '10',
		'size' => '15',
		);

if (isset($recurrence_type) && $recurrence_type == 'none') {
	$recurrence_count['disabled'] = 'disabled';
	$recurrence_until['disabled'] = 'disabled';
}

$form_class = array(
		'PUBLIC' => $this->i18n->_('labels', 'public'),
		'PRIVATE' => $this->i18n->_('labels', 'private'),
		'CONFIDENTIAL' => $this->i18n->_('labels', 'confidential'),
		);

$form_transp = array(
		'OPAQUE' => $this->i18n->_('labels', 'opaque'),
		'TRANSPARENT' => $this->i18n->_('labels', 'transparent'),
		);

?>
<ul>
 <li><a href="#tabs-general">
 <i class="tab-icon icon-tag"></i>
 <?php echo $this->i18n->_('labels', 'generaloptions')?></a>
 </li>
 <li><a href="#tabs-recurrence">
 <i class="tab-icon icon-repeat"></i>
 <?php echo $this->i18n->_('labels', 'repeatoptions')?></a>
 </li>
 <li><a href="#tabs-reminders">
 <i class="tab-icon icon-bell"></i>
 <?php echo $this->i18n->_('labels', 'remindersoptions')?></a>
 </li>
 <li><a href="#tabs-workgroup">
 <i class="tab-icon icon-group"></i>
 <?php echo $this->i18n->_('labels', 'workgroupoptions')?></a>
 </li>
</ul>
<div id="tabs-general">
<?php if (isset($modification) && $modification === TRUE): ?>
 <input type="hidden" name="modification" class="modification" value="true" />
<?php endif; ?>
 <input type="hidden" name="uid" class="uid"
 	value="<?php echo isset($uid) ? $uid : '' ?>" />
 <input type="hidden" name="href" class="href"
 	value="<?php echo isset($href) ? $href : ''; ?>" />
 <input type="hidden" name="etag" class="etag"
 	value="<?php echo isset($etag) ? $etag : ''; ?>" />

<?php
echo formelement(
		'Type de cours',
		//$this->i18n->_('labels', 'type_cours'),
		form_input($form_summary));


echo formelement(
		'Salle',
		//$this->i18n->_('labels', 'location'),
		form_input($form_location));


echo form_hidden('original_calendar', $calendar);
echo formelement(
		'Matière',
		//$this->i18n->_('labels', 'calendar'),
		form_dropdown('calendar', $form_calendar, $calendar,
			'class="medium"'));


echo formelement(
		$this->i18n->_('labels', 'startdate'),
		form_input($form_startdate) .  form_input($form_starttime));

echo formelement(
		$this->i18n->_('labels', 'enddate'),
		form_input($form_enddate) .  form_input($form_endtime));

echo formelement(
		$this->i18n->_('labels', 'alldayform'),
		form_checkbox($form_allday));
   
echo formelement(
		$this->i18n->_('labels', 'description'),
		form_textarea($form_description));
?>
 </div>
 <div id="tabs-recurrence">
<?php
if (!isset($unparseable_rrule)) {
	echo formelement(
			$this->i18n->_('labels', 'repeat'),
			form_dropdown('recurrence_type',
				$form_recurrence_type, (isset($recurrence_type) ?
					$recurrence_type : 'none'),
				'class="recurrence_type input-medium"'));

	echo formelement(
			$this->i18n->_('labels', 'repeatcount'),
			form_input($form_recurrence_count));

	echo formelement(
			$this->i18n->_('labels', 'repeatuntil'),
			form_input($form_recurrence_until));
} else {
	?>
	 <input type="hidden" name="unparseable_rrule" value="true" />
	 <?php echo $this->i18n->_('messages', 'info_repetition_unparseable')?>
	 <pre><?php echo $rrule_raw?></pre>
	 <?php
}
?>
	
 </div>
 <div id="tabs-reminders">
 </div>
 <div id="tabs-workgroup">
 <?php
echo formelement(
		 $this->i18n->_('labels', 'privacy'),
		 form_dropdown('class', $form_class, 
			 (isset($class) ? $class : 'PUBLIC'),
			 'class="input-medium"'));
   
echo formelement(
    $this->i18n->_('labels', 'transp'),
	form_dropdown('transp', $form_transp, 
		(isset($transp) ? $transp : 'OPAQUE'),
			'class="input-medium"'));
   
?>
 </div>
<?php echo form_close() ?>
</div>
