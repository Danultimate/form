<?php
/**
 * @copyright  Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Form\Tests;

use Joomla\Form\Rule\Color as RuleColor;
use SimpleXmlElement;

/**
 * Test class for Joolma Framework Form rule Color.
 *
 * @coversDefaultClass Joomla\Form\Rule\Color
 * @since  1.0
 */
class JFormRuleColorTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Test data for testing of Joomla\Form\Rule\Color::test method.
	 *
	 * @return array
	 *
	 * @since __VERSION_NO__
	 */
	public function dataColor()
	{
		return array(
			// Test fail conditions.
			array('#', false),
			array('#GGG', false),
			array('#GGGGGG', false),
			array('bogus', false),
			array('FFFFFF', false),
			array('#FFFFFFF', false),

			// Test pass conditions.
			array('#000', true),
			array('#000000', true),
			array('#A0A0A0', true),
			array('#EEE', true),
			array('#FFFFFF', true),
			array('', true)
		);
	}

	/**
	 * Test the Joomla\Form\Rule\Color::test method.
	 *
	 * @param   string   $color           @todo
	 * @param   boolean  $expectedOutput  @todo
	 *
	 * @return       void
	 *
	 * @covers        ::test
	 * @dataProvider  dataColor
	 * @since         __VERSION_NO__
	 */
	public function testColor($color, $expectedOutput)
	{
		$rule = new RuleColor;
		$xml = new SimpleXmlElement('<field name="color" />');
		$this->assertThat(
			$rule->test($xml, $color),
			$this->equalTo($expectedOutput),
			'Line:' . __LINE__ . ' ' . $color . ' should have returned '
				. ($expectedOutput ? 'true' : 'false') . ' but did not.'
		);
	}
}
