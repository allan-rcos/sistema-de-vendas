<?php

namespace App\Form\Model;

use App\Validator\Username;

class ConfirmExclusionFormModel
{
    #[Username]
    public string $confirm;
}