<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Dtos\Companies\DtoCompaniesGetCompany;
use App\Dtos\Companies\DtoCompaniesList;
use App\Dtos\Companies\DtoCompaniesDelete;
use App\Dtos\Companies\DtoCompaniesEntry;
use App\Dtos\Companies\DtoCompaniesEdit;
use App\Error\ErrorCode;

class ModelCompanies extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'company_id';

    const CREATED_AT = 'insert_at';
    const UPDATED_AT = 'update_at';

    protected $fillable = ["user_id", "company_name"];

    private function wrapDto($data, $class)
    {
        return $data instanceof $class ? $data : new $class($data);
    }

    public function validCheck($data): array
    {
        $data = (array) $data;

        $rules = [
            'company_name' => 'required|string|max:100|unique:companies,company_name',
        ];

        $validator = Validator::make($data, $rules);
        $errorCodes = [];

        if ($validator->fails()) {
            $failedRules = $validator->failed();

            if (isset($failedRules['company_name']['Required']) || isset($failedRules['company_name']['Max'])) {
                $errorCodes[] = ErrorCode::ERR_VALID_CAMP_NAME;
            } elseif (isset($failedRules['company_name']['Unique'])) {
                $errorCodes[] = ErrorCode::ERR_VALID_CAMP_NAME_OVERLAP;
            }
        }

        return $errorCodes;
    }

    public function getCompany($data)
    {
        $dto = $this->wrapDto($data, DtoCompaniesGetCompany::class);
        return $this::where("user_id", $dto->user_id)
                    ->where("company_id", $dto->company_id)
                    ->first();
    }

    public function getCompanyIds(int $user_id)
    {
        return $this::where("user_id", $user_id)->pluck("company_id")->toArray();
    }

    public function companyList($data)
    {
        $dto = $this->wrapDto($data, DtoCompaniesList::class);
        return $this::where("user_id", $dto->user_id)->get();
    }

    public function companyDelete($data)
    {
        $dto = $this->wrapDto($data, DtoCompaniesDelete::class);
        $deletedCount = $this::where("user_id", $dto->user_id)
                            ->where("company_id", $dto->company_id)
                            ->delete();
        return $deletedCount > 0 ? ["success" => true] : [];
    }

    public function companyEntry($data)
    {
        $dto = $this->wrapDto($data, DtoCompaniesEntry::class);
        $created = $this::create([
            "user_id"      => $dto->user_id,
            "company_name" => $dto->company_name,
        ]);
        return $created ? ["success" => true] : [];
    }

    public function companyEdit($data)
    {
        $dto = $this->wrapDto($data, DtoCompaniesEdit::class);
        $updatedCount = $this::where('user_id', $dto->user_id)
                            ->where('company_id', $dto->company_id)
                            ->update([
                                'company_name' => $dto->company_name,
                            ]);
        return $updatedCount > 0 ? ["success" => true] : [];
    }

    public function deleteValidCheck($data): array
    {
        $dto = $this->wrapDto($data, DtoCompaniesDelete::class);
        $model_customers = new ModelCustomers();
        $valid_customer_company_ids = $model_customers->getCustomerIncludedCompanyIds($dto->user_id);

        if (in_array($dto->company_id, $valid_customer_company_ids)) {
            return [ErrorCode::ERR_VALID_CAMP_DELETE];
        }

        return [];
    }
}
