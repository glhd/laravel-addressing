<?php

/**
 * Class AdministrativeAreaValidatorTest
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class AdministrativeAreaValidatorTest extends BaseValidatorTestCase
{
    public function testMGStateInBrazil()
    {
        $this->assertTrue($this->performValidation([
            'rules' => ['state' => 'administrative_area_code:country'],
            'data' => ['state' => 'MG', 'country' => 'BR'],
        ]));
    }

    public function testInvalidStateInBrazil()
    {
        $this->assertFalse($this->performValidation([
            'data' => ['country' => 'BR', 'state' => 'ZZ'],
            'rules' => ['state' => 'administrative_area_code:country'],
        ]));
    }

    public function testCOStateInUnitedStates()
    {
        $this->assertTrue($this->performValidation([
            'data' => ['country' => 'US', 'state' => 'CO'],
            'rules' => ['state' => 'administrative_area_code:country'],
        ]));
    }
	
	public function testCountryAndStateAreLowerCase()
	{
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'us', 'state' => 'co'],
			'rules' => ['state' => 'administrative_area_code:country'],
		]));
	}

    public function testUSStateByName()
    {
        // Valid state in US
        $this->assertTrue($this->performValidation([
            'data' => ['country' => 'US', 'state' => 'Alabama'],
            'rules' => ['state' => 'administrative_area:country'],
        ]));
        // Invalid state name in US
        $this->assertFalse($this->performValidation([
            'data' => ['country' => 'US', 'state' => 'Allabama'],
            'rules' => ['state' => 'administrative_area:country'],
        ]));
    }

    public function testStateUsingCountryName()
    {
        // Valid US state
        $this->assertTrue($this->performValidation([
            'data' => ['country' => 'United States', 'state' => 'Colorado'],
            'rules' => ['state' => 'administrative_area:country'],
        ]));
        // Invalid US state with wrong name
        $this->assertFalse($this->performValidation([
            'data' => ['country' => 'United States', 'state' => 'Collorado'],
            'rules' => ['state' => 'administrative_area:country'],
        ]));
    }

    public function testGeneralAdministrativeAreaValidation()
    {
        // Valid US state
        $this->assertTrue($this->performValidation([
            'data' => ['country' => 'US', 'state' => 'AL'],
            'rules' => ['state' => 'administrative_area:country'],
        ]));
        // Invalid US state
        $this->assertFalse($this->performValidation([
            'data' => ['country' => 'US', 'state' => 'ZZ'],
            'rules' => ['state' => 'administrative_area:country'],
        ]));
        // Valid US state using its name
        $this->assertTrue($this->performValidation([
            'data' => ['country' => 'US', 'state' => 'Alabama'],
            'rules' => ['state' => 'administrative_area:country'],
        ]));
        // Invalid US state using its name
        $this->assertFalse($this->performValidation([
            'data' => ['country' => 'US', 'state' => 'Allabama'],
            'rules' => ['state' => 'administrative_area:country'],
        ]));
    }
	
	public function testUsesDefaultFieldNames()
	{
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'CO'],
			'rules' => ['state' => 'administrative_area_code'],
		]));
		
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'Colorado'],
			'rules' => ['state' => 'administrative_area_name'],
		]));
		
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'CO'],
			'rules' => ['state' => 'administrative_area'],
		]));
		
		$this->assertTrue($this->performValidation([
			'data' => ['country' => 'US', 'state' => 'Colorado'],
			'rules' => ['state' => 'administrative_area'],
		]));
	}
}
