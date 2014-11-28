<?php
/**
 * @copyright  Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Form\Tests;

use Joomla\Form\Field\SpacerField;
use SimpleXmlElement;

/**
 * Test class for JForm.
 *
 * @coversDefaultClass Joomla\Form\Field\SpacerField
 * @since  1.0
 */
class JFormFieldSpacerTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Test the getInput method.
	 *
	 * @return void
	 *
	 * @covers  ::getInput
	 * @since   __VERSION_NO__
	 */
	public function testGetInput()
	{
		$field = new SpacerField;

		$xml = new SimpleXmlElement('<field name="spacer" type="spacer" />');
		$this->assertTrue(
			$field->setup($xml, 'aValue'),
			'Line:' . __LINE__ . ' The setup method should return true.'
		);

		$this->assertRegExp(
			'/[\s]+/',
			$field->input,
			'Line:' . __LINE__ . ' The getInput method should return only and atleast one space character.'
		);
	}

	/**
	 * Test data for getLabel test
	 *
	 * @return  array
	 *
	 * @since __VERSION_NO__
	 */
	public function dataGetLabel()
	{
		return array(
			array(
				'<field name="spacer" type="spacer" description="spacer" />',
				'<span class=""><label id="spacer-lbl" class="hasTip" title="spacer::spacer">spacer</label></span>'
			),
			array(
				'<field name="spacer" type="spacer" class="text" />',
				'<span class="text"><label id="spacer-lbl" class="">spacer</label></span>'
			),
			array(
				'<field name="spacer" type="spacer" class="text" label="MyLabel" />',
				'<span class="text"><label id="spacer-lbl" class="">MyLabel</label></span>'
			),
			array(
				'<field name="spacer" type="spacer" hr="true" />',
				'<span class=""><hr class="" /></span>'
			),
		);
	}

	/**
	 * Test the getLabel method.
	 *
	 * @param   string  $xml             @todo
	 * @param   string  $expectedOutput  @todo
	 *
	 * @return void
	 *
	 * @covers        ::getTitle
	 * @covers        ::getLabel
	 * @dataProvider  dataGetLabel
	 * @since         __VERSION_NO__
	 */
	public function testGetLabel($xml, $expectedOutput)
	{
		$field = new SpacerField;

		$xml = new SimpleXMLElement($xml);
		$this->assertTrue(
			$field->setup($xml, 'aValue'),
			'Line:' . __LINE__ . ' The setup method should return true.'
		);

		$expectedOutput = '<span class="spacer"><span class="before"></span>'
			. $expectedOutput . '<span class="after"></span></span>';

		$this->assertEquals(
			$expectedOutput,
			$field->label,
			'Line:' . __LINE__ . ' The getLabel method should match expected ouput.'
		);

		$this->assertEquals(
			$expectedOutput,
			$field->title,
			'Line:' . __LINE__ . ' The getLabel method should match expected ouput.'
		);
	}
}
