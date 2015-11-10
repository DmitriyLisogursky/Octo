<?php
/**
 * Created by PhpStorm.
 * User: Oleksii Volkov
 * Date: 02-Sep-15
 * Time: 17:10
 */

namespace Application\Util;


use Zend\Db\Adapter\Adapter;
use Zend\Http\Request;
use Zend\Log\Logger;
use Zend\Log\Writer\Mail;
use Zend\Log\Writer\Stream;
use Zend\Mail\Message;
use Zend\Mail\Transport\Sendmail;
use Zend\Mvc\Application;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\View\Http\ViewManager;
use Zend\ServiceManager\ServiceManager;
use Zend\View\Exception\RuntimeException;
use Zend\View\Helper\Placeholder\Container;
use Zend\View\Model\ViewModel;

class ZendErrorsHandler {

    public function __invoke(MvcEvent $e) {
        /** @var ServiceManager $sm */
        $sm = $e->getTarget()->getServiceManager();
        $error = error_get_last() ?: $e->getError();

        try {
            /** @var Adapter $dbInstance */
            $dbInstance = $sm->get('Zend\Db\Adapter\Adapter');
            $dbInstance->getDriver()->getConnection()->connect();
        } catch (\Exception $ex) {
            self::logError($ex, 'DB');
            self::mailError($ex, 'DB Error');

            include ROOT_PATH . '/module/Application/view/error/custom.phtml';

            die;
        }

        if ($error == Application::ERROR_EXCEPTION) {
            /** @var RuntimeException $exception */
            $exception = $e->getParam('exception');
            $logText = " Error ZF in file : " . $exception->getFile() . " with message : " .
                $exception->getMessage() . " at line : " . $exception->getLine();

            self::logError($logText, 'ZF');
            self::mailError($logText, 'ZF Error');
        }

        if ($error == Application::ERROR_CONTROLLER_NOT_FOUND) {
            $logText = 'The requested controller '
                . $e->getRouteMatch()->getParam('controller') . '  could not be mapped to an existing controller class.';

            self::logError($logText, 'ZF');
            self::mailError($logText, 'ZF Error');
        }

        if ($error == Application::ERROR_CONTROLLER_INVALID) {
            $logText = 'The requested controller '
                . $e->getRouteMatch()->getParam('controller') . ' is not dispatchable';

            self::logError($logText, 'ZF');
            self::mailError($logText, 'ZF Error');
        }

        if ($error == Application::ERROR_ROUTER_NO_MATCH) {
            /** @var Request $request */
            $request = $e->getRequest();
            $targetUrl = $request->getUri();
            $logText = 'The requested URL (' . $targetUrl . ') could not be matched by routing.';

            self::logError($logText, 'ZF');
            //self::mailError($logText, 'ZF Error');
        }

        if (is_array($error)) {
            $this->handlePHPErrors($error);
        }

        if (!empty($error)) {
            echo $this->buildView($sm, $error);

            die;
        }
    }

    public function handleControllerCannotDispatchRequest(MvcEvent $e) {
        $action = $e->getRouteMatch()->getParam('action');
        $controller = get_class($e->getTarget());

        if (!method_exists($e->getTarget(), $action . 'Action')) {
            $logText = 'The requested controller ' .
                $controller . ' was unable to dispatch the request : ' . $action . 'Action';

            self::logError($logText, 'ZF');
            self::mailError($logText, 'ZF Error');

            include ROOT_PATH . '/module/Application/view/error/custom.phtml';

            die;
        }
    }

    private function handlePHPErrors($error) {
        $typeStr = null;

        switch ($error['type']) {

            case E_ERROR: // 1 //
                $typeStr = 'E_ERROR';
                break;
            case E_WARNING: // 2 //
                $typeStr = 'E_WARNING';
                break;
            case E_PARSE: // 4 //
                $typeStr = 'E_PARSE';
                break;
            case E_NOTICE: // 8 //
                $typeStr = 'E_NOTICE';
                break;
            case E_CORE_ERROR: // 16 //
                $typeStr = 'E_CORE_ERROR';
                break;
            case E_CORE_WARNING: // 32 //
                $typeStr = 'E_CORE_WARNING';
                break;
            case E_COMPILE_ERROR: // 64 //
                $typeStr = 'E_COMPILE_ERROR';
                break;
            case E_COMPILE_WARNING: // 128 //
                $typeStr = 'E_COMPILE_WARNING';
                break;
            case E_USER_ERROR: // 256 //
                $typeStr = 'E_USER_ERROR';
                break;
            case E_USER_WARNING: // 512 //
                $typeStr = 'E_USER_WARNING';
                break;
            case E_USER_NOTICE: // 1024 //
                $typeStr = 'E_USER_NOTICE';
                break;
            case E_STRICT: // 2048 //
                $typeStr = 'E_STRICT';
                break;
            case E_RECOVERABLE_ERROR: // 4096 //
                $typeStr = 'E_RECOVERABLE_ERROR';
                break;
            case E_DEPRECATED: // 8192 //
                $typeStr = 'E_DEPRECATED';
                break;
            case E_USER_DEPRECATED: // 16384 //
                $typeStr = 'E_USER_DEPRECATED';
                break;
        }

        $logText = 'Error PHP in file : ' . $error['file'] . ' at line : ' . $error['line'] . '
         with type error : ' . $typeStr . ' : ' . $error['message'] . ' in ' . $_SERVER['REQUEST_URI'];

        self::logError($logText, 'PHP');
        self::mailError($logText, 'PHP Error');
    }

    static function logError($logText, $type = 'error') {
        $writer = new Stream('./data/logs/' . date('Y-m-d') . '-' . $type . '-log.txt');
        $logger = new Logger();

        $logger->addWriter($writer);

        $logger->err($logText);
    }

    static function mailError($mailText, $type = 'Error') {
        $mail = new Message();
        $logger = new Logger();

        $mail->setFrom('no@reply.com', 'Octo');
        $mail->addTo('oleksijvolkov@gmail.com', 'Oleksii Volkov');

        $transport = new Sendmail();
        $writerMail = new Mail($mail, $transport);

        $writerMail->setSubjectPrependText($type);

        $logger->addWriter($writerMail);

        $logger->err($mailText);
    }

    /**
     * @param ServiceManager $sm
     * @param $error
     * @return string
     */
    private function buildView($sm, $error) {
        /** @var ViewManager $viewManager */
        $viewManager = $sm->get('ViewManager');
        $renderer = $viewManager->getRenderer();

        $renderer->headTitle()->setContainer(new Container());
        $renderer->headMeta()->setContainer(new Container());
        $renderer->headLink()->setContainer(new Container());

        $content = new ViewModel(array(
            'badRoute' => ($error == Application::ERROR_ROUTER_NO_MATCH)
        ));
        $content->setTemplate('error/custom');

        return $renderer->render($content);
    }
}