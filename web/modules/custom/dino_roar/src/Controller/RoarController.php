<?php

namespace Drupal\dino_roar\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\dino_roar\Jurassic\RoarGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class RoarController extends ControllerBase
{
    /**
     * @var RoarGenerator
     */
    private $roarGenerator;
    /**
     * @var LoggerChannelFactoryInterface
     */
    public $loggerFactory;

    public function __construct(RoarGenerator $roarGenerator, LoggerChannelFactoryInterface $loggerFactory)
    {
        $this->roarGenerator = $roarGenerator;
        $this->loggerFactory = $loggerFactory;
    }

    public static function create(ContainerInterface $container)
    {
        $roarGenerator = $container->get('dino_roar.roar_generator');
        $loggerFactory = $container->get('logger.factory');

        return new static($roarGenerator, $loggerFactory);
    }

    public function roar($count)
    {
        $roar = $this->roarGenerator->getRoar($count);
        $this->loggerFactory->get('default')
            ->debug($roar);
        
        return [
            '#theme' => 'pagina_2',
            '#test_var' => $this->t($roar)/*,
            '#attached' => [
                'library' => 'dino_roar/dino_roar.roar',
                'drupalSettings' => [
                    'dino_roar' => [],
                    'dino_roar.roar' => [],
                ],
            ]*/
          ];
        //return new Response($roar);
    }
}
