/**
 * @package		Inceptive Multiple Categories for K2
 * @author		Inceptive Design Labs - http://www.inceptive.gr
 * @copyright	Copyright (c) 2016 Inceptive Design Labs. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

window.addEvent('domready', function () {
	tabIncptvMC = $('tabIncptvMC');
	k2all_tabs = $('k2Tabs');
	k2TabIncptvMC = $('k2TabIncptvMC');
	
	k2tabs_holder = $$('.simpleTabsNavigation');
	if (typeof (k2tabs_holder[0]) === 'undefined')
	{
		k2tabs_holder = $$('.k2TabsNavigation');
		k2TabIncptvMC.removeChild(k2TabIncptvMC.getElementsByClassName('admintable')[0]);
		var node = document.getElementById('tabIncptvMCold');
		node.parentNode.removeChild(node);
	}
	else
	{
		k2TabIncptvMC.removeChild(k2TabIncptvMC.getElementsByClassName('itemAdditionalField')[0]);
		var node = document.getElementById('tabIncptvMCK2ge27');
		node.parentNode.removeChild(node);
	}

	k2tabs_holder[0].grab(tabIncptvMC, 'bottom');
	k2all_tabs.grab(k2TabIncptvMC, 'bottom');
	tabIncptvMC.setStyle('visibility', 'visible');
	k2TabIncptvMC.setStyle('visibility', 'visible');

});

var $incptvK2 = jQuery.noConflict();

$incptvK2(document).ready(function () {
    var $selectedValue = $incptvK2('#catid').find(":selected").text();
    $incptvK2('#catid').change(function () {
		var $newSelectedValue = $incptvK2('#catid').find(":selected").text();
		var $newSelectedOption = $incptvK2('#pluginsincptvk2multiplecategories option:contains("' + $newSelectedValue + '")');
		$newSelectedOption.attr('disabled', 'disabled');
		$newSelectedOption.removeAttr('selected');
		var $selectedOption = $incptvK2('#pluginsincptvk2multiplecategories option:contains("' + $selectedValue + '")');
		$selectedOption.removeAttr('disabled');
		$selectedValue = $newSelectedValue;
    });
});