<?php
App::uses('Permiso', 'Model');

/**
 * Permiso Test Case
 */
class PermisoTest extends CakeTestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Permiso = ClassRegistry::init('Permiso');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Permiso);

		parent::tearDown();
	}

}
