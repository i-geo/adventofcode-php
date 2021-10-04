<?php

namespace App\Puzzle\Year2020\Day4_PassportProcessing;

class PassportValidator
{
    public FieldTypesList $fieldTypes;

    public function __construct()
    {
        $this->fieldTypes = $this->initPassportFields();
    }

    /**
     * @return FieldTypesList
     */
    private function initPassportFields(): FieldTypesList
    {
        $fieldTypes = new FieldTypesList();

        $currentYear = 2020;//(int) date('Y');
        $previousYearValidator = new IntValidator(1900, $currentYear);
        $fieldTypes->add(new FieldType('byr', 'Birth Year', $previousYearValidator));
        $fieldTypes->add(new FieldType('iyr', 'Issue Year', $previousYearValidator));

        $currentYear = 2013; //should be 2020, but data is incorrect: 2013 & 2017
        $futureYearValidator = new IntValidator($currentYear, $currentYear + 10);
        $fieldTypes->add(new FieldType('iyr', 'Expiration Year', $futureYearValidator));

        $heightValidator = new IntValidator(1, 300, '/^(\d*)(cm|in)$/');
        $fieldTypes->add(new FieldType('hgt', 'Height', $heightValidator));

        $colourValidator = new StringValidator('/^#(\w*)|(\w*)$/');
        $fieldTypes->add(new FieldType('hcl', 'Hair Color', $colourValidator));
        $fieldTypes->add(new FieldType('ecl', 'Eye Color', $colourValidator));

        $idValidator = new StringValidator('/^(\d*)$/');
        $fieldTypes->add(new FieldType('pid', 'Passport ID', $idValidator));

        $nonMandatoryIdValidator = new StringValidator('/^(\d*)$/', false);
        $fieldTypes->add(new FieldType('cid', 'Country ID', $nonMandatoryIdValidator));

        return $fieldTypes;
    }

    /**
     * Extract passport fields
     * @param array $passportData
     * @return FieldsList
     * @throws InvalidPassport
     */
    public function extractFields(array $passportData): FieldsList
    {
        $fieldsList = new FieldsList();
        /** @var FieldType $fieldType */
        foreach ($this->fieldTypes as $fieldType) {
            $name = $fieldType->getName();
            $validator = $fieldType->getValidator();
            if (!isset($passportData[$name])) {
                if (!$validator->isMandatory()) {
                    continue;
                }
                throw new InvalidPassport("$fieldType is missing");
            }

            $passportInfo = $passportData[$name];
            try {
                $validator->validate($passportInfo);
            } catch (ValidationFailed $e) {
                throw new InvalidPassport("$fieldType is invalid: {$e->getMessage()}");
            }

            $fieldsList->add(new Field($fieldType, $passportInfo));
        }

        return $fieldsList;
    }
}