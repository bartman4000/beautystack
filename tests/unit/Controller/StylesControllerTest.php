<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\Tests\unit\Controller;

use App\Controller\StylesController;
use App\Entity\Style;
use App\Entity\Tag;
use App\Repository\StyleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class StylesControllerTest extends TestCase
{
    public function testIndex()
    {
        $style1 = $this->getStyle(
            '725eb4f4-7601-478b-afad-310a700672c8',
            'Rainbow',
            ['nailart','rainbow','gelnailart'],
            'Mica gave me rainbow tips! I love them. I\'m on the way to AFROPUNK Brooklyn !!',
            '2018-08-20 18:03:09',
            Style::STATUS_PUBLISHED
        );

        $style2 = $this->getStyle(
            '748859ee-5550-4b5c-8c54-226d45dca6b2',
            'GOLD PUNK',
            ['nailart','gelnailart','foils','gold','black', 'rainbow'],
            'I\'m going AFROPUNK and wanted punk with a bit of glam !!',
            '2018-08-20 18:15:20',
            Style::STATUS_PUBLISHED
        );

        $expectedJson = '[{"id":"725eb4f4-7601-478b-afad-310a700672c8","name":"Rainbow","description":"Mica gave me rainbow tips! I love them. I\u0027m on the way to AFROPUNK Brooklyn !!","tags":["nailart","rainbow","gelnailart"],"dateCreated":"2018-08-20 18:03:09","status":"PUBLISHED"},{"id":"748859ee-5550-4b5c-8c54-226d45dca6b2","name":"GOLD PUNK","description":"I\u0027m going AFROPUNK and wanted punk with a bit of glam !!","tags":["nailart","gelnailart","foils","gold","black","rainbow"],"dateCreated":"2018-08-20 18:15:20","status":"PUBLISHED"}]';


        /** @var Request|\PHPUnit_Framework_MockObject_MockObject $requestMock */
        $requestMock = $this->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();
        $requestMock->query = new ParameterBag(['search' => 'rainbow']);


        /** @var StyleRepository|\PHPUnit_Framework_MockObject_MockObject $requestMock $objectRepository */
        $styleRepositoryMock = $this->getMockBuilder(StyleRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $styleRepositoryMock->expects(self::exactly(1))
            ->method('findByWord')
            ->with('rainbow')
            ->willReturn([$style1, $style2]);


        /** @var ObjectManager|\PHPUnit_Framework_MockObject_MockObject $objectManagerMock */
        $objectManagerMock = $this->getMockBuilder(ObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $objectManagerMock->expects(self::exactly(1))
            ->method('getRepository')
            ->with(Style::class)
            ->willReturn($styleRepositoryMock);


        $controller = new StylesController();
        /** @var ContainerInterface|\PHPUnit_Framework_MockObject_MockObject $containerMock */
        $containerMock = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $containerMock->expects(self::exactly(1))
            ->method('has')
            ->with('serializer')
            ->willReturn(false);
        $controller->setContainer($containerMock);
        $response = $controller->index($requestMock, $objectManagerMock);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertCount(2, json_decode($response->getContent(), true));
        $this->assertEquals($expectedJson, $response->getContent());
    }

    /**
     * @param string $guid
     * @param string $name
     * @param array $tags
     * @param string $description
     * @param string $datetime
     * @param string $status
     * @param bool $deleted
     * @return Style
     */
    protected function getStyle(string $guid, string $name, array $tags, string $description, string $datetime, string $status, bool $deleted = false): Style
    {
        $style = new Style();
        $style->setGuid($guid);
        $style->setName($name);
        foreach ($tags as $tag) {
            $style->addTag(new Tag($tag));
        }
        $style->setDescription($description);
        $style->setDateCreated(new \DateTime($datetime));
        $style->setStatus($status);
        $style->setDeleted($deleted);
        return $style;
    }
}
