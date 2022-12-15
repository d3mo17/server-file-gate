<?php

namespace DMo\ServerFileGate\Service;

class NoAuthAdapter implements AuthInterface
{
    function accessDenied() : bool
    {
        return false;
    }
}
