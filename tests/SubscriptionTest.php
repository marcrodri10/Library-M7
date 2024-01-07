<?php

use PHPUnit\Framework\TestCase;
use App\Model\Subscription;
use App\Model\Card;
use App\Model\Payment;
use App\Registry;
use App\Database\QueryBuilder;
use App\Database\Connection;

class SubscriptionTest extends TestCase
{
    /* public function testSubscriptionAttributes()
    {
        //user data
        $user_id = 1;
        $amount = 1;
        $date = '2024-01-10';

        //card data
        $cardName = 'Marc Rodriguez';

        
    } */
    public function testgetUserCard(){
        $queryBuilderMock = $this->getMockBuilder(QueryBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Mock de Connection
        $connectionMock = $this->getMockBuilder(Connection::class)
            ->disableOriginalConstructor()
            ->getMock();

        // Configurar el mock de QueryBuilder para devolver el resultado esperado
        $queryBuilderMock->method('selectAll')
            ->willReturn('Resultado simulado de la base de datos');

        // Configurar el mock de Connection para devolver el mock de QueryBuilder
        $connectionMock->method('make')
            ->willReturn($queryBuilderMock);

        // Registrar los mocks en el contenedor de servicios (Registry)
        Registry::bind('config', require 'config.php');
        Registry::bind('database', $connectionMock);

        // Instanciar el controlador y llamar a la función de prueba
        /* $card_fields = [
            'name' => 'Marc Rodriguez',
            'card' => $_POST['card'],
            'cvv' => $_POST['cvv'],
            'user_id' => Session::getSession('user_data')->getId()
        ];
 */
        // Realizar las aserciones sobre el resultado
        $this->assertEquals('Resultado simulado de la base de datos', $result);
        
    }
}
