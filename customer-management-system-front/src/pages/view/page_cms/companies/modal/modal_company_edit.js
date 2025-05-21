import { useState, useEffect, useRef } from 'react';

import { getCompany } from "./../other/companies_service";
import { dtoCompaniesEdit } from "./../../../../dto/companies/dto_companies_edit.ts";

export default function CompaniesEditModal({ isOpen, companyId, onClose, onBack }) {
  const [name, setName] = useState("");
  const prevIsOpen = useRef(false); // 前回の isOpen を保持

  useEffect(() => {
    // 前が false で、今が true（つまり開かれた瞬間）
    if (!prevIsOpen.current && isOpen) {
      onGetCompany(companyId);
    }
    prevIsOpen.current = isOpen; // 現在の状態を保存
  }, [isOpen]);

  const onGetCompany = async (company_id) => {
    const company = await getCompany(company_id);
    setName(company.company_name);
  }

  const onEdit = async () => {
    const api_url = "http://localhost/nakabayashi_system_training/cms_framework/customer-management-system-back/public/api/companies/edit";
    try {
      const send_data = new dtoCompaniesEdit();
      send_data.company_id = companyId;
      send_data.company_name = name;
      console.log(send_data);

      const response_api = await fetch(api_url, {
          method: "POST",
          headers: {
              "Content-Type": "application/json"
          },
          body: JSON.stringify(send_data),
          credentials: 'include',
      });
      const result = await response_api.json();
      if(result.success == true) 
      {
          alert("顧客情報の登録に成功しました。");
      }
    } catch(error) {
        console.error("登録失敗", error);
    }
  }

  if (!isOpen) return null;

  return (
    <div className="modal-company-edit modal" id="modal-company-edit">
      <div className="modal-main-wrappar">
        <div className="modal-main-header">
          <span className="modal-close-button" onClick={onClose}>&times;</span>
          <div className="modal-main-title">
            <h2>所属会社編集</h2>
          </div>
        </div>

        <div className="modal-main-content">
          <div className="modal-content-edit-input">
            <table className="modal-edit-input-table" bgcolor="#a9a9a9">
              <tbody>
                <tr className="modal-edit-input-name" style={{ height: "24px" }} align="center">
                  <th width="100px" bgcolor="#D3D3D3">会社名</th>
                  <td className="modal-edit-input-form-name" width="200px" bgcolor="#FFFFFF">
                    <input type="hidden" id="modal-edit-input-id" value={companyId} readOnly />
                    <input type="text" id="modal-edit-input-name" value={name} onChange={(e) => setName(e.target.value)}/>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div className="modal-content-edit">
            <button className="modal-edit-button edit-button button" id="modal-edit-button" onClick={onEdit}>
              編集
            </button>
          </div>

          <div className="modal-content-return">
            <button className="modal-return-button button" onClick={onBack}>
              戻る
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
