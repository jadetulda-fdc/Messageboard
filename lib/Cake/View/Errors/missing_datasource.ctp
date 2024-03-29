<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright	 Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link		  https://cakephp.org CakePHP(tm) Project
 * @package	   Cake.View.Errors
 * @since		 CakePHP(tm) v 2.0
 * @license	   https://opensource.org/licenses/mit-license.php MIT License
 */

$pluginDot = empty($plugin) ? null : $plugin . '.';
?>
<h2><?php echo __d('cake_dev', 'Missing Datasource'); ?></h2>
<p class="error">
	<strong><?php echo __d('cake_dev', 'Error'); ?>: </strong>
	<?php echo __d('cake_dev', 'Datasource class %s could not be found.', '<em>' . h($pluginDot . $class) . '</em>'); ?>
	<?php if (isset($message)) : ?>
		<?php echo h($message); ?>
	<?php endif; ?>
</p>
<p class="notice">
	<strong><?php echo __d('cake_dev', 'Notice'); ?>: </strong>
	<?php echo __d('cake_dev', 'If you want to customize this error message, create %s', APP_DIR . DS . 'View' . DS . 'Errors' . DS . 'missing_datasource.ctp'); ?>
</p>

<?php
echo $this->element('exception_stack_trace');
?>