<?php
namespace UserContacts\Tests;

use Artists\Entity\ArtistEntity;

class AlbumCreatorTest extends \PHPUnit\Framework\TestCase
{
    public function testA()
    {
        $artist = new ArtistEntity();
        $artist->setArtistName('Micky');
        $albumParams = ['title'=>'Testing' ,
            'releaseDate'=> new \DateTime('1999-01-01')];

        $entitymock = $this->getMockBuilder(\Doctrine\ORM\EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}