<?php

namespace BrunoGrosdidier\Blog\src\Service;

class SendEmail
{
    private $subjectToMe;
    private $messageToMe;
    private $userEmail;
    private $userName;
    private $subjectToUser;
    private $messageToUser;

    public function sendEmailToMe($subjectToMe, $messageToMe)
    {
        // Create the Transport (Exp)
        $transport = (new \Swift_SmtpTransport(EMAIL_HOST, EMAIL_PORT))
            ->setUsername(EMAIL_USERNAME)
            ->setPassword(EMAIL_PASSWORD)
            ->setEncryption(EMAIL_ENCRYPTION) //For Gmail
        ;

        // Create the Mailer using your created Transport
        $mailer = (new \Swift_Mailer($transport));

        // Create a message (Dest)
        $message = (new \Swift_Message($subjectToMe))
            ->setFrom([EMAIL_USERNAME => EMAIL_SUBJECT])
            ->setTo([EMAIL_DEST_1, EMAIL_DEST_2 => EMAIL_DEST_NAME])
            ->setBody($messageToMe, 'text/html')
        ;

        // Send the message
        $result = $mailer->send($message);

        return $result;
    }

    public function sendEmailToUser($userEmail, $userName, $subjectToUser, $messageToUser)
    {
        // Create the Transport (Exp)
        $transport = (new \Swift_SmtpTransport(EMAIL_HOST, EMAIL_PORT))
            ->setUsername(EMAIL_USERNAME)
            ->setPassword(EMAIL_PASSWORD)
            ->setEncryption(EMAIL_ENCRYPTION) //For Gmail
        ;

        // Create the Mailer using your created Transport
        $mailer = (new \Swift_Mailer($transport));

        // Create a message (Dest)
        $message = (new \Swift_Message($subjectToUser))
            ->setFrom([EMAIL_USERNAME => EMAIL_SUBJECT])
            ->setTo([$userEmail, $userEmail => $userName])
            ->setBody($messageToUser, 'text/html')
        ;

        // Send the message
        $result = $mailer->send($message);

        return $result;
    }
}
