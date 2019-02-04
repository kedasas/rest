<?php
/**
 * Created by PhpStorm.
 * User: Kestas
 * Date: 2019.02.01
 * Time: 14:14
 */

namespace App\Tests\Services;

use App\Services\RestDataProvider;
use PHPUnit\Framework\TestCase;

class RestDataProviderTest extends TestCase
{
    private $providerUri = 'http://api.openweathermap.org/data/2.5/weather';
    private $queryParams = ['query' => ['APPID' => '4d800409acd8cb956f2a31c7e0110946', 'q' => 'Vilnius' ]];


    public function testGetProviderData()
    {
        //init provider
        $dataProvider = new RestDataProvider($this->providerUri);
        //get results
        $results = $dataProvider->getRestData($this->queryParams);
        //checks
        //check if array is not empty
        $this->assertNotEmpty($results,'The result array is empty');
        //check for error key in array
        $this->assertArrayNotHasKey('error', $results,"There is an 'error' in array");

    }

}
