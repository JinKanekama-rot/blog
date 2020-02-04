<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		
		echo $this->Html->css('bootstrap.min.css');
		echo $this->Html->script('jquery-3.4.1.min.js');
		echo $this->Html->script('bootstrap.min.js');
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<nav class="navbar navbar-expand-sm navbar-dark bg-primary">
				<ul class="navbar-nav">
					<li class="nav-item">
						<?php echo $this->Html->link('Home', array('controller' => 'posts', 'action' => 'index', ), array('class' => 'nav-link')); ?>
					</li>
					<li class="nav-item">
						<?php echo $this->Html->link('Add Post', array('controller' => 'posts', 'action' => 'add', ), array('class' => 'nav-link')); ?>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">about</a>
					</li>    
					<li class="nav-item">
						<?php echo $this->Html->link('管理画面', array('controller' => 'imports', 'action' => 'index', ), array('class' => 'nav-link')); ?>
					</li> 
					<li class="nav-item">
						<?php echo $this->Html->link('ログアウト', array('controller' => 'users', 'action' => 'logout', ), array('class' => 'nav-link')); ?>
					</li> 
				</ul>
			</nav>
		</div>
		<div id="content">

			<?php echo $this->Flash->render(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'https://cakephp.org/',
					array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
				);
			?>
			<p>
				<?php echo $cakeVersion; ?>
			</p>
		</div>
	</div>
</body>
</html>
