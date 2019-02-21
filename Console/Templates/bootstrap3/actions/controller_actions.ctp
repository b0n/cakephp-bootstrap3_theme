<?php
/**
 * Bake Template for Controller action generation.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.actions
 * @since         CakePHP(tm) v 1.3
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>

/**
 * Components
 *
 * @var array
 */
	public $components = array(
        'Paginator',
        'Session',
        'Flash' => array('plugin' => 'BoostCake', 'element' => 'alert'),
    );

/**
 * Helpers
 *
 * @var array
 */
    public $helpers = array(
        'Session',
        'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
        'Form' => array('className' => 'BoostCake.BoostCakeForm'),
        'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
    );

/**
 * <?php echo $admin ?>index method
 *
 * @return void
 */
	public function <?php echo $admin ?>index() {
        $this->layout = 'bootstrap3';
		$this-><?php echo $currentModelName ?>->recursive = 0;
		$this->set('<?php echo $pluralName ?>', $this->Paginator->paginate());
	}

/**
 * <?php echo $admin ?>view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function <?php echo $admin ?>view($id = null) {
        $this->layout = 'bootstrap3';
		if (!$this-><?php echo $currentModelName; ?>->exists($id)) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
		$options = array('conditions' => array('<?php echo $currentModelName; ?>.' . $this-><?php echo $currentModelName; ?>->primaryKey => $id));
		$this->set('<?php echo $singularName; ?>', $this-><?php echo $currentModelName; ?>->find('first', $options));
	}

<?php $compact = array(); ?>
<?php if ($wannaUseSession): ?>
/**
 * <?php echo $admin ?>add method
 *
 * @return CakeResponse|void|null
 * @throws Exception
 */
<?php else: ?>
/**
 * <?php echo $admin ?>add method
 *
 * @return void
 */
<?php endif; ?>
	public function <?php echo $admin ?>add() {
        $this->layout = 'bootstrap3';
        $this->view = 'admin_form';
        if ($this->request->is('get')) {
            return;
        }
		if ($this->request->is('post')) {
            $this-><?php echo $currentModelName; ?>->set($this->request->data);
            if ($this-><?php echo $currentModelName; ?>->validates()) {
                if ($this->request->data('back')) {
                    ;
                } elseif ($this->request->data('conf')) {
                    $this->view = 'admin_conf';
                } elseif ($this->request->data('submit')) {
                    $this-><?php echo $currentModelName; ?>->create();
                    if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($wannaUseSession): ?>
                        $this->Flash->set(__('The <?php echo strtolower($singularHumanName); ?> has been saved.'), [
                            'params' => ['class' => 'alert-success']]);
                        return $this->redirect(array('action' => 'index'));
                    } else {
                        $this->Flash->set(__('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.'), [
                            'params' => ['class' => 'alert-danger']]);
<?php else: ?>
                        return $this->flash(__('The <?php echo strtolower($singularHumanName); ?> has been saved.'), array('action' => 'index'));
<?php endif; ?>
                    }
                }
            }
		}
<?php
	foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
		foreach ($modelObj->{$assoc} as $associationName => $relation):
			if (!empty($associationName)):
				$otherModelName = $this->_modelName($associationName);
				$otherPluralName = $this->_pluralName($associationName);
				echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
				$compact[] = "'{$otherPluralName}'";
			endif;
		endforeach;
	endforeach;
	if (!empty($compact)):
		echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
	endif;
?>
	}

<?php $compact = array(); ?>
/**
 * <?php echo $admin ?>edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function <?php echo $admin; ?>edit($id = null) {
        $this->layout = 'bootstrap3';
        $this->view = 'admin_form';
		if (!$this-><?php echo $currentModelName; ?>->exists($id)) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
        if ($this->request->is('get')) {
            $options = array('conditions' => array('<?php echo $currentModelName; ?>.' . $this-><?php echo $currentModelName; ?>->primaryKey => $id));
            $this->request->data = $this-><?php echo $currentModelName; ?>->find('first', $options);
        }
        if ($this->request->is(array('post', 'put'))) {
			$this-><?php echo $currentModelName; ?>->set($this->request->data);
            if ($this-><?php echo $currentModelName; ?>->validates()) {
                if ($this->request->data('back')) {
                    ;
                } elseif ($this->request->data('conf')) {
                    $this->view = 'admin_conf';
                } elseif ($this->request->data('submit')) {
                    if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
<?php if ($wannaUseSession): ?>
                        $this->Flash->set(__('The <?php echo strtolower($singularHumanName); ?> has been saved.'), [
                            'params' => ['class' => 'alert-success']]);
                        return $this->redirect(array('action' => 'index'));
                    } else {
                        $this->Flash->set(__('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.'), [
                            'params' => ['class' => 'alert-danger']]);
<?php else: ?>
                        return $this->flash(__('The <?php echo strtolower($singularHumanName); ?> has been saved.'), array('action' => 'index'));
<?php endif; ?>
                    }
                }
            }
        }
<?php
		foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
			foreach ($modelObj->{$assoc} as $associationName => $relation):
				if (!empty($associationName)):
					$otherModelName = $this->_modelName($associationName);
					$otherPluralName = $this->_pluralName($associationName);
					echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
					$compact[] = "'{$otherPluralName}'";
				endif;
			endforeach;
		endforeach;
		if (!empty($compact)):
			echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
		endif;
	?>
	}

/**
 * <?php echo $admin ?>delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function <?php echo $admin; ?>delete($id = null) {
		if (!$this-><?php echo $currentModelName; ?>->exists($id)) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this-><?php echo $currentModelName; ?>->delete($id)) {
<?php if ($wannaUseSession): ?>
            $this->Flash->set(__('The <?php echo strtolower($singularHumanName); ?> has been deleted.'), [
                'params' => ['class' => 'alert-success']]);
		} else {
            $this->Flash->set(__('The <?php echo strtolower($singularHumanName); ?> could not be deleted. Please, try again.'), [
                'params' => ['class' => 'alert-danger']]);
		}
		return $this->redirect(array('action' => 'index'));
<?php else: ?>
			return $this->flash(__('The <?php echo strtolower($singularHumanName); ?> has been deleted.'), array('action' => 'index'));
		} else {
			return $this->flash(__('The <?php echo strtolower($singularHumanName); ?> could not be deleted. Please, try again.'), array('action' => 'index'));
		}
<?php endif; ?>
	}
