<?php
namespace App\Dtos\Companies;

class DtoCompaniesEdit
{
    public ?int $user_id;
    public ?int $company_id;
    public ?string $company_name;

    public function __construct(array $data)
    {
        $this->user_id = $data["user_id"] ?? null;
        $this->company_id = $data["company_id"] ?? null;
        $this->company_name = $data["company_name"] ?? null;
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'company_id' => $this->company_id,
            'company_name' => $this->company_name,
        ];
    }
}
?>
