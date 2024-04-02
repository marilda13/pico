<?php

namespace App\Repository;

use App\Entity\Resident;

class ResidentRepository
{
    private const RESIDENT_DATA_FILE_NAME = 'data.json';

    public function findResidentById(int $id): Resident
    {
        $residents = $this->getResidents();

        return $residents[$id];
    }

    /**
     * Create a 'hash table' of residents
     * @return array|Resident[]
     */
    public function getResidents(): array
    {
        $allResidents = $this->importResidentsFromFile();
        $residents = [];
        foreach ($allResidents as $residentData) {
            $residents[$residentData['id']] = $this->createResidentFromArray($residentData);
        }

        return $residents;
    }

    public function add(Resident $newResident): bool
    {
        $residents = $this->importResidentsFromFile();
        $residents[] = $newResident->toArray();

        return $this->writeResidentsToFile($residents);
    }

    public function update(Resident $targetResident): bool
    {
        $residents = $this->importResidentsFromFile();
        for ($i = 0; $i < count($residents); $i++) {
            if ($residents[$i]['id'] == $targetResident->getId()) {
                $residents[$i] = $targetResident->toArray();
                break;
            }
        }

        return $this->writeResidentsToFile($residents);
    }

    public function delete(int $residentId): bool
    {
        if (!$this->residentExists($residentId)) {
            return false;
        }

        $residents = $this->importResidentsFromFile();
        for ($i = 0; $i < count($residents); $i++) {
            if ($residents[$i]['id'] == $residentId) {
                unset($residents[$i]);
                break;
            }
        }

        return $this->writeResidentsToFile($residents);
    }

    public function getNextAvailableId(): ?int
    {
        $residents = $this->getResidents();
        if (count($residents) === 0) {
            return 1;
        }

        return max(array_keys($this->getResidents())) + 1;
    }

    private function residentExists(int $residentId): bool
    {
        $residents = $this->getResidents();
        if (in_array($residentId, array_keys($residents))) {
            return true;
        }

        return false;
    }

    private function createResidentFromArray($residentData): Resident
    {
        $resident = new Resident();

        $resident->setId($residentData['id']);
        $resident->setUsername($residentData['username']);
        $resident->setFirstname($residentData['firstname']);
        $resident->setSurname($residentData['surname']);
        $resident->setBirthday($residentData['birthday']);
        $resident->setGender($residentData['gender']);
        $resident->setAddress($residentData['address']);
        $resident->setQuote($residentData['quote']);

        return $resident;
    }

    public function importResidentsFromFile(): array
    {
        return json_decode(file_get_contents($this->getResidentsFilePath()), true);
    }

    private function writeResidentsToFile(array $residents): bool
    {
        return file_put_contents($this->getResidentsFilePath(), json_encode(array_values($residents), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)) !== false;
    }

    public function getResidentsFilePath(): string
    {
        return __DIR__ . '/../../data/' . self::RESIDENT_DATA_FILE_NAME;
    }
}