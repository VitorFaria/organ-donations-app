<?php

namespace App\Rules;

use App\Models\Hospital;
use App\Models\Patient;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;

class AssignAddressRule implements ValidationRule
{
    protected $request;
    protected $addressId;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->addressId = $request->route('id');
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $oneEntityOnlyMessage = 'Apenas uma das entidades podem ser selecionadas para este endereço.';
        $addressAlreadyAssignedMessage = 'Este endereço já foi selecionado';

        if (!empty($this->request->user_id) && !empty($this->request->hospital_id)) {
            $fail($oneEntityOnlyMessage);
        }

        if ($attribute == 'hospital_id' && !empty($value)) {
            $patient = new Patient();
            $addressAlreadyAssigned = $this->checkIfAddressIsAlreadyAssigned($patient);
            if ($addressAlreadyAssigned) $fail($addressAlreadyAssignedMessage);
        }

        if ($attribute == 'user_id' && !empty($value)) {
            $hospital = new Hospital();
            $addressAlreadyAssigned = $this->checkIfAddressIsAlreadyAssigned($hospital);
            if ($addressAlreadyAssigned) $fail($addressAlreadyAssignedMessage);
        }
    }

    private function checkIfAddressIsAlreadyAssigned(Patient|Hospital $entity): bool
    {
        return $entity::where('address_id', $this->addressId)->count() > 0;
    }
}
