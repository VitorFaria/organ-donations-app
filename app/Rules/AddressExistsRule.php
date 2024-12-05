<?php

namespace App\Rules;

use App\Models\Address;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Request;

class AddressExistsRule implements ValidationRule
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $data = $this->request->all();

        $hasAddress = Address::where('zip_code', $data['zip_code'])
            ->where('street', $data['street'])
            ->where('neighbourhood', $data['neighbourhood'])
            ->where('city', $data['city'])
            ->where('state', $data['state'])
            ->where('house_number', $data['house_number'])
            ->count() > 0;
        
        if ($hasAddress) $fail("Endereço já cadastrado na nossa base.");
    }
}
