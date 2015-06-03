<?php
namespace Application\Listeners;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\MvcEvent;

/**
 * @author doug@unlikelysource.com
 */
class HtmlCompressionListener implements ListenerAggregateInterface
{
    
    use ListenerAggregateTrait;

    /**
     * {@inheritdoc}
     */
    public function attach(EventManagerInterface $event)
    {
        $this->listeners[] = $event->getSharedManager()->attach(
            '*',
            MvcEvent::EVENT_FINISH,
            [$this, 'compressHtml']
        );
    }

    /**
     * Perform HTML compression
     *
     * @param MvcEvent $e
     */
    public function compressHtml(MvcEvent $e)
    {
        $response   = $e->getResponse();
        $content    = $response->getBody();
        $compressed = $this->_compress($content);
        file_put_contents('/var/www/test/before.txt', $content);
        file_put_contents('/var/www/test/after.txt', $compressed);
        $response->setContent($compressed);
    }    

    // See more at: https://arjunphp.com/how-to-compress-html-output-in-zend-framework-2/#sthash.x7oK4heX.dpuf
    private function _compress($content)
    {
        $search = array(
            '/(\ )+/', // shorten multiple whitespace sequences
            '/[\n\r\t]/'
            //"/($tb)",
            //'#(?://)?<![CDATA[(.*?)(?://)?]]>#s' //leave CDATA alone
        );
        $replace = array(
            ' ',
            '',
            //'',
            //"//<![CDATA[n".'1'."n//]]>"
        );
        return  preg_replace($search, $replace, $content);
    }
    
}
