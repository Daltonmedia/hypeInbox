<?php

$name = elgg_extract('name', $vars, '__new');

if ($name == HYPEINBOX_NOTIFICATION || $name == HYPEINBOX_PRIVATE) {
	echo elgg_view('input/hidden', array(
		'name' => "message_types[$name][name]",
		'value' => $name
	));
} else {
	echo '<div>';
	echo '<label>' . elgg_echo('item:object:message:name') . '</label>';
	echo elgg_view('input/text', array(
		'name' => "message_types[$name][name]",
		'value' => ($name != '__new') ? $name : ''
	));
	echo '</div>';
}

echo '<div>';
echo '<label>' . elgg_echo('item:object:message:label:singular') . '</label>';
echo elgg_view('input/text', array(
	'name' => "message_types[$name][labels][singular]",
	'value' => $vars['labels']['singular']
));
echo '</div>';

echo '<div>';
echo '<label>' . elgg_echo('item:object:message:label:plural') . '</label>';
echo elgg_view('input/text', array(
	'name' => "message_types[$name][labels][plural]",
	'value' => $vars['labels']['plural']
));
echo '</div>';

echo '<br />';

echo '<div><label>' . elgg_view('input/checkbox', array(
	'name' => "message_types[$name][persistent]",
	'checked' => elgg_extract('persistent', $vars, false),
	'value' => 1,
	'default' => false
)) . elgg_echo("item:object:message:setting:persistent") . '</label></div>';

echo '<br />';

if ($name == HYPEINBOX_NOTIFICATION) {
	return;
}

if (elgg_is_active_plugin('file')) {
	echo '<div><label>' . elgg_view('input/checkbox', array(
		'name' => "message_types[$name][attachments]",
		'checked' => elgg_extract('attachments', $vars, false),
		'value' => 1,
		'default' => false
	)) . elgg_echo("item:object:message:setting:attachments") . '</label></div>';

	echo '<br />';
}

echo '<div><label>' . elgg_view('input/checkbox', array(
	'name' => "message_types[$name][multiple]",
	'checked' => elgg_extract('multiple', $vars, false),
	'value' => 1,
	'default' => false
)) . elgg_echo("item:object:message:setting:multiple") . '</label></div>';

echo '<br />';

// allowed recipients and senders
$types = elgg_get_config('inbox_user_types');
foreach ($types as $t => $opts) {
	$user_types_options[$t] = elgg_echo("hj:inbox:user_type:$t");
}

$relationships = elgg_get_config('inbox_user_relationships');
foreach ($relationships as $r) {
	$user_relationships_options[$r] = $r;
}


$policy = elgg_extract('policy', $vars, array(''));

echo '<label>' . elgg_echo('item:object:message:setting:policy') . '</label>';
echo '<div class="elgg-text-help">' . elgg_echo('item:object:message:setting:policy:help') . '</div>';

echo '<div class="clearfix">';
echo '<div class="elgg-col elgg-col-1of5">' . elgg_echo('hj:inbox:sender') . '</div>';
echo '<div class="elgg-col elgg-col-1of5">' . elgg_echo('hj:inbox:recipient') . '</div>';
echo '<div class="elgg-col elgg-col-1of5">' . elgg_echo('hj:inbox:relationship') . '</div>';
echo '<div class="elgg-col elgg-col-1of5">' . elgg_echo('hj:inbox:inverse_relationship') . '</div>';
echo '</div>';

foreach ($policy as $p) {
	echo '<div class="inbox-policy clearfix">';
	echo '<div class="elgg-col elgg-col-1of5">' . elgg_view('input/dropdown', array(
		'name' => "message_types[$name][policy][sender][]",
		'value' => $p['sender'],
		'options_values' => $user_types_options
	)) . '</div>';
	echo '<div class="elgg-col elgg-col-1of5">' . elgg_view('input/dropdown', array(
		'name' => "message_types[$name][policy][recipient][]",
		'value' => $p['recipient'],
		'options_values' => $user_types_options
	)) . '</div>';
	echo '<div class="elgg-col elgg-col-1of5">' . elgg_view('input/dropdown', array(
		'name' => "message_types[$name][policy][relationship][]",
		'value' => $p['relationship'],
		'options_values' => $user_relationships_options
	)) . '</div>';
	echo '<div class="elgg-col elgg-col-1of5">' . elgg_view('input/dropdown', array(
		'name' => "message_types[$name][policy][inverse_relationship][]",
		'value' => $p['inverse_relationship'],
		'options_values' => array(
			'' => '',
			false => elgg_echo('No'),
			true => elgg_echo('Yes')
		)
	)) . '</div>';
	echo '<div class="elgg-col elgg-col-1of5"><i class="inbox-icon-plus"></i><i class="inbox-icon-minus"></i></div>';
	echo '</div>';
}



	