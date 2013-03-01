window.addEvent('domready', function () {
	k2tabs_holder 		= $$('.simpleTabsNavigation');
	tabIncptvMC 		= $('tabIncptvMC');
	k2all_tabs	  	= $('k2Tabs');
	k2TabIncptvMC  		= $('k2TabIncptvMC');

	k2tabs_holder[0].grab(tabIncptvMC,'bottom');	
	k2all_tabs.grab(k2TabIncptvMC, 'bottom');
	tabIncptvMC.setStyle('visibility','visible');
	k2TabIncptvMC.setStyle('visibility','visible');

});

var $incptvK2 = jQuery.noConflict();

$incptvK2(document).ready(function(){
    var $selectedValue = $incptvK2('#catid').find(":selected").text();
    $incptvK2('#catid').change(function() {
	var $newSelectedValue = $incptvK2('#catid').find(":selected").text();
	var $newSelectedOption = $incptvK2('#pluginsincptvk2multiplecategories option:contains("' + $newSelectedValue + '")');
	$newSelectedOption.attr('disabled', 'disabled');
	$newSelectedOption.removeAttr('selected');
	var $selectedOption = $incptvK2('#pluginsincptvk2multiplecategories option:contains("' + $selectedValue + '")');
	$selectedOption.removeAttr('disabled');
	$selectedValue = $newSelectedValue;	
    });
});