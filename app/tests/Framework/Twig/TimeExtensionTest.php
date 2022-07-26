<?php
namespace Tests\Framework\Twig;

use cavernos\bascode_api\Framework\Twig\TimeExtension;
use DateTime;
use PHPUnit\Framework\TestCase;

class TimeExtensionTest extends TestCase  {
        
    /**
     * textExtension
     *
     * @var TimeExtension
     */
    private $timeExtension;
    
    protected function setUp(): void
    {
        $this->timeExtension = new TimeExtension();
    }
    

    public function testDateFormat(){
        $date = new DateTime();
        $format = 'd/m/Y H:i';
        $result = '<span class="timeago" datetime="'. $date->format(DateTime::ISO8601). '">' . $date->format($format) . '</span>';
        $this->assertEquals($result , $this->timeExtension->ago($date));
    }
}