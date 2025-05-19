<?php
namespace App\Dtos\Companies;

class DtoCompaniesDelete
{
    public ?int $user_id;
    public ?int $company_id;

    public function __construct(array $data)
    {
        $this->user_id = $data["user_id"] ?? null;
        $this->company_id = $data["company_id"] ?? null;
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
        ];
    }
}
?>
