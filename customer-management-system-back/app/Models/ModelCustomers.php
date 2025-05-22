<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use PDOException;
use Exception;
use App\Dtos\Customers\DtoCustomersList;
use App\Dtos\Customers\DtoCustomersSearch;
use App\Dtos\Customers\DtoCustomersSort;
use App\Dtos\Customers\DtoCustomersDelete;
use App\Dtos\Customers\DtoCustomersEntry;
use App\Dtos\Customers\DtoCustomersEdit;
use App\Dtos\Customers\DtoCustomersGetCustomer;
use App\Dtos\Customers\DtoCustomersGetCustomers;
use App\Dtos\Customers\DtoCustomersCount;
use App\Error\ErrorCode;
use App\Error\HttpStatus;

class ModelCustomers extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'cust_id';

    const CREATED_AT = 'insert_at';
    const UPDATED_AT = 'update_at';

    protected $fillable = [
        "user_id", "cust_name", "cust_name_kana", "mail_address",
        "phone_number", "sex", "company_id", "born_date",
    ];

    private function wrapDto($data, $class)
    {
        return $data instanceof $class ? $data : new $class($data);
    }

    public function validCheck($dto, bool $isEdit = false): array
    {
        $data = (array) $dto;

        $rules = [
            'cust_name'      => 'required|string|max:32',
            'cust_name_kana' => 'required|string|max:32',
            'mail_address'   => 'required|email',
            'phone_number'   => 'required|string|max:20',
            'sex'            => 'required|in:男性,女性,その他',
            'company_id'     => 'required|integer',
            'born_date'      => 'required|date',
        ];

        // 編集時は「自分自身のメールアドレスを除外」
        if ($isEdit) {
            $rules['mail_address'] .= '|unique:customers,mail_address,' . $dto->cust_id . ',cust_id';
        } else {
            $rules['mail_address'] .= '|unique:customers,mail_address';
        }

        $validator = Validator::make($data, $rules);
        $errorCodes = [];

        if ($validator->fails()) {
            $failedRules = $validator->failed();

            if (isset($failedRules['cust_name']['Required']) || isset($failedRules['cust_name']['Max'])) {
                $errorCodes[] = ErrorCode::ERR_VALID_CUST_NAME;
            }

            if (isset($failedRules['cust_name_kana']['Required']) || isset($failedRules['cust_name_kana']['Max'])) {
                $errorCodes[] = ErrorCode::ERR_VALID_CUST_NAME_KANA;
            }

            if (isset($failedRules['mail_address']['Required']) || isset($failedRules['mail_address']['Email']) || isset($failedRules['mail_address']['Unique'])) {
                $errorCodes[] = ErrorCode::ERR_VALID_CUST_MAIL_ADDRESS;
            }

            if (isset($failedRules['phone_number']['Required']) || isset($failedRules['phone_number']['Max'])) {
                $errorCodes[] = ErrorCode::ERR_VALID_CUST_PHONE_NUMBER;
            }

            if (isset($failedRules['sex']['Required']) || isset($failedRules['sex']['In'])) {
                $errorCodes[] = ErrorCode::ERR_VALID_CUST_SEX;
            }

            if (isset($failedRules['company_id']['Required']) || isset($failedRules['company_id']['Integer'])) {
                $errorCodes[] = ErrorCode::ERR_VALID_CUST_COMPANY_ID;
            }

            if (isset($failedRules['born_date']['Required']) || isset($failedRules['born_date']['Date'])) {
                $errorCodes[] = ErrorCode::ERR_VALID_CUST_BORN_DATE;
            }
        }

        return $errorCodes;
    }

    public function customerEntry($dto): array
    {
        $dto = $this->wrapDto($dto, DtoCustomersEntry::class);

        try {
            $created = $this::create([
                "user_id"        => $dto->user_id,
                "cust_name"      => $dto->cust_name,
                "cust_name_kana" => $dto->cust_name_kana,
                "mail_address"   => $dto->mail_address,
                "phone_number"   => $dto->phone_number,
                "sex"            => $dto->sex,
                "company_id"     => $dto->company_id,
                "born_date"      => $dto->born_date,
            ]);

            return [
                'success' => true,
                'code'    => ErrorCode::SUCCESS,
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'code'    => ErrorCode::ERR_SQL,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'code'    => ErrorCode::ERR_UNKNOWN,
            ];
        }
    }

    public function customerEdit($dto): array
    {
        $dto = $this->wrapDto($dto, DtoCustomersEdit::class);

        try {
            $updatedCount = $this::where('user_id', $dto->user_id)
                ->where('cust_id', $dto->cust_id)
                ->update([
                    'cust_name'      => $dto->cust_name,
                    'cust_name_kana' => $dto->cust_name_kana,
                    'mail_address'   => $dto->mail_address,
                    'phone_number'   => $dto->phone_number,
                    'sex'            => $dto->sex,
                    'company_id'     => $dto->company_id,
                    'born_date'      => $dto->born_date,
                ]);

            return [
                'success' => $updatedCount > 0,
                'code'    => $updatedCount > 0 ? ErrorCode::SUCCESS : ErrorCode::ERR_DATA_NOT_FOUND,
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'code'    => ErrorCode::ERR_SQL,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'code'    => ErrorCode::ERR_UNKNOWN,
            ];
        }
    }

    public function customerDelete($dto): array
    {
        $dto = $this->wrapDto($dto, DtoCustomersDelete::class);

        try {
            $deletedCount = $this::where('user_id', $dto->user_id)
                ->where('cust_id', $dto->cust_id)
                ->delete();

            return [
                'success' => $deletedCount > 0,
                'code'    => $deletedCount > 0 ? ErrorCode::SUCCESS : ErrorCode::ERR_DATA_NOT_FOUND,
            ];
        } catch (PDOException $e) {
            return [
                'success' => false,
                'code'    => ErrorCode::ERR_SQL,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'code'    => ErrorCode::ERR_UNKNOWN,
            ];
        }
    }

    public function getCustomerIds(int $user_id)
    {
        return $this::where('user_id', $user_id)->pluck("cust_id")->toArray();
    }

    public function getCustomerIncludedCompanyIds(int $user_id)
    {
        return $this::where("user_id", $user_id)->pluck("company_id")->toArray();
    }

    public function isIdIncluded(int $user_id, int $cust_id)
    {
        $ids = $this->getCustomerIds($user_id);
        return in_array($cust_id, $ids);
    }

    public function customerSearch(DtoCustomersSearch $search)
    {
        $query = $this::query();
        $query->where('user_id', $search->user_id);
        if (!empty($search->cust_name)) $query->where('cust_name', 'like', "%{$search->cust_name}%");
        if (!empty($search->cust_name_kana)) $query->where('cust_name_kana', 'like', "%{$search->cust_name_kana}%");
        if (!empty($search->sex)) $query->where('sex', $search->sex);
        if (!empty($search->company_id)) $query->where('company_id', $search->company_id);
        if (!empty($search->born_year)) $query->whereYear('born_date', $search->born_year);
        if (!empty($search->born_month)) $query->whereMonth('born_date', $search->born_month);
        if (!empty($search->born_date)) $query->whereDay('born_date', $search->born_date);
        return $query;
    }

    public function customerSort(DtoCustomersSort $sort, $disp_data)
    {
        $sort_key = $sort->sort_key ?? 'cust_id';
        $sort_order = $sort->sort_order === '昇順' ? 'asc' : 'desc';
        if (!empty($sort_key)) $disp_data->orderBy($sort_key, $sort_order);
        return $disp_data;
    }

    public function customerDispNumChange(DtoCustomersList $dto, $disp_data)
    {
        $perPage = $dto->disp_num ?? 10;
        $page = $dto->page_id ?? 1;
        $offset = ($page - 1) * $perPage;
        $disp_data->offset($offset)->limit($perPage);
        return $disp_data;
    }

    public function customerList($dto)
    {
        $dto = $this->wrapDto($dto, DtoCustomersList::class);

        $disp_data = $this->customerSearch($dto->search_data)->with('company');

        if ($disp_data->count() === 0) return collect();

        $disp_data = $this->customerSort($dto->sort_data, $disp_data);
        $disp_data = $this->customerDispNumChange($dto, $disp_data);

        return $disp_data->get()->map(function ($customer) {
            return [
                'cust_id'        => $customer->cust_id,
                'cust_name'      => $customer->cust_name,
                'cust_name_kana' => $customer->cust_name_kana,
                'mail_address'   => $customer->mail_address,
                'phone_number'   => $customer->phone_number,
                'sex'            => $customer->sex,
                'company_id'     => $customer->company_id,
                'company_name'   => $customer->company->company_name ?? '',
                'born_date'      => $customer->born_date,
                'insert_at'      => $customer->insert_at,
                'update_at'      => $customer->update_at,
            ];
        });
    }

    public function customerCount($dto)
    {
        $dto = $this->wrapDto($dto, DtoCustomersCount::class);
        $disp_data = $this->customerSearch($dto->search_data);
        return $disp_data->count();
    }

    public function getCustomer($dto)
    {
        $dto = $this->wrapDto($dto, DtoCustomersGetCustomer::class);
        return $this::where('user_id', $dto->user_id)
            ->where('cust_id', $dto->cust_id)
            ->first();
    }

    public function getCustomers($dto)
    {
        $dto = $this->wrapDto($dto, DtoCustomersGetCustomers::class);
        return $this::where("user_id", $dto->user_id)->get();
    }

    public function company()
    {
        return $this->belongsTo(ModelCompanies::class, 'company_id', 'company_id');
    }
}
