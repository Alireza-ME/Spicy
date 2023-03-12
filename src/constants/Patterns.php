<?php

namespace spicy\constants;

class Patterns
{

    //get imports pattern
    const IMPORTS = '#SPICY.IMPORT{(.*)}#';

    const CODES = '/#\s?SPICY.CODE_START(.*)SPICY.CODE_END/s';

    const ARGS = 'SPICY_ARG';

}