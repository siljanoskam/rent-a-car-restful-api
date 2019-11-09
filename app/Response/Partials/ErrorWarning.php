<?php

namespace App\Response\Partials;

use App\Traits\ExceptionCode;
use Illuminate\Support\Facades\Lang;

/**
 * The object definition for outputting errors/warnings.
 */
class ErrorWarning
{
    /**
     * The API error code
     * @var string
     */
    public $code;

    /**
     * The short message for the error/warning.
     * @var string
     */
    public $shortMessage;

    /**
     * A longer message for the error/warning.
     * @var string
     */
    public $longMessage;

    /**
     * The list of fields that are causing errors/warnings.
     * @var array
     */
    public $fields;

    /**
     * Stores the language file name for obtaining error messages translations.
     * @var string
     */
    private $translationFile;

    private $errorMessageFormatShort;
    private $errorMessageFormatLong;

    public function __construct(
        string $code = '',
        string $shortMessage = '',
        string $longMessage = '',
        array $fields = []
    ) {
        $this->code = $code;
        $this->shortMessage = $shortMessage;
        $this->longMessage = $longMessage;
        $this->fields = $fields;
        $this->errorMessageFormatShort = config('app.errorMessageFormatShort');
        $this->errorMessageFormatLong  = config('app.errorMessageFormatLong');
    }

    /**
     * The API error code
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $this->getApiErrorCode($code);
    }

    /**
     * The short message for the error/warning.
     * @param string $shortMessage The error message to output.
     */
    public function setShortMessage(string $shortMessage)
    {
        $this->shortMessage = $shortMessage;
    }

    /**
     * The short message for the error/warning.
     *
     * @param string|int $shortErrorCode The short error code. Meaning only the XXXX
     *                               on the full error code: NC_API_XXXXXX.
     * @param string $translationFile The name where of the file where the error
     *                                message translation was set.
     */
    public function setShortMessageTranslation($shortErrorCode, string $translationFile = null)
    {
        $this->shortMessage = Lang::trans(sprintf($this->errorMessageFormatShort, $translationFile, $this->getApiErrorCode($shortErrorCode)));
    }

    /**
     * A longer message for the error/warning.
     * @param string $longMessage The long message to output.
     */
    public function setLongMessage(string $longMessage)
    {
        $this->longMessage = $longMessage;
    }

    /**
     * A longer message for the error/warning.
     *
     * @param string|int $shortErrorCode The short error code. Meaning only the XXXX
     *                               on the full error code: NC_API_XXXXXX.
     * @param string $translationFile The name where of the file where the error
     *                                message translation was set.
     */
    public function setLongMessageTranslation($shortErrorCode, string $translationFile = null)
    {
        $this->longMessage = Lang::trans(sprintf($this->errorMessageFormatLong, $translationFile, $this->getApiErrorCode($shortErrorCode)));
    }

    /**
     * A shortcut method to call other methods to generate error messages.
     *
     * @param string|int $shortErrorCode The short error code. Meaning only the XXXX
     *                               on the full error code: NC_API_XXXXXX.
     * @param string $translationFile The name where of the file where the error
     *                                message translation was set.
     */
    public function setMessagesTranslation($shortErrorCode, string $translationFile = null)
    {
        $this->setShortMessageTranslation($this->getApiErrorCode($shortErrorCode), $translationFile);
        $this->setLongMessageTranslation($this->getApiErrorCode($shortErrorCode), $translationFile);
    }

    /**
     * Set the list of fields that are causing errors/warnings.
     * Will override if any fields are already set.
     * @param string[] $fields The list of fields that are causing errors/warnings.
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;
    }

    /**
     * Add a single field that is causing error/warning.
     * If the field already exists, it will be ignored.
     * @param string $field The field causing errors/warnings.
     */
    public function addField(string $field)
    {
        // verify if it exists
        if (!in_array($field, $this->fields, true)) {
            $this->fields[] = $field;
        }
    }

    /**
     * Gets the error code for the api consumers.
     * If the code cannot be obtained or already is a string, no changes are made.
     *
     * @param string|int $errorCode The error code
     *
     * @return string|int
     */
    private function getApiErrorCode($errorCode)
    {
        if (is_int($errorCode)) {
            $apiError = ExceptionCode::errorCodeString($errorCode);
            return $apiError ?: $errorCode;
        }
        return $errorCode;
    }
}
