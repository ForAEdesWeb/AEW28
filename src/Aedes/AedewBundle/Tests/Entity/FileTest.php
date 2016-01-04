<?php

namespace Aedes\AedewBundle\Tests\Entity;

class FileTest extends \Aedes\AedewBundle\Tests\AedewTestCase
{
    private $file;

    public function setUp()
    {
        parent::setUp();

        $this->file = new \Aedes\AedewBundle\Entity\File();
    }

    public function testSetFileType()
    {
        $error = "nothing error";

        try {
            $this->file->setType("img");
        } catch (\Exception $exc) {
            $error = $exc->getMessage();
        }

        $this->assertEquals($error, "nothing error");

        $error = "nothing error";

        try {
            $this->file->setType("file");
        } catch (\Exception $exc) {
            $error = $exc->getMessage();
        }

        $this->assertEquals($error, "nothing error");

        $error = "nothing error";

        try {
            $this->file->setType("dir");
        } catch (\Exception $exc) {
            $error = $exc->getMessage();
        }

        $this->assertEquals($error, "nothing error");

        $error = "nothing error";

        try {
            $this->file->setType("error");
        } catch (\Exception $exc) {
            $error = $exc->getMessage();
        }

        $this->assertEquals($error, "file type only can be img, file, dir, msg");
    }
}