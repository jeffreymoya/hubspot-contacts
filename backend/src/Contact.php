<?php
namespace App;

class Contact {
    public function __construct(
        public string $id,
        public string $email,
        public string $firstName,
        public string $lastName,
        public string $becameACustomerDate,
        public string $becameALeadDate
    ) {}

    public static function fromResponse(array $contactData): self {
        $id = $contactData['id'];
        $email = $contactData['properties']['email'];
        $firstName = $contactData['properties']['firstname'];
        $lastName = $contactData['properties']['lastname'];
        $becameACustomerDate = strtotime($contactData['createdAt']);
        $becameALeadDate = strtotime($contactData['updatedAt']);

        return new self($id, $email, $firstName, $lastName, $becameACustomerDate, $becameALeadDate);
    }
}