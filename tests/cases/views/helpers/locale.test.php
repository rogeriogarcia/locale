<?php
/**
 * Testes do Helper Locale
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @author        Cauan Cabral <cauan@radig.com.br>, José Agripino <jose@radig.com.br>
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */

App::import('Helper', 'Locale.Locale');

class LocaleCase extends CakeTestCase
{
	public $Locale = null;

	/**
	 * setUp
	 *
	 * @retun void
	 * @access public
	 */
	public function startCase()
	{
		parent::startCase();

		Configure::write('Config.language', 'pt-br');
		setlocale(LC_ALL, 'pt_BR.utf-8', 'pt_BR', 'pt-br', 'pt_BR.iso-8859-1');

		$this->Locale = new LocaleHelper();
	}

	/**
	 * testDate
	 *
	 * @retun void
	 * @access public
	 */
	public function testDate()
	{
		$this->assertEqual($this->Locale->date(), date('d/m/Y'));
		$this->assertEqual($this->Locale->date('2009-04-21'), '21/04/2009');
		$this->assertEqual($this->Locale->date('invalido'), date('d/m/Y'));
	}

	/**
	 * testDateTime
	 *
	 * @retun void
	 * @access public
	 */
	public function testDateTime()
	{
		$this->assertEqual($this->Locale->dateTime('2010-08-26 16:12:40'), '26/08/2010 16:12:40');
		$this->assertEqual($this->Locale->dateTime('2010-08-26 16:12:40', false), '26/08/2010 16:12');
	}

	/**
	 * testDateLiteral
	 *
	 * @retun void
	 * @access public
	 */
	public function testDateLiteral()
	{
		$this->assertEqual($this->Locale->dateLiteral('2010-08-26 16:12:40'), 'quinta, 26 de agosto de 2010');
		$this->assertEqual($this->Locale->dateLiteral('2010-08-26 16:12:40', true), 'quinta, 26 de agosto de 2010, 16:12:40');
	}

	public function testCurrency()
	{
		$this->assertEqual($this->Locale->currency('12.45'), 'R$ 12,45');

		$this->assertEqual($this->Locale->currency('-'), '');
	}

	public function testNumber()
	{
		$this->assertEqual($this->Locale->number('12.45'), '12,45');

		$this->assertEqual($this->Locale->number('12.82319', 4), '12,8231');

		$this->assertEqual($this->Locale->number('350020.123', 4, true), '350020,123');

		$this->assertEqual($this->Locale->number('-'), 0);
	}

	/**
	 * testLocaleWithParameter
	 *
	 * @retun void
	 * @access public
	 */
	public function testLocaleWithParameter()
	{
		$this->Locale = new LocaleHelper(array('locale' => 'br', 'numbers' => array('decimal_point' => '!')));

		$this->assertEqual($this->Locale->date(), date('d/m/Y'));
		$this->assertEqual($this->Locale->date('2009-04-21'), '21/04/2009');
		$this->assertEqual($this->Locale->dateTime('2010-08-26 16:12:40'), '26/08/2010 16:12:40');
		$this->assertEqual($this->Locale->dateTime('2010-08-26 16:12:40', false), '26/08/2010 16:12');
		$this->assertEqual($this->Locale->dateLiteral('2010-08-26 16:12:40'), 'quinta, 26 de agosto de 2010');
		$this->assertEqual($this->Locale->dateLiteral('2010-08-26 16:12:40', true), 'quinta, 26 de agosto de 2010, 16:12:40');

		$this->assertEqual($this->Locale->number('12.53'), '12!53');
	}
}