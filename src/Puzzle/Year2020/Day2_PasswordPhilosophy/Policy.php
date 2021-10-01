<?php

namespace App\Puzzle\Year2020\Day2_PasswordPhilosophy;

interface Policy
{
    /**
     * Validate password obeys the policy rules
     * @param string $password
     * @return bool
     */
    public function validPassword(string $password): bool;
}