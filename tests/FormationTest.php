<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Formation;

/**
 * Description of FormationTest
 *
 * @author Jamil
 */
class FormationTest extends TestCase {
    
    public function testGetPublishedAtString() {
        $formation = new Formation();
        $formation->setPublishedAt(new \DateTime("2022-02-15"));
        $this->assertEquals("15/02/2022", $formation->getPublishedAtString());
    }
    
}
