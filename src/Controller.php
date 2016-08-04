<?php

namespace Galahad\LaravelAddressing;

use Exception;
use Galahad\LaravelAddressing\Collection\CountryCollection;
use Galahad\LaravelAddressing\Collection\LocalityCollection;
use Galahad\LaravelAddressing\Entity\AdministrativeArea;
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
     * Get all countries as JSON list
     *
     * @param Request $request
     */
    public function getCountries(Request $request)
    {
        $this->checkQueryParameters($request);
        $countries = $this->addressing->getCountries();
        if ($countries instanceof CountryCollection) {
            echo json_encode([
                'label' => 'Countries',
                'status' => 200,
                'options' => $countries->toList(),
            ]);
        } else {
            echo json_encode([
                'error' => true,
                'status' => 500,
                'message' => "Could not get countries",
            ]);
        }
    }

    /**
     * Get cities from a given country and administrative area
     *
     * @param Request $request
     * @param string $countryCode
     * @param string $admAreaCode
     */
    public function getCities(Request $request, $countryCode, $admAreaCode)
    {
        $this->checkQueryParameters($request);
        $message = 'Something is wrong';
        $country = $this->addressing->getCountryByCode($countryCode);
        if ($country instanceof Country) {
            $admArea = $country->getAdministrativeAreas()->getByCode($admAreaCode);
            if ($admArea instanceof AdministrativeArea) {
                $cities = $admArea->getLocalities();
                if ($cities instanceof LocalityCollection) {
                    echo json_encode([
                        'label' => 'Cities',
                        'status' => 200,
                        'country_code' => $countryCode,
                        'administrative_area_code' => $admAreaCode,
                        'options' => $cities->toList(),
                    ]);
                    return;
                } else {
                    $message = 'We could not get cities from the given country and administrative area';
                }
            } else {
                $message = 'Invalid administrative area';
            }
        } else {
            $message = 'Invalid country';
        }
        echo json_encode([
            'error' => true,
            'status' => 500,
            'message' => $message,
        ]);
    }

    /**
     * Validate if is a AJAX request
     *
     * @param Request $request
     * @throws Exception
     */
    public function validateAjaxRequest(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
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
