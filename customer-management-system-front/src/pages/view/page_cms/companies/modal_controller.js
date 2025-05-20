import { useState } from "react";

export default function useModalController() {
  const [currentModal, setCurrentModal] = useState(null);
  const [editCompanyId, setEditCompanyId] = useState(null);

  const openCompanyList = () => setCurrentModal("list");
  const openCompanyEntry = () => setCurrentModal("entry");
  const openCompanyEdit = (companyId) => {
    setEditCompanyId(companyId);
    setCurrentModal("edit");
  };
  const closeModal = () => setCurrentModal(null);

  return {
    currentModal,
    editCompanyId,
    openCompanyList,
    openCompanyEntry,
    openCompanyEdit,
    closeModal,
  };
}