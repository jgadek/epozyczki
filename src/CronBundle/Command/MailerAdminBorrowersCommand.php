<?php

namespace CronBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MailerAdminBorrowersCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
                ->setName('mailer:admin:borrowers')
                ->setDescription('Wysyłka nowych pożyczkobiorców do administratora')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $objContainer = $this->getContainer();
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $objContainer->get('doctrine')->getManager();

        $view = $objContainer->get('templating')->render('CronBundle:Email:adminBorrowers.html.twig', array(
            'users' => $em->getRepository('AppGuardBundle:GuardUser')->getNewBorrowers(),
        ));
        $this->sendEmailAdmin('epozyczki.pl - lista nowych pożyczkobiorców', $view);
    }

    public function sendEmailAdmin($subject, $body)
    {
        $send = FALSE;
        if ($this->getContainer()->hasParameter('mailer_available') && $this->getContainer()->getParameter('mailer_available') === TRUE && $this->getContainer()->hasParameter('mailer_admin_list')) {
            $arrTo = $this->getContainer()->getParameter('mailer_admin_list');
            $from = array($this->getContainer()->getParameter('mailer_user') => 'epozyczki.pl');
            $message = \Swift_Message::newInstance()
                    ->setSubject($subject)
                    ->setFrom($from)
                    ->setTo($arrTo)
                    ->setBody($body)
                    ->setContentType("text/html");
            $send = $this->getContainer()->get('mailer')->send($message);
        }
        return $send ? TRUE : FALSE;
    }

}
