<?php
/**
 * @category   Z
 * @package    Z_Validate
 * @copyright  This work is licenced under a Freedom licence
 * @license    http://freedom.org/license/1.0/us/
 */

require_once 'Zend/Validate/Abstract.php';

/**
 * @uses       Z_Validate_IdenticalField
 * @package    Z_Validate
 * @author     Sean P. O. MacCath-Moran
 * @email      zendcode@emanaton.com
 * @website    http://www.emanaton.com
 * @copyright  This work is licenced under a Attribution Non-commercial Share Alike Creative Commons licence
 * @license    http://creativecommons.org/licenses/by-nc-sa/3.0/us/
 */

class Z_Validate_IdenticalField extends Zend_Validate_Abstract {

	const NOT_MATCH = 'fieldNotMatch';

	/**
	 * @var array
	 */
	protected $_messageTemplates = array(
	self::NOT_MATCH =>
	'Does not match against %fieldLabel%.'
	);

	/**
	 * @var array
	 */
	protected $_messageVariables = array(
	'fieldLabel' => '_fieldLabel'
	);

	/**
	 * Title of the field to display in an error message.
	 *
	 * @var string
	 */
	protected $_fieldLabel;

	/**
	 * The form element to compare.
	 *
	 * @var Zend_Form_Element
	 */
	protected $_field;

	/**
	 * Sets validator options
	 *
	 * @param  string $fieldName
	 * @param  string $fieldTitle
	 * @return void
	 */
	public function __construct($field) {

		if ($field instanceof Zend_Form_Element) {
			$this->_field = $field;
			$this->_fieldLabel = $this->_field->getLabel();
		} else {
			require_once 'Zend/Validate/Exception.php';
			throw new Zend_Validate_Exception('The field to compare must be an Zend_Form_Element');
		}
	}

	/**
	 * Returns the fieldname.
	 *
	 * @return integer
	 */
	public function getFieldName() {
		return $this->_field->getId();
	}

	/**
	 * Defined by Zend_Validate_Interface
	 *
	 * Returns true if and only if a field name has been set, the field name is available in the
	 * context, and the value of that field name matches the provided value.
	 *
	 * @param  string $value
	 *
	 * @return boolean
	 */
	public function isValid($value, $context = null) {

		$this->_setValue($value);

		if (is_array($context))
			$context = $context[$this->getFieldName()];

		$this->_field->setValue($context);
		if ($value == $this->_field->getValue()) {
			return true;
		}

		$this->_error(self::NOT_MATCH);
		return false;
	}
}
