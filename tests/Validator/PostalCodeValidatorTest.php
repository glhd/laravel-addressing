<?php

/**
 * Class PostalCodeValidatorTest
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class PostalCodeValidatorTest extends BaseValidatorTestCase
{
    public function testColoradoPostalCode()
    {
        $this->assertTrue($this->performValidation([
            'data' => ['country' => 'US', 'state' => 'CO', 'code' => '80301'],
            'rules' => ['code' => 'postal_code:country,state'],
        ]));
        $this->assertTrue($this->performValidation([
            'data' => ['country' => 'US', 'state' => 'CO', 'code' => '81000'],
            'rules' => ['code' => 'postal_code:country,state'],
        ]));
        $this->assertFalse($this->performValidation([
            'data' => ['country' => 'US', 'state' => 'CO', 'code' => '82000'],
            'rules' => ['code' => 'postal_code:country,state'],
        ]));
    }

    public function testBrazilianPostalCodes()
    {
        $this->assertTrue($this->performValidation([
            'data' => ['country' => 'BR', 'state' => 'MG', 'code' => '31170-070'],
            'rules' => ['code' => 'postal_code:country,state'],
        ]));
        $this->assertTrue($this->performValidation([
            'data' => ['country' => 'BR', 'state' => 'MG', 'code' => '31310-190'],
            'rules' => ['code' => 'postal_code:country,state'],
        ]));
        $this->assertFalse($this->performValidation([
            'data' => ['country' => 'BR', 'state' => 'MG', 'code' => '21000-070'],
            'rules' => ['code' => 'postal_code:country,state'],
        ]));
    }

	public function testUsesDefaultFieldNames()
	{
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'administrative_area' => 'CO', 'code' => '80301'],
			'rules' => ['code' => 'postal_code'],
		]));
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'CO', 'code' => '80301'],
			'rules' => ['code' => 'postal_code'],
		]));
	}

    public function testUsesCountryRegExIfNoAdminArea()
    {
        $this->assertTrue($this->performValidation([
            'data' => ['country' => 'GB', 'administrative_area' => '', 'code' => 'NW4 2HX'],
            'rules' => ['code' => 'postal_code'],
        ]));
        $this->assertFalse($this->performValidation([
            'data' => ['country' => 'GB', 'administrative_area' => '', 'code' => '1234567890'],
            'rules' => ['code' => 'postal_code'],
        ]));
    }
}
