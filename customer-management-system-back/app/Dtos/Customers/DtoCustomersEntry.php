<?php
namespace App\Dtos\Customers;

class DtoCustomersEntry
{
    public ?int $user_id;
    public ?string $cust_name;
    public ?string $cust_name_kana;
    public ?string $mail_address;
    public ?string $phone_number;
    public ?string $sex;
    public ?int $company_id;
    public ?string $born_date;

    public function __construct(array $data)
    {
        $this->user_id = $data["user_id"] ?? null;
        $this->cust_name = $data["cust_name"] ?? null;
        $this->cust_name_kana = $data["cust_name_kana"] ?? null;
        $this->mail_address = $data["mail_address"] ?? null;
        $this->phone_number = $data["phone_number"] ?? null;
        $this->sex = $data["sex"] ?? null;
        $this->company_id = $data["company_id"] ?? null;
        $this->born_date = $data["born_date"] ?? null;
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'cust_name' => $this->cust_name,
            'cust_name_kana' => $this->cust_name_kana,
            'mail_address' => $this->mail_address,
            'phone_number' => $this->phone_number,
            'sex' => $this->sex,
            'company_id' => $this->company_id,
            'born_date' => $this->born_date,
        ];
    }
}
?>
