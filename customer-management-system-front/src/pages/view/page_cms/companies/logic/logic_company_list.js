import { useState } from "react";
import useModalController from "../modal_controller";
import CompaniesListModal from "../modal/modal_company_list";

export default function CompaniesListPage() {
  const {
    currentModal,
    editCompanyId,
    openCompanyList,
    openCompanyEntry,
    openCompanyEdit,
    closeModal,
  } = useModalController();

  const handleClose = () => {
    console.log("閉じる処理実行");
  };

  const handleEntryOpen = () => {
    console.log("会社登録へ切り替え");
    // 会社登録用モーダル開く処理ここに追加
  };

  return (
    <div>
      <CompaniesListModal
        isOpen={currentModal === "list"}
        onClose={handleClose}
        onEntryOpen={handleEntryOpen}
      />
    </div>
  );
}
