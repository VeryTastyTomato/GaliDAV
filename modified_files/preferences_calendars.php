<!-- File modified for GaliDAV -->

<table id="preferences_calendar_manager" class="table table-striped">
<thead>
 <th>
 <?php
 	echo 'Cours'; // $this->i18n->_('labels', 'calendar');
 ?>
 </th>
 <th style="text-align: center"><?php echo $this->i18n->_('labels', 'hidelist')?></th>
 <th></th>
</thead>
<tbody>
<?php
$i=1;
foreach ($calendar_list as $cal):
?>
 <tr>
  <td>
  <?php echo $cal->displayname ?>
  </td>
  <td style="text-align: center">
    <input type="hidden" name="calendar[<?php echo $i ?>][name]" value="<?php echo
	$cal->calendar?>" />
    <input type="checkbox" name="calendar[<?php echo $i ?>][hide]"
	value="1"<?php echo (isset($hidden_calendars[$cal->calendar])) ? ' checked="checked"' : ''?>>
  </td>
 </tr>
<?php
$i++;
endforeach;
?>
</tbody>
</table>
<?php
echo formelement(
		$this->i18n->_('labels', 'defaultsubject'),
		form_dropdown('default_calendar', $calendar_ids_and_dn,
			$default_calendar,
			'class="medium"'),
			$this->i18n->_('messages', 'help_defaultsubject'));

?>
