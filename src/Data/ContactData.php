<?php

namespace App\Data;

use Symfony\Component\Validator\Constraints as Assert;

class ContactData
{
    #[Assert\NotBlank()]
    public string $nom;

    #[Assert\Email(message: "Cette adresse mail n'est pas valide")]
    public string $email;

    #[Assert\NotBlank()]
    public string $message;
}
