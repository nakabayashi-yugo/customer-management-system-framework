import { useState } from "react";
import useModalController from "../modal_controller";
import CompaniesEditModal from "../modal/modal_company_edit";

export default function CompaniesEditPage() {
  const {
    currentModal,
    editCompanyId,
    openCompanyList,
    openCompanyEntry,
    openCompanyEdit,
    closeModal,
  } = useModalController();
  const [isEditOpen, setIsEditOpen] = useState(false);

  const handleOpen = (companyId) => {
    setIsEditOpen(true);
  };

  const handleClose = () => {
    setIsEditOpen(false);
  };

  const handleEdit = () => {
    console.log("編集処理実行 for ID:", editCompanyId);
    handleClose();
  };

  const handleBack = () => {
    console.log("一覧に戻る");
    handleClose();
    // 必要なら一覧開く処理追加
  };

  return (
    <div>
      <CompaniesEditModal
        isOpen={currentModal === "edit"}
        companyId={editCompanyId}
        onClose={handleClose}
        onEdit={handleEdit}
        onBack={handleBack}
      />
    </div>
  );
}
