import { useState } from "react";
import useModalController from "../modal_controller";
import CompaniesEntryModal from "../modal/modal_company_entry";

export default function CompaniesEntryPage() {
  const {
    currentModal,
    editCompanyId,
    openCompanyList,
    openCompanyEntry,
    openCompanyEdit,
    closeModal,
  } = useModalController();
  const [isEntryOpen, setIsEntryOpen] = useState(false);

  const handleOpen = () => setIsEntryOpen(true);
  const handleClose = () => setIsEntryOpen(false);

  const handleRegister = () => {
    console.log("登録処理実行");
    handleClose();
  };

  const handleBack = () => {
    console.log("一覧に戻る");
    handleClose();
    // 必要なら一覧を開く処理追加
  };

  return (
    <div>
      <CompaniesEntryModal
        isOpen={currentModal === "entry"}
        onClose={handleClose}
        onRegister={handleRegister}
        onBack={handleBack}
      />
    </div>
  );
}
