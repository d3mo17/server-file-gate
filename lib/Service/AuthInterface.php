<?php

namespace DMo\ServerFileGate\Service;

interface AuthInterface
{
    function accessDenied() : bool;
}
