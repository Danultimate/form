<?php
/**
 * @copyright  Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Form\Tests\Rule;

use Joomla\Test\TestHelper;
use Joomla\Form\Rule\Url as RuleUrl;

/**
 * Test class for Joomla\Form\Rule\Url.
 *
 * @coversDefaultClass  Joomla\Form\Rule\Url
 */
class UrlTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * Test data for testing of Joomla\Form\Rule\Url::test method.
	 *
	 * @return  array
	 */
	public function dataUrl()
	{
		// Most test urls are directly from or based on the RFCs noted in the rule.
		return
			array(
				// Failing cases
				array('Simple String', 0, 'bogus', false),
				array('Simple String', 0, '0', false),
				array('No scheme', 0, 'mydomain.com', false),
				array('No ://', 0, 'httpmydomain.com', false),
				array('Three slashes', 0, 'http:///mydomain.com', false),
				array('No : (colon)', 0, 'http//mydomain.com', false),
				array('Invalid Port-1', 0, "http://mydomain.com:\xFF", false),
				array('Invalid Port-2', 0, "http://mydomain.com:-80", false),
				array('Port only', 0, 'http://:80', false),
				array('Improper @', 0, 'http://user@:80', false),
				array('array(http with one slash', 0, 'http:/mydomain.com', false),
				array('Scheme not in options list', 1, 'http://mydomain.com', false),
				array('Invalid host', 0, "http://m\xFF ABComain.com", false),
				array('Invalid path', 0, "http://mydomain.com/foo\xFF ABCbar", false),

				// Passing cases
				array('Simple String', 0, '', true),
				array('http', 0, 'http://mydomain.com', true),
				array('Upper case scheme', 0, 'HTTP://mydomain.com', true),
				array('FTP', 0, 'ftp://ftp.is.co.za/rfc/rfc1808.txt', true),
				array('Path with slash', 0, 'http://www.ietf.org/rfc/rfc2396.txt', true),
				array('LDAP', 0, 'ldap://[2001:db8::7]/c=GB?objectClass?one', true),
				array('Mailto', 0, 'mailto:John.Doe@example.com', true),
				array('News', 0, 'news:comp.infosystems.www.servers.unix', true),
				array('Tel with +', 0, 'tel:+1-816-555-1212', true),
				array('Telnet to IP with port', 0, 'telnet://192.0.2.16:80/', true),
				array('File with no slashes', 0, 'file:document.extension', true),
				array('File with 3 slashes', 0, 'file:///document.extension', true),
				array('Only gopher allowed', 1, 'gopher://gopher.mydomain.com', true),
				array('URN', 0, 'urn:oasis:names:specification:docbook:dtd:xml:4.1.2', true),
				array('Space in path', 0, 'http://mydomain.com/Laguna%20Beach.htm', true),
				array('UTF-8 in path', 0, 'http://mydomain.com/объектов', true),
				array('Puny code in domain', 0, 'http://www.österreich.at', true),
			);
	}

	/**
	 * Test the Joomla\Form\Rule\Url::test method.
	 *
	 * @param   string   $caseDescription  @todo
	 * @param   int      $xmlfield         @todo
	 * @param   string   $url              @todo
	 * @param   boolean  $expected         @todo
	 *
	 * @covers        ::test
	 * @dataProvider  dataUrl
	 */
	public function testUrl($caseDescription, $xmlfield, $url, $expected)
	{
		$rule = new RuleUrl;

		// The field allows you to optionally limit the accepted schemes to a specific list.
		// Url1 tests without a list, Url2 tests with a list.
		$xml = simplexml_load_string('<form><field name="url1" />
		<field name="url2" schemes="gopher" /></form>');

		$this->assertEquals(
			$rule->test($xml->field[$xmlfield], $url),
			$expected,
			'Line:' . __LINE__ . ' The rule should return' . $expected . ' for ' . $caseDescription . '.'
		);
	}
}
