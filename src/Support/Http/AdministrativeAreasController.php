<?php

namespace Galahad\LaravelAddressing\Support\Http;

use Galahad\LaravelAddressing\Entity\Subdivision;
use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Config\Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdministrativeAreasController extends Controller
{
	public function __invoke(LaravelAddressing $addressing, Repository $config, Request $request, string $country_code): JsonResponse
	{
		$country = $addressing->country($country_code, $request->input('locale', null));
		
		if (!$country) {
			throw new NotFoundHttpException("No country found for code '{$country_code}'");
		}
		
		$address_format = $country->addressFormat();
		
		$administrative_areas = $country->administrativeAreas();
		
		return new JsonResponse([
			'label' => ucwords(Str::plural($address_format->getAdministrativeAreaType() ?? 'state', $administrative_areas->count())),
			'country_code' => $country_code,
			'options' => $administrative_areas
				->map(static function(Subdivision $admin_area) {
					return $admin_area->getName();
				})
				->toArray(),
		], 200);
	}
}
