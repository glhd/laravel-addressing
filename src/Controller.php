<?php

namespace Galahad\LaravelAddressing;

use Exception;
use Illuminate\Http\Request;

/**
 * Class Controller
 *
 * @package Galahad\LaravelAddressing
 * @author Chris Morrell
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class Controller extends \Illuminate\Routing\Controller
{
    /**
     * @var LaravelAddressing
     */
    protected $addressing;

    /**
     * The construct method
     *
     * @param LaravelAddressing $addressing
     */
    public function __construct()
    {
        $this->addressing = new LaravelAddressing();
    }

    /**
     * Get a json with all the administrative areas by a given country code
     *
     * @param string $countryCode
     * @param string $format
     * @param Request $request
     */
    public function getAdministrativeAreas($countryCode, $format = 'json', Request $request)
	{
		$this->validateAjaxRequest($request);
        $this->checkQueryParameters($request);
        $format = $this->filterFormat($format);
        $country = $this->addressing->getCountryByCode($countryCode);
        if ($country instanceof Country) {
            $admAreas = $country->getAdministrativeAreas();
            if ($format == 'json') {
                echo json_encode([
                    'label' => 'State',
                    'expected_length' => 2,
                    'country' => $countryCode,
                    'options' => $admAreas->toList(),
                    'status' => 200,
                ]);
            }
        } else {
            echo json_encode([
                'error' => true,
                'status' => 404,
                'message' => "Country not found [$countryCode]",
            ]);
        }
	}

    /**
     * Filter a response format
     *
     * @param string $format
     * @return string
     */
    protected function filterFormat($format)
	{
        $format = strtolower(trim($format, '.'));
        $allowed = ['json'];

        return in_array($format, $allowed) ? $format : 'json';
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
