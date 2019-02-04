<?php
/*
 * This file is part of the Weather app.
 *
 * (c) Kestutis Risovas
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Services;

use Twig\Environment;

class RestDataParser
{
    /** @var Environment */
    private $twigEnv;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Parses data from provider.
     *
     * @param string $restData
     * @return array
     */
    public function parseData($restData)
    {

        $result = [];
        $id = uniqid();
        if(!empty($restData['name'])){
            $result['success']['tab_head'] = $this->twig
                ->createTemplate('{% from "cities/macros.html.twig" import nav_tab %}{{ nav_tab(city,id) }}')
                ->render([
                    'city' => $restData['name'],
                    'id' => $id
                ]);
        }else return ['warning' => ['No Data found.']];

        $result['success']['tab_cont'] = $this->twig
            ->createTemplate('{% from "cities/macros.html.twig" import tab_cont %}{{ tab_cont(city,id,data) }}')
            ->render([
                'city' => $restData['name'],
                'id' => $id,
                'data' => $restData
            ]);

        return $result;
    }

}
