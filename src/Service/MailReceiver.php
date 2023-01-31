<?php
// src/Service/MailReceiver.php
namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class MailReceiver {
    private $params;

    public function __construct(ContainerBagInterface $params)
    {
        $this->params = $params;
    }

    private static function array_elements_after(array $array, string $pattern): array {
        $return = [];
        $found = false;
        foreach ($array as $element) {
            if ($found) {
                $return[] = $element;
            }
            if (preg_match($pattern, $element) === 1) {
                $found = true;
            }
        }

        return $return;
    }

    private static function array_elements_before(array $array, string $pattern): array {
        $return = [];
        $found = false;
        foreach ($array as $element) {
            if (preg_match($pattern, $element) === 1) {
                $found = true;
            }
            if (!$found) {
                $return[] = $element;
            }

        }

        return $return;
    }

    public function getMails(): array {

        $messages = [];

        $connection = imap_open($this->params->get("imap.url"), $this->params->get("imap.username"), $this->params->get("imap.password")) or throw new \RuntimeException(imap_last_error());

        $emailData = imap_search($connection, 'ALL');
        foreach ($emailData as $emailIdent) {

            $rawMessage = imap_fetchbody($connection, $emailIdent, '');
            $lines = explode(PHP_EOL, $rawMessage);

            $separator = false;
            $fullContent = self::array_elements_after($lines, '/^\s*$/');

            $plainContent = self::array_elements_before(self::array_elements_after($fullContent, '/^\s*$/'), '/^--/');

            $content = implode(PHP_EOL, $plainContent);
            $overview = imap_fetch_overview($connection, $emailIdent, 0);

            $messages[] = [
                "subject" => iconv_mime_decode($overview[0]->subject,ICONV_MIME_DECODE_CONTINUE_ON_ERROR,"UTF-8"),
                "body" => imap_utf8(trim(quoted_printable_decode($content))),
                "date" => strtotime($overview[0]->date)
            ];


        }
        imap_close($connection);

        return $messages;
    }
}
