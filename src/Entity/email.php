<?php
// Load Composer's autoloader
require_once './vendor/autoload.php';

// Import Classess
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email;

// Create a Transport object
$transport = Transport::fromDsn('smtp://tn.ebadel@gmail.com:iixxcjrhvqhymado@smtp.gmail.com:587');

// Create a Mailer object
$mailer = new Mailer($transport);

// Create an Email object
$email = (new Email());

// Set the "From address"
$email->from('tn.ebadel@gmail.com');

// Set the "To address"
$email->to(
    'allala.azaiz@gmail.com'
    # 'email2@gmail.com',
    # 'email3@gmail.com'
);

// Set "CC"
# $email->cc('cc@example.com');
// Set "BCC"
# $email->bcc('bcc@example.com');
// Set "Reply To"
# $email->replyTo('fabien@example.com');
// Set "Priority"
# $email->priority(Email::PRIORITY_HIGH);

// Set a "subject"
$email->subject('A Cool Subject!');

// Set the plain-text "Body"
$email->text('The plain text version of the message.');

// Set HTML "Body"
$email->html('
    <h1 style="color: #fff300; background-color: #0073ff; width: 500px; padding: 16px 0; text-align: center; border-radius: 50px;">
    The HTML version of the message.
    </h1>
');

    $mailer->send($email);

