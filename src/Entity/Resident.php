<?php

namespace App\Entity;

class Resident
{
    private int $id;
    private string $username;
    private ?string $firstname = null;
    private ?string $surname = null;
    private ?string $gender = null;
    private ?string $birthday = null;
    private ?string $address = null;
    private ?string $quote = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): void
    {
        $this->surname = $surname;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    public function setBirthday(?string $birthday): void
    {
        $this->birthday = $birthday;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    public function getQuote(): ?string
    {
        return $this->quote;
    }

    public function setQuote(?string $quote): void
    {
        $this->quote = $quote;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'firstname' => $this->getFirstname(),
            'surname' => $this->getSurname(),
            'gender' => $this->getGender(),
            'birthday' => $this->getBirthday(),
            'address' => $this->getAddress(),
            'quote' => $this->getQuote()
        ];
    }
}