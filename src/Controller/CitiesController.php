<?php
/*
 * This file is part of the Weather app.
 *
 * (c) Kestutis Risovas
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Services\RestDataProvider;
use App\Services\RestDataParser;


class CitiesController extends AbstractController
{
    /**
     * @Route("/", name="cities")
     */
    public function indexAction(Request $request, RestDataProvider $dataProvider, RestDataParser $dataParser){

        if($request->isMethod('POST')){

            /** @var  $result */
            $result = [];
            $params = [];

            /**
             * Simple validation.
             */
            if(!$request->get('Apiid')){
                $this->validateErrors[] = 'Field Api Id is required.';
            }

            if(!$request->get('City')){
                $this->validateErrors[] = 'Field City is required.';
            }

            if(!empty($this->validateErrors)){
                return new JsonResponse(['warning' => $this->validateErrors]);
            }

            $this->params['query'] = [
                'APPID' => $request->get('Apiid'),
                'q' => $request->get('City')
            ];

            /**
             * Getting results from data provider.
             */
            $result = $dataProvider->getRestData($this->params);

            /**
             * Checking results from data provider.
             */
            if(!$result){
                return new JsonResponse(['warning' => ['No Data found.']]);
            }elseif(!empty($result['error'])){
                return new JsonResponse(['error' => $result['error']]);
            }

            /**
             * Parsing data provider results.
             */
            return new JsonResponse($dataParser->parseData($result));
        }

        return $this->render('cities/index.hml.twig');
    }

}
