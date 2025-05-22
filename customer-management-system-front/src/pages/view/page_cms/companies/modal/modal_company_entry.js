import { useState, useEffect } from 'react';

import { dtoCompaniesEntry } from "./../../../../dto/companies/dto_companies_entry.ts";

import { validCheck } from './../other/companies_service.js';
import { errorAlert } from "./../../../error_alert.js";

export default function CompaniesEntryModal({ isOpen, onClose, onBack }) {
  const [name, setName] = useState("");

  const onEntry = async () => {
    const api_url = "http://localhost/nakabayashi_system_training/cms_framework/customer-management-system-back/public/api/companies/entry";
    try {
      const send_data = new dtoCompaniesEntry();
      send_data.company_name = name;

      //フロント側のバリチェ
      const errors = validCheck(send_data);
      if(errors)
      {
        alert(errors);
        return;
      }

      const response_api = await fetch(api_url, {
          method: "POST",
          headers: {
              "Content-Type": "application/json"
          },
          body: JSON.stringify(send_data),
          credentials: 'include',
      });
      if (!response_api.ok) {
        throw new Error("API失敗：" + response_api.status);
      }
      const result = await response_api.json();
      if(result.success == true) 
      {
          alert("会社情報の登録に成功しました。");
      }
      else
      {
        errorAlert(result.errors);
      }
    } catch(error) {
        console.error("新規会社登録失敗", error);
    }
  }

  if (!isOpen) return null;

  return (
    <div className="modal-company-entry modal" id="modal-company-entry">
      <div className="modal-main-wrappar">
        <div className="modal-main-header">
          <span className="modal-close-button" onClick={onClose}>&times;</span>
          <div className="modal-main-title">
            <h2>所属会社登録</h2>
          </div>
        </div>

        <div className="modal-main-content">
          <div className="modal-content-entry-input">
            <table className="modal-entry-input-table" bgcolor="#a9a9a9">
              <tbody>
                <tr className="modal-entry-input-name" style={{ height: "24px" }} align="center">
                  <th width="100px" bgcolor="#D3D3D3">会社名</th>
                  <td className="modal-entry-input-form-name" width="200px" bgcolor="#FFFFFF">
                    <input 
                    type="text" 
                    id="modal-entry-input-name" 
                    name="company-name"
                    placeholder="株式会社○○" 
                    value={name} 
                    onChange={(e) => setName(e.target.value)} />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div className="modal-content-entry">
            <button className="modal-entry-button entry-button button" id="modal-entry-button" onClick={onEntry}>
              登録
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
