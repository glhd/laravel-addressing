<?php

namespace Galahad\LaravelAddressing;

use CommerceGuys\Intl\Exception\UnknownCountryException;
use Exception;
use Galahad\LaravelAddressing\Collection\LocalityCollection;
use Illuminate\Http\JsonResponse;
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
	 *
	 * @param LaravelAddressing $addressing
	 */
	public function __construct(LaravelAddressing $addressing)
	{
		$this->addressing = $addressing;
	}
	
	/**
	 * Get a json with all the administrative areas by a given country code
	 *
	 * @param string $countryCode
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function getAdministrativeAreas(Request $request, $countryCode)
	{
		$this->checkQueryParameters($request);
		try {
			$country = $this->addressing->country($countryCode);
			
			return new JsonResponse([
				'label' => 'State',
				'expected_length' => 2,
				'country' => $countryCode,
				'options' => $country->getAdministrativeAreasList(),
			], 200);
		} catch (UnknownCountryException $exception) {
			return new JsonResponse([
				'error' => true,
				'message' => "Country not found [$countryCode]",
			], 404);
		}
	}
	
	/**
	 * Get all countries as JSON list
	 *
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function getCountries(Request $request)
	{
		$this->checkQueryParameters($request);
		$countries = $this->addressing->countriesList();
		if (count($countries) > 0) {
			return new JsonResponse([
				'label' => 'Countries',
				'options' => $countries,
			], 200);
		} else {
			return new JsonResponse([
				'error' => true,
				'message' => "Could not get countries",
			], 500);
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
