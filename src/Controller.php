<?php

namespace Galahad\LaravelAddressing;

use Exception;
use Galahad\LaravelAddressing\Entity\Country;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 *
 * @package Galahad\LaravelAddressing
 * @author Chris Morrell
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class Controller extends BaseController
{
    /**
     * @var LaravelAddressing
     */
    protected $addressing;

    /**
     * The construct method
     */
    public function __construct()
    {
        $this->addressing = new LaravelAddressing();
    }

    /**
     * Get a json with all the administrative areas by a given country code
     *
     * @param string $countryCode
     * @param Request $request
     */
    public function getAdministrativeAreas(Request $request, $countryCode)
	{
        $this->checkQueryParameters($request);
        $country = $this->addressing->getCountryByCode($countryCode);
        if ($country instanceof Country) {
            $admAreas = $country->getAdministrativeAreas();
            echo json_encode([
                'label' => 'State',
                'expected_length' => 2,
                'country' => $countryCode,
                'options' => $admAreas->toList(),
                'status' => 200,
            ]);
        } else {
            echo json_encode([
                'error' => true,
                'status' => 404,
                'message' => "Country not found [$countryCode]",
            ]);
        }
	}

    /**
     * Validate if is a AJAX request
     *
     * @param Request $request
     * @throws Exception
     */
    public function validateAjaxRequest(Request $request)
	{
        if (! $request->isXmlHttpRequest()) {
            throw new Exception('This URL only accepts AJAX requests');
        }
	}

    /**
     * Parse some query parameters from the request
     *
     * @param Request $request
     */
    protected function checkQueryParameters(Request $request)
	{
        $locale = $request->get('locale', 'en');
        $this->addressing->setLocale($locale);
	}
}
