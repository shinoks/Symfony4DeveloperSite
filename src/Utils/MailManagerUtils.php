<?php
namespace App\Utils;

use App\Entity\Config;
use Doctrine\ORM\EntityManagerInterface;

class MailManagerUtils
{
    protected $mailer;
    protected $twig;
    protected $em;
    protected $config;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Send email
     *
     * @param   string   $template      email template
     * @param   mixed    $parameters    custom params for template
     * @param   string   $to            to email address or array of email addresses
     *
     * @return  boolean                 send status
     */
    public function sendEmail($template, $parameters, $to, \Swift_Mailer $mailer, $files = null)
    {
        $this->config = $this->em->getRepository(Config::class)->findOneBy(['id'=>'1']);
        $from = $this->config->getEmail();
        $fromName = $this->config->getTitle();
        $subject  = $parameters['subject'];


        try {
            $message = (new \Swift_Message())
                ->setSubject($subject)
                ->setFrom($from, $fromName)
                ->setTo($to)
                ->setBody($template, 'text/html')
            ;
            if($files){
                foreach($files as $file){
                    $message->attach(\Swift_Attachment::fromPath($file));
                }
            }
            $response = $mailer->send($message);

        } catch (\Exception $ex) {
            return $ex->getMessage();
        }

        return $response;
    }
}
