<?php
/**
 * @package		Inceptive Multiple Categories for K2
 * @author		Inceptive Design Labs - http://www.inceptive.gr
 * @copyright	Copyright (c) 2014 Inceptive Design Labs. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// No Direct Access
defined( '_JEXEC' ) or die;

// Script
class plgK2IncptvK2MultipleCategoriesInstallerScript
{
	/**
	 * Called on installation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	function install( $parent )
	{
	}
	
	/**
	 * Called on uninstallation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 */
	function uninstall( $parent )
	{
		$db = JFactory::getDBO();
        $status = new stdClass;
        $status->modules = array();
        $status->plugins = array();
        $manifest = $parent->getParent()->manifest;
        $plugins = $manifest->xpath('plugins/plugin');
        foreach ($plugins as $plugin)
        {
            $name = (string)$plugin->attributes()->plugin;
            $group = (string)$plugin->attributes()->group;
            $query = "SELECT `extension_id` FROM #__extensions WHERE `type`='plugin' AND element = ".$db->Quote($name)." AND folder = ".$db->Quote($group);
            $db->setQuery($query);
            $extensions = $db->loadColumn();
            if (count($extensions))
            {
                foreach ($extensions as $id)
                {
                    $installer = new JInstaller;
                    $result = $installer->uninstall('plugin', $id);
                }
                $status->plugins[] = array('name' => $name, 'group' => $group, 'result' => $result);
            }
            
        }
        $this->uninstallationResults($status);

	}
	
	/**
	 * Called on update
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	function update( $parent )
	{		
	}
	
	/**
	 * Called before any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	function preflight( $type, $parent )
	{
	}
	
	/**
	 * Called after any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	 */
	function postflight( $type, $parent )
	{
		$app	=	JFactory::getApplication();
		$db		=	JFactory::getDBO();
		
		$db->setQuery( 'UPDATE #__extensions SET enabled = 1 WHERE folder="k2" AND element = "incptvk2multiplecategories"' );
		$db->execute();
		
		$status = new stdClass;
        $status->plugins = array();
        $src = $parent->getParent()->getPath('source');
        $manifest = $parent->getParent()->manifest;
        $plugins = $manifest->xpath('plugins/plugin');
        foreach ($plugins as $plugin)
        {
            $name = (string)$plugin->attributes()->plugin;
            $group = (string)$plugin->attributes()->group;
            $path = $src.'/plugins/'.$group;
            if (JFolder::exists($src.'/plugins/'.$group.'/'.$name))
            {
                $path = $src.'/plugins/'.$group.'/'.$name;
            }
            $installer = new JInstaller;
            $result = $installer->install($path);
            if ($result && $group != 'finder' && $group != 'system')
            {
                if (JFile::exists(JPATH_SITE.'/plugins/'.$group.'/'.$name.'/'.$name.'.xml'))
                {
                    JFile::delete(JPATH_SITE.'/plugins/'.$group.'/'.$name.'/'.$name.'.xml');
                }
                JFile::move(JPATH_SITE.'/plugins/'.$group.'/'.$name.'/'.$name.'.j25.xml', JPATH_SITE.'/plugins/'.$group.'/'.$name.'/'.$name.'.xml');
            }
            $query = "UPDATE #__extensions SET enabled=1 WHERE type='plugin' AND element=".$db->Quote($name)." AND folder=".$db->Quote($group);
            $db->setQuery($query);
            $db->query();
            $status->plugins[] = array('name' => $name, 'group' => $group, 'result' => $result);
		}
		//echo "<p>Installed</p>";
		$this->installationResults($status);
	}
	
	private function installationResults($status)
    {
		$language = JFactory::getLanguage();
		$languagePath = JPATH_PLUGINS.DS.'k2'.DS.'incptvk2multiplecategories';
        $language->load("plg_k2_incptvk2multiplecategories", $languagePath, null, false);
        $rows = 0; ?>
        <img src="<?php echo JURI::root(true); ?>/plugins/k2/incptvk2multiplecategories/media/incptvk2multiplecategories173x48.jpg" alt="Inceptive Multiple Categories for K2" align="right" />
        <h2><?php echo JText::_('PLG_K2_MC_INSTALLATION_STATUS'); ?></h2>
        <table class="adminlist table table-striped">
            <thead>
                <tr>
                    <th class="title" colspan="2"><?php echo JText::_('PLG_K2_MC_EXTENSION'); ?></th>
                    <th width="30%"><?php echo JText::_('PLG_K2_MC_STATUS'); ?></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="3"></td>
                </tr>
            </tfoot>
            <tbody>
				<tr>
                    <th><?php echo JText::_('PLG_K2_MC_PLUGIN'); ?></th>
                    <th><?php echo JText::_('PLG_K2_MC_GROUP'); ?></th>
                    <th></th>
                </tr>
				<tr class="row0">
                    <td class="key"><?php echo JText::_('PLG_K2_MC'); ?></td>
					<td class="key">K2</td>
                    <td><strong><?php echo JText::_('PLG_K2_MC_INSTALLED'); ?></strong></td>
                </tr>
                <?php if (count($status->plugins)): ?>
                <!-- <tr>
                    <th><?php echo JText::_('PLG_K2_MC_PLUGIN'); ?></th>
                    <th><?php echo JText::_('PLG_K2_MC_GROUP'); ?></th>
                    <th></th>
                </tr> -->
                <?php foreach ($status->plugins as $plugin): ?>
                <tr class="row<?php echo(++$rows % 2); ?>">
                    <td class="key"><?php echo ucfirst($plugin['name']); ?></td>
                    <td class="key"><?php echo ucfirst($plugin['group']); ?></td>
                    <td><strong><?php echo ($plugin['result'])?JText::_('PLG_K2_MC_INSTALLED'):JText::_('PLG_K2_MC_NOT_INSTALLED'); ?></strong></td>
                </tr>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    <?php
	}
	
	private function uninstallationResults($status)
    {
		$language = JFactory::getLanguage();
		$languagePath = JPATH_PLUGINS.DS.'k2'.DS.'incptvk2multiplecategories';
        $language->load("plg_k2_incptvk2multiplecategories", $languagePath, null, false);
		$rows = 0;
	 ?>
			<h2><?php echo JText::_('PLG_K2_MC_REMOVAL_STATUS'); ?></h2>
			<table class="adminlist table table-striped">
				<thead>
					<tr>
						<th class="title" colspan="2"><?php echo JText::_('PLG_K2_MC_EXTENSION'); ?></th>
						<th width="30%"><?php echo JText::_('PLG_K2_MC_STATUS'); ?></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="3"></td>
					</tr>
				</tfoot>
				<tbody>
					<tr>
						<th><?php echo JText::_('PLG_K2_MC_PLUGIN'); ?></th>
						<th><?php echo JText::_('PLG_K2_MC_GROUP'); ?></th>
						<th></th>
					</tr>
					<tr class="row0">
						<td class="key"><?php echo JText::_('PLG_K2_MC'); ?></td>
						<td class="key">K2</td>
						<td><strong><?php echo JText::_('PLG_K2_MC_REMOVED'); ?></strong></td>
					</tr>
					<?php if (count($status->plugins)): ?>
					<!-- <tr>
						<th><?php echo JText::_('PLG_K2_MC_PLUGIN'); ?></th>
						<th><?php echo JText::_('PLG_K2_MC_GROUP'); ?></th>
						<th></th>
					</tr> -->
					<?php foreach ($status->plugins as $plugin): ?>
					<tr class="row<?php echo(++$rows % 2); ?>">
						<td class="key"><?php echo ucfirst($plugin['name']); ?></td>
						<td class="key"><?php echo ucfirst($plugin['group']); ?></td>
						<td><strong><?php echo ($plugin['result'])?JText::_('PLG_K2_MC_REMOVED'):JText::_('PLG_K2_MC_NOT_REMOVED'); ?></strong></td>
					</tr>
					<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		<?php
    }

	
}
?>