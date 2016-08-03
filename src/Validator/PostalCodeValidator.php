<?php

namespace Galahad\LaravelAddressing\Validator;

use Illuminate\Validation\Validator;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class PostalCodeValidator
 *
 * @package Galahad\LaravelAddressing\Validator
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class PostalCodeValidator extends Validator
{
    /**
     * @param TranslatorInterface $translator
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     */
    public function __construct(
        TranslatorInterface $translator,
        array $data = [],
        array $rules = [],
        array $messages = [],
        array $customAttributes = []
    ) {
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);
    }
}