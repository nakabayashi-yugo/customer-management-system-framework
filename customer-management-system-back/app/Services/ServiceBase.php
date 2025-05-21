<?php
    namespace App\Services;

    use App\Error\ErrorCode;
    use App\Error\ErrorMessage;
    use App\Error\HttpStatus;

    class ServiceBase
    {
        protected $messages;

        protected $error_codes = [];
        protected $http_status;

        public function __construct()
        {
            $this->messages = include base_path('app/Error/ErrorMessage.php');
            $this->http_status = HttpStatus::HTTP_OK;
        }

        public function addErrorCode($code)
        {
            if($code == ErrorCode::SUCCESS) return;
            $this->error_codes[] = [
                "error_code" => $code,
                "error_message" => $this->messages[$code] ?? "未定義のエラーメッセージ",
            ];
        }
        public function addErrorCodes(array $codes)
        {
            foreach($codes as $code)
            {
                $this->addErrorCode($code);
            }
        }
        public function setHttpStatus($status) {$this->http_status = $status;}

        public function getHttpStatus()
        {
            return $this->http_status;
        }
        public function getErrorCodes(): array
        {
            return $this->error_codes;
        }

        public function hasErrors(): bool
        {
            return !empty($this->error_codes);
        }
    }
?>