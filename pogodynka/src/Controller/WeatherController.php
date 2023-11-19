<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\WeatherRepository;
use App\Service\WeatherUtil;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{country}/{name}', name: 'app_weather', requirements: ['id' => '\d+'])] 
    public function city(
        #[MapEntity(mapping: ['country' => 'country', 'name' => 'name'])] 
        Location $location, WeatherUtil $util): Response 
    { 
        $weather = $util->getWeatherForLocation($location);

        return $this->render('weather/city.html.twig', [ 
            'location' => $location, 
            'weather' => $weather, 
        ]); 
    } 
}
