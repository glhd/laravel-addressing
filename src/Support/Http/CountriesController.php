<?php

namespace Galahad\LaravelAddressing\Support\Http;

use Galahad\LaravelAddressing\Entity\Country;
use Galahad\LaravelAddressing\LaravelAddressing;
use Illuminate\Config\Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CountriesController extends Controller
{
    public function __invoke(LaravelAddressing $addressing, Repository $config, Request $request): JsonResponse
    {
        $countries = $addressing->countries($request->input('locale', null));

        return new JsonResponse([
            'label' => 'Countries',
            'options' => $countries->map(static function (Country $country) {
                return $country->getName();
            })->toArray(),
        ], 200);
    }
}
