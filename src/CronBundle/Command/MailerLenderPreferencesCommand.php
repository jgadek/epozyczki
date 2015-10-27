<?php

namespace CronBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MailerLenderPreferencesCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
                ->setName('mailer:lender:preferences')
                ->setDescription('Wysyłka wniosków do pożyczkodawców')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $objContainer = $this->getContainer();
        /* @var $em \Doctrine\ORM\EntityManager */
        $em = $objContainer->get('doctrine')->getManager();

        $arrLenders = $em->getRepository('AppGuardBundle:GuardUser')->createQueryBuilder('gu')
                ->where('gu.roles LIKE :role')
                ->setParameter('role', '%"' . \App\GuardBundle\Entity\GuardUser::ROLE_LENDER . '"%')
                ->getQuery()
                ->execute();
        /* @var $objLender \App\GuardBundle\Entity\GuardUser */
        foreach ($arrLenders as $objLender) {
            $view = $objContainer->get('templating')->render('CronBundle:Email:lenderPreferences.html.twig', array(
                'credits' => $em->getRepository('DataBundle:Credit')->getByPreferencesLender($objLender),
                'lender' => $objLender,
            ));
            $this->sendEmail($objLender, 'epozyczki.pl - lista wniosków o pożyczkę', $view);
        }
    }

    public function sendEmail($collUsers, $subject, $body)
    {
        $send = FALSE;
        $collUsers = is_array($collUsers) ? $collUsers : array($collUsers);
        if ($this->getContainer()->hasParameter('mailer_available') && $this->getContainer()->getParameter('mailer_available') === TRUE) {
            $arrTo = array();
            foreach ($collUsers as $objUser) {
                /* @var $objUser GuardUser  */
                $arrTo[] = $objUser->getEmail();
            }
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
