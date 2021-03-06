<?php
App::uses('AppController', 'Controller');
/**
 * Labels Controller
 *
 * @property Label $Label
 */
class LabelsController extends AppController {

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('*');
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Label->recursive = 0;
        $labels = $this->paginate();
        
        $Favorite = ClassRegistry::init('Favorites.favorite');
        $userFavorites = $Favorite->getAllFavorites( $this->Auth->user('id') );        
		$this->set(compact('labels', 'userFavorites'));
	}
    
    public function favorites() {
        $this->Label->recursive = 0;
        
        $Favorite = ClassRegistry::init('Favorites.favorite');
        $userFavorites = $Favorite->getAllFavorites( $this->Auth->user('id') );   
        $conditions = array('Label.id' => array_values($userFavorites['follow']));
        $labels = $this->paginate($conditions);
        
		$this->set(compact('labels', 'userFavorites'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Label->exists($id)) {
			throw new NotFoundException(__('Invalid label'));
		}
		$options = array('conditions' => array('Label.' . $this->Label->primaryKey => $id));
		$this->set('label', $this->Label->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Label->create();
			if ($this->Label->save($this->request->data)) {
				$this->Session->setFlash(__('The label has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The label could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Label->exists($id)) {
			throw new NotFoundException(__('Invalid label'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Label->save($this->request->data)) {
				$this->Session->setFlash(__('The label has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The label could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Label.' . $this->Label->primaryKey => $id));
			$this->request->data = $this->Label->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @throws MethodNotAllowedException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Label->id = $id;
		if (!$this->Label->exists()) {
			throw new NotFoundException(__('Invalid label'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Label->delete()) {
			$this->Session->setFlash(__('Label deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Label was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
