<?php
    namespace App\Dtos\Customers;
    use App\Dtos\Customers\DtoCustomersSearch;
    use App\Dtos\Customers\DtoCustomersSort;

    class DtoCustomersList
    {
        public DtoCustomersSearch $search_data;
        public DtoCustomersSort $sort_data;
        public int $disp_num;
        public int $page_id;
        public function __construct(array $data)
        {
            $this->search_data = new dtoCustomersSearch($data["search_data"] ?? []);
            $this->sort_data = new dtoCustomersSort($data["sort_data"] ?? []);
            $this->disp_num = $data["disp_num"] ?? 10;
            $this->page_id = $data["page_id"] ?? 1;
        }

    }

?>