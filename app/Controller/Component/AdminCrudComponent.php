<?php

/**
 * create, read, update and delete (CRUD)
 */

class AdminCrudComponent extends AuthComponent {

/**
 * add method
 *
 * @return void
 */
	public function adminAdd() {
		if ($this->controller->request->is('post')) {
			$this->controller->{$this->controller->defaultModel}->create();
			if ($this->controller->{$this->controller->defaultModel}->save($this->controller->request->data)) {
				$this->controller->Session->setFlash(__(sprintf('The %s has been saved.', strtolower($this->controller->defaultModel))));
				$this->controller->redirect(array('action' => 'index'));
			} else {
				$this->controller->Session->setFlash(__(sprintf('The %s could not be saved. Please, try again.', strtolower($this->controller->defaultModel))));
			}
		}
	}

/**
 * index method
 *
 * @return void
 */
	public function adminIndex() {
		$this->controller->recursive = 0;
		$this->controller->set('list', Sanitize::clean($this->controller->paginate()));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function adminEdit($id = null) {
		$this->controller->{$this->controller->defaultModel}->id = $id;
		if (!$this->controller->{$this->controller->defaultModel}->exists()) {
			throw new NotFoundException(__(sprintf('Invalid %s', strtolower($this->controller->defaultModel))));
		}
		if ($this->controller->request->is('post') || $this->controller->request->is('put')) {
			if ($this->controller->{$this->controller->defaultModel}->save($this->controller->request->data)) {
				$this->controller->Session->setFlash(__(sprintf('The %s has been saved', strtolower($this->controller->defaultModel))));
				$this->controller->redirect(array('action' => 'index'));
			} else {
				$this->controller->Session->setFlash(__(sprintf('The %s could not be saved. Please, try again.', strtolower($this->controller->defaultModel))));
			}
		} else {
			$this->controller->request->data = Sanitize::clean($this->controller->{$this->controller->defaultModel}->read(null, $id));
		}
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 */
	public function adminDelete($id = null) {
		if (!$this->controller->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->controller->{$this->controller->defaultModel}->id = $id;
		if (!$this->controller->{$this->controller->defaultModel}->exists()) {
			throw new NotFoundException(__(sprintf('Invalid %s', strtolower($this->controller->defaultModel))));
		}
		if ($this->controller->{$this->controller->defaultModel}->delete()) {
			$this->controller->Session->setFlash(__(sprintf('%s deleted', $this->controller->defaultModel)));
			$this->controller->redirect(array('action' => 'index'));
		}
		$this->controller->Session->setFlash(__(sprintf('%s was not deleted', $this->controller->defaultModel)));
		$this->controller->redirect(array('action' => 'index'));
	}

	public $controller;

	public function initialize(&$controller) {
		$this->controller = &$controller;
	}

	public function startup(&$controller) {
		$this->controller = &$controller;
	}
}